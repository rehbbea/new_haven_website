<?php
namespace EdgeCore\CPT\Portfolio\Shortcodes;

use EdgeCore\Lib;

/**
 * Class PortfolioList
 * @package EdgeCore\CPT\Portfolio\Shortcodes
 */
class HorizontallyScrollingPortfolioList implements Lib\ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'edgt_horizontally_scrolling_portfolio_list';

        add_action('vc_before_init', array($this, 'vcMap'));

	    //Portfolio category filter
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_category_callback', array( &$this, 'portfolioCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Portfolio category render
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_category_render', array( &$this, 'portfolioCategoryAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Portfolio selected projects filter
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_selected_projects_callback', array( &$this, 'portfolioIdAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Portfolio selected projects render
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_selected_projects_render', array( &$this, 'portfolioIdAutocompleteRender', ), 10, 1 ); // Render exact portfolio. Must return an array (label,value)

	    //Portfolio tag filter
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_tag_callback', array( &$this, 'portfolioTagAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

	    //Portfolio tag render
	    add_filter( 'vc_autocomplete_edgt_horizontally_scrolling_portfolio_list_tag_render', array( &$this, 'portfolioTagAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer
     *
     * @see vc_map
     */
    public function vcMap() {
	    if(function_exists('vc_map')) {
		    vc_map( array(
				    'name'                      => esc_html__( 'Edge Horizontally Scrolling Portfolio List', 'edge-core' ),
				    'base'                      => $this->getBase(),
				    'category'                  => esc_html__( 'by EDGE', 'edge-core' ),
				    'icon'                      => 'icon-wpb-horizontally-scrolling-portfolio-list extended-custom-icon',
				    'allowed_container_element' => 'vc_row',
				    'params'                    => array(

					    array(
						    'type'        => 'textfield',
						    'param_name'  => 'number_of_items',
						    'heading'     => esc_html__( 'Number of Portfolios Per Page', 'edge-core' ),
						    'description' => esc_html__( 'Set number of items for your portfolio list. Enter -1 to show all.', 'edge-core' ),
						    'value'       => '-1'
					    ),
					    array(
						    'type'        => 'dropdown',
						    'param_name'  => 'image_proportions',
						    'heading'     => esc_html__( 'Image Proportions', 'edge-core' ),
						    'value'       => array(
							    esc_html__( 'Original', 'edge-core' )  => 'full',
							    esc_html__( 'Square', 'edge-core' )    => 'square',
							    esc_html__( 'Landscape', 'edge-core' ) => 'landscape',
							    esc_html__( 'Portrait', 'edge-core' )  => 'portrait',
							    esc_html__( 'Medium', 'edge-core' )    => 'medium',
							    esc_html__( 'Large', 'edge-core' )     => 'large'
						    ),
						    'description' => esc_html__( 'Set image proportions for your portfolio list. Also this option will apply to masonry type if you do not set any option in Portfolio Single page for image proportion.', 'edge-core' )
					    ),
					    array(
						    'type'        => 'autocomplete',
						    'param_name'  => 'category',
						    'heading'     => esc_html__( 'One-Category Portfolio List', 'edge-core' ),
						    'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'edge-core' )
					    ),
					    array(
						    'type'        => 'autocomplete',
						    'param_name'  => 'selected_projects',
						    'heading'     => esc_html__( 'Show Only Projects with Listed IDs', 'edge-core' ),
						    'settings'    => array(
							    'multiple'      => true,
							    'sortable'      => true,
							    'unique_values' => true
						    ),
						    'description' => esc_html__( 'Delimit ID numbers by comma (leave empty for all)', 'edge-core' )
					    ),
					    array(
						    'type'        => 'autocomplete',
						    'param_name'  => 'tag',
						    'heading'     => esc_html__( 'One-Tag Portfolio List', 'edge-core' ),
						    'description' => esc_html__( 'Enter one tag slug (leave empty for showing all tags)', 'edge-core' )
					    ),
					    array(
						    'type'        => 'dropdown',
						    'param_name'  => 'order_by',
						    'heading'     => esc_html__( 'Order By', 'edge-core' ),
						    'value'       => array(
							    esc_html__( 'Date', 'edge-core' )       => 'date',
							    esc_html__( 'Menu Order', 'edge-core' ) => 'menu_order',
							    esc_html__( 'Random', 'edge-core' )     => 'rand',
							    esc_html__( 'Slug', 'edge-core' )       => 'name',
							    esc_html__( 'Title', 'edge-core' )      => 'title'
						    )
					    ),
					    array(
						    'type'        => 'dropdown',
						    'param_name'  => 'order',
						    'heading'     => esc_html__( 'Order', 'edge-core' ),
						    'value'       => array(
							    esc_html__( 'ASC', 'edge-core' )  => 'ASC',
							    esc_html__( 'DESC', 'edge-core' ) => 'DESC',
						    )
					    ),
						array(
							'type' => 'attach_image',
							'heading' => esc_html__('Cover Image', 'edge-core'),
							'param_name' => 'cover_image',
                            'group'       => esc_html__('Cover Options', 'edge-core')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('Cover Image Title', 'edge-core'),
							'param_name' => 'cover_image_title',
                            'group'       => esc_html__('Cover Options', 'edge-core')
						),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Cover Image Subtitle', 'edge-core'),
                            'param_name' => 'cover_image_subtitle',
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Button One Text', 'edge-core'),
                            'param_name' => 'cover_image_button_one',
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__('Button One Link', 'edge-core'),
                            'param_name'  => 'cover_image_button_one_link',
                            'description' => '',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'cover_image_button_one',
                                'not_empty' => true
                            ),
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__('Button One Target', 'edge-core'),
                            'param_name'  => 'cover_button_one_target',
                            'value'       => array(
                                ''      => '',
                                'Self'  => '_self',
                                'Blank' => '_blank'
                            ),
                            'description' => '',
                            'dependency'  => array(
                                'element' => 'cover_image_button_one_link',
                                'not_empty' => true
                            ),
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Button Two Text', 'edge-core'),
                            'param_name' => 'cover_image_button_two',
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__('Button Two Link', 'edge-core'),
                            'param_name'  => 'cover_image_button_two_link',
                            'description' => '',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'cover_image_button_two',
                                'not_empty' => true
                            ),
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__('Button Two Target', 'edge-core'),
                            'param_name'  => 'cover_image_button_two_target',
                            'value'       => array(
                                ''      => '',
                                'Self'  => '_self',
                                'Blank' => '_blank'
                            ),
                            'description' => '',
                            'dependency'  => array(
                                'element' => 'cover_image_button_two_link',
                                'not_empty' => true
                            ),
                            'group'       => esc_html__('Cover Options', 'edge-core')
                        ),
				    )
			    )
		    );
	    }
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     * @return string
     */
    public function render($atts, $content = null) {
        $args = array(
	        'number_of_items'           => '-1',
            'image_proportions'         => 'full',
            'category'                  => '',
            'selected_projects'         => '',
	        'tag'                       => '',
            'order_by'                  => 'date',
            'order'                     => 'ASC',
            'cover_image'               => '',
            'cover_image_title'         => '',
            'cover_image_subtitle'      => '',
            'cover_image_button_one'    => '',
            'cover_image_button_one_link'    => '',
            'cover_image_button_one_target'    => '',
            'cover_image_button_two'    => '',
            'cover_image_button_two_link'    => '',
            'cover_image_button_two_target'    => ''
        );

		$params = shortcode_atts($args, $atts);
		extract($params);

		$query_array = $this->getQueryArray($params);
		$query_results = new \WP_Query($query_array);
		$params['query_results'] = $query_results;
		$params['number_of_items_in_query'] = $query_results->post_count;

		$params['number_of_items_per_row'] = $this->getNumberOfItemsPerRow($params);
	    $params['this_object'] = $this;
	    $params['cover_image_params'] = $this->getCoverImageParams($params);
	    $html = edgt_core_get_shortcode_module_template_part('portfolio-scrolling-horizontally-portfolio-list/templates/horizontally-scrolling-portfolio-holder', 'portfolio', '', $params);

        return $html;
	}

	/**
    * Generates portfolio list query attribute array
    *
    * @param $params
    *
    * @return array
    */
	public function getQueryArray($params){
		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'portfolio-item',
			'posts_per_page' => $params['number_of_items'],
			'orderby'        => $params['order_by'],
			'order'          => $params['order']
		);

		if(!empty($params['category'])){
			$query_array['portfolio-category'] = $params['category'];
		}

		$project_ids = null;
		if (!empty($params['selected_projects'])) {
			$project_ids = explode(',', $params['selected_projects']);
			$query_array['post__in'] = $project_ids;
		}

		if(!empty($params['tag'])){
			$query_array['portfolio-tag'] = $params['tag'];
		}

		if(!empty($params['next_page'])){
			$query_array['paged'] = $params['next_page'];
		} else {
			$query_array['paged'] = 1;
		}

		return $query_array;
	}
	
	/**
    * Generates portfolio image size
    *
    * @param $params
    *
    * @return string
    */
	public function getImageSize($params){
		$thumb_size = 'full';

		if (!empty($params['image_proportions'])) {
			$image_size = $params['image_proportions'];

			switch ($image_size) {
				case 'landscape':
					$thumb_size = 'eldritch_edge_landscape';
					break;
				case 'portrait':
					$thumb_size = 'eldritch_edge_portrait';
					break;
				case 'square':
					$thumb_size = 'eldritch_edge_square';
					break;
				case 'medium':
					$thumb_size = 'medium';
					break;
				case 'large':
					$thumb_size = 'large';
					break;
				case 'full':
					$thumb_size = 'full';
					break;
			}
		}

		return $thumb_size;
	}

	public function getItemLink($params){
        $id = $params['current_id'];
        $portfolio_link = get_permalink($id);

        if (get_post_meta($id, 'portfolio_external_link',true) !== ''){
            $portfolio_link = get_post_meta($id, 'portfolio_external_link',true);
        }

        return $portfolio_link;
    }

	public function getNumberOfItemsPerRow($params){

		$nopr = $params['number_of_items_in_query'];

		if($nopr % 3 != 0) {
			$nopr = $nopr + 1;
			if($nopr % 3 != 0) {
				$nopr = $nopr + 1;
			}
		}

		return $nopr/3;

	}


	/**
	 * Filter portfolio categories
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioCategoryAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos       = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS portfolio_category_title
			FROM {$wpdb->terms} AS a
			LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
			WHERE b.taxonomy = 'portfolio-category' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['portfolio_category_title'] ) > 0 ) ? esc_html__( 'Category', 'edge-core' ) . ': ' . $value['portfolio_category_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio category by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioCategoryAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio category
			$portfolio_category = get_term_by( 'slug', $query, 'portfolio-category' );
			if ( is_object( $portfolio_category ) ) {

				$portfolio_category_slug = $portfolio_category->slug;
				$portfolio_category_title = $portfolio_category->name;

				$portfolio_category_title_display = '';
				if ( ! empty( $portfolio_category_title ) ) {
					$portfolio_category_title_display = esc_html__( 'Category', 'edge-core' ) . ': ' . $portfolio_category_title;
				}

				$data          = array();
				$data['value'] = $portfolio_category_slug;
				$data['label'] = $portfolio_category_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter portfolios by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$portfolio_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = 'portfolio-item' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $portfolio_id > 0 ? $portfolio_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'edge-core' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'edge-core' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio
			$portfolio = get_post( (int) $query );
			if ( ! is_wp_error( $portfolio ) ) {

				$portfolio_id = $portfolio->ID;
				$portfolio_title = $portfolio->post_title;

				$portfolio_title_display = '';
				if ( ! empty( $portfolio_title ) ) {
					$portfolio_title_display = ' - ' . esc_html__( 'Title', 'edge-core' ) . ': ' . $portfolio_title;
				}

				$portfolio_id_display = esc_html__( 'Id', 'edge-core' ) . ': ' . $portfolio_id;

				$data          = array();
				$data['value'] = $portfolio_id;
				$data['label'] = $portfolio_id_display . $portfolio_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter portfolio tags
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioTagAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS portfolio_tag_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'portfolio-tag' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['portfolio_tag_title'] ) > 0 ) ? esc_html__( 'Tag', 'edge-core' ) . ': ' . $value['portfolio_tag_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio tag by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioTagAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio category
			$portfolio_tag = get_term_by( 'slug', $query, 'portfolio-tag' );
			if ( is_object( $portfolio_tag ) ) {

				$portfolio_tag_slug = $portfolio_tag->slug;
				$portfolio_tag_title = $portfolio_tag->name;

				$portfolio_tag_title_display = '';
				if ( ! empty( $portfolio_tag_title ) ) {
					$portfolio_tag_title_display = esc_html__( 'Tag', 'edge-core' ) . ': ' . $portfolio_tag_title;
				}

				$data          = array();
				$data['value'] = $portfolio_tag_slug;
				$data['label'] = $portfolio_tag_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

    /**
     * This function passing params for cover image
     *
     * @param $params
     *
     * @return array
     */
    private function getCoverImageParams($params) {

	    $cover_image_params = array();

        $cover_image_params['cover_image'] = $params['cover_image'];
        $cover_image_params['cover_image_title'] = $params['cover_image_title'];
        $cover_image_params['cover_image_subtitle'] = $params['cover_image_subtitle'];

        $button_params_array1 = array();
        $button_params_array2 = array();

        $button_params_array1['type'] = 'white';
        $button_params_array1['hover_type'] = 'white-outline';

        $button_params_array2['type'] = 'white-outline';
        $button_params_array2['hover_type'] = 'white';

        if (!empty($params['cover_image_button_one'])) {
            $button_params_array1['text'] = $params['cover_image_button_one'];
        }

        if (!empty($params['cover_image_button_two'])) {
            $button_params_array2['text'] = $params['cover_image_button_two'];
        }

        if (!empty($params['cover_image_button_one_link'])) {
            $button_params_array1['link'] = $params['cover_image_button_one_link'];
        }

        if (!empty($params['cover_image_button_two_link'])) {
            $button_params_array2['link'] = $params['cover_image_button_two_link'];
        }

        if (!empty($params['cover_image_button_one_target'])) {
            $button_params_array1['target'] = $params['cover_image_button_one_target'];
        }

        if (!empty($params['cover_image_button_two_target'])) {
            $button_params_array2['target'] = $params['cover_image_button_two_target'];
        }

        $cover_image_params['cover_image_button_one'] = $button_params_array1;
        $cover_image_params['cover_image_button_two'] = $button_params_array2;


        return $cover_image_params;

    }
}