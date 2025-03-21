<?php
namespace Eldritch\Modules\ProductList;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class ProductList
 */
class ProductList implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'edgt_product_list';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Product List', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-product-list extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Type', 'edge-core'),
					'param_name'  => 'product_list_type',
					'value'       => array(
						esc_html__('Simple', 'edge-core')           => 'simple',
						esc_html__('Boxed', 'edge-core')            => 'boxed',
						esc_html__('Hover', 'edge-core')            => 'hover',
						esc_html__('Masonry', 'edge-core')          => 'masonry',
						esc_html__('Lookbook', 'edge-core')         => 'lookbook',
						esc_html__('Lookbook Masonry', 'edge-core') => 'lookbook-masonry'
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Number of Products', 'edge-core'),
					'param_name'  => 'number_of_posts',
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Number of Columns', 'edge-core'),
					'param_name'  => 'number_of_columns',
					'value'       => array(
						esc_html__('Three', 'edge-core') => '3',
						esc_html__('Four', 'edge-core')  => '4',
						esc_html__('Five', 'edge-core')  => '5',
						esc_html__('Six', 'edge-core')   => '6',
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Order By', 'edge-core'),
					'param_name'  => 'order_by',
					'value'       => array(
						esc_html__('Title', 'edge-core')      => 'title',
						esc_html__('Date', 'edge-core')       => 'date',
						esc_html__('Random', 'edge-core')     => 'rand',
						esc_html__('Post Name', 'edge-core')  => 'name',
						esc_html__('ID', 'edge-core')         => 'id',
						esc_html__('Menu Order', 'edge-core') => 'menu_order'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Order', 'edge-core'),
					'param_name'  => 'order',
					'value'       => array(
						esc_html__('ASC', 'edge-core')  => 'ASC',
						esc_html__('DESC', 'edge-core') => 'DESC'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Choose Sorting Taxonomy', 'edge-core'),
					'param_name'  => 'taxonomy_to_display',
					'value'       => array(
						esc_html__('Category', 'edge-core') => 'category',
						esc_html__('Tag', 'edge-core')      => 'tag',
						esc_html__('Id', 'edge-core')       => 'id'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('If you would like to display only certain products, this is where you can select the criteria by which you would like to choose which products to display.', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Enter Taxonomy Values', 'edge-core'),
					'param_name'  => 'taxonomy_values',
					'value'       => '',
					'admin_label' => true,
					'description' => esc_html__('Separate values (category slugs, tags, or post IDs) with a comma', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Space', 'edge-core'),
					'param_name'  => 'space',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no',
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Space between items', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Title tag', 'edge-core'),
					'param_name'  => 'title_tag',
					'value'       => array(
						''   => '',
						'h1' => 'h1',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h6'
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'product_list_type',
						'value'   => array('simple', 'boxed', 'hover', 'masonry')
					),
					'description' => esc_html__('If you would like the rating to be displayed on your product list, you also need to enable the WooCommerce rating option', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Show Rating', 'edge-core'),
					'param_name'  => 'show_rating',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no',
					),
					'save_always' => true,
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'product_list_type',
						'value'   => array('simple', 'boxed', 'hover', 'masonry')
					),
					'description' => esc_html__('If you would like the rating to be displayed on your product list, you also need to enable the WooCommerce rating option', 'edge-core')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Box Background Color', 'edge-core'),
					'param_name'  => 'box_background_color',
					'group'       => esc_html__('Design Options', 'edge-core'),
					'dependency'  => array(
						'element' => 'product_list_type',
						'value'   => array('boxed', 'hover')
					),
					'admin_label' => true
				),
			)
		));
	}

	public function render($atts, $content = null) {

		$default_atts = array(
			'product_list_type'    => 'simple',
			'number_of_posts'      => '8',
			'number_of_columns'    => '4',
			'order_by'             => '',
			'order'                => '',
			'taxonomy_to_display'  => 'category',
			'taxonomy_values'      => '',
			'space'                => 'yes',
			'title_tag'            => 'h5',
			'show_rating'          => 'yes',
			'box_background_color' => ''
		);

		$params = shortcode_atts($default_atts, $atts);
		extract($params);
		$params['holder_classes'] = $this->getHolderClasses($params);

		$params['productListObject'] = $this;

		$queryArray = $this->generateProductQueryArray($params);
		$query_result = new \WP_Query($queryArray);
		$params['query_result'] = $query_result;

		$html = edge_core_get_core_shortcode_template_part('templates/product-list-template-' . $params['product_list_type'], 'product-list', '', $params);
		return $html;
	}

	/**
	 * Generates holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getHolderClasses($params) {
		$holderClasses = array('edgt-pl-holder', 'woocommerce');

		$columnNumber = $this->getColumnNumberClass($params);

		$holderClasses[] = $params['product_list_type'];
		$holderClasses[] = $columnNumber;

		if ($params['space'] == 'no') {
			$holderClasses[] = 'no-space';
		}

		return $holderClasses;
	}

	/**
	 * Generates columns number classes for product list holder
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getColumnNumberClass($params) {

		$columnsNumber = '';
		$columns = $params['number_of_columns'];

		switch ($columns) {
			case 3:
				$columnsNumber = 'edgt-three-columns';
				break;
			case 4:
				$columnsNumber = 'edgt-four-columns';
				break;
			case 5:
				$columnsNumber = 'edgt-five-columns';
				break;
			case 6:
				$columnsNumber = 'edgt-six-columns';
				break;
			default:
				$columnsNumber = 'edgt-four-columns';
				break;
		}

		return $columnsNumber;
	}

	/**
	 * Generates query array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function generateProductQueryArray($params) {

		$queryArray = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $params['number_of_posts'],
			'orderby'             => $params['order_by'],
			'order'               => $params['order'],
			'meta_query'          => WC()->query->get_meta_query()
		);

		if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'category') {
			$queryArray['product_cat'] = $params['taxonomy_values'];
		}

		if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'tag') {
			$queryArray['product_tag'] = $params['taxonomy_values'];
		}

		if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'id') {
			$idArray = $params['taxonomy_values'];
			$ids = explode(',', $idArray);
			$queryArray['post__in'] = $ids;
		}

		return $queryArray;
	}

	/**
	 * Returns Thumbnail size for Masonry Product list
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public function getMasonryProductListThumbnail($id) {
		$masonry_size = 'standard';
		$thumb_size = 'eldritch_edge_square';

		$masonry_size = get_post_meta($id, 'edgt_masonry_product_list_dimensions_meta', true);

		switch ($masonry_size):
			case 'standard' :
				$thumb_size = 'eldritch_edge_square';
				break;
			case 'large-width' :
				$thumb_size = 'eldritch_edge_large_width';
				break;
			case 'large-height' :
				$thumb_size = 'eldritch_edge_large_height';
				break;
			case 'large-width-height' :
				$thumb_size = 'eldritch_edge_large_width_height';
				break;
		endswitch;

		return $thumb_size;
	}
}