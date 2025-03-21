<?php
namespace EdgeCore\CPT\Match\Shortcodes;

use EdgeCore\Lib;
use EdgeCore\CPT\Match\Lib as MatchLib;

/**
 * Class MatchList
 * @package EdgeCore\CPT\Match\Shortcodes
 */
class MatchList implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * MatchList constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_match_list';

		add_action('vc_before_init', array($this, 'vcMap'));

		add_action('wp_ajax_nopriv_edgt_core_match_ajax_load_more', array($this, 'loadMoreMatches'));
		add_action('wp_ajax_edgt_core_match_ajax_load_more', array($this, 'loadMoreMatches'));
	}


	/**
	 * Loads matches via AJAX
	 */
	public function loadMoreMatches() {
		$shortcodeParams = $this->getShortcodeParamsFromPost();

		$html = '';
		$matchQuery = MatchLib\MatchQuery::getInstance();
		$queryResults = $matchQuery->buildQueryObject($shortcodeParams);
        
		if ($queryResults->have_posts()) {
			while ($queryResults->have_posts()) {
				$queryResults->the_post();

                $new_params = $this->getTeamsOptions($shortcodeParams);
                $new_params['title_tag'] = $shortcodeParams['title_tag'];
                $new_params['team_title_tag'] = $shortcodeParams['team_title_tag'];


                $html .= edgt_core_get_shortcode_module_template_part('match-list/templates/match', 'match', '', $new_params);
			}

			wp_reset_postdata();
		} else {
			$html .= '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'edge-core') . '</p>';
		}

		$returnObj = array(
			'html' => $html,
		);

		echo json_encode($returnObj);
		exit;
	}

	/**
	 * Prepares shortcode params array from $_POST and returns it
	 *
	 * @return array
	 */
	private function getShortcodeParamsFromPost() {
		$shortcodeParams = array();

        if (!empty($_POST['orderBy'])) {
            $shortcodeParams['order_by'] = $_POST['orderBy'];
        }

        if (!empty($_POST['order'])) {
            $shortcodeParams['order'] = $_POST['order'];
        }

        if (!empty($_POST['number'])) {
            $shortcodeParams['number'] = $_POST['number'];
        }

        if (!empty($_POST['titleTag'])) {
            $shortcodeParams['title_tag'] = $_POST['titleTag'];
        }

        if (!empty($_POST['teamTitleTag'])) {
            $shortcodeParams['team_title_tag'] = $_POST['teamTitleTag'];
        }

        if (!empty($_POST['showCategories'])) {
            $shortcodeParams['show_categories'] = $_POST['showCategories'];
        }

        if (!empty($_POST['showDate'])) {
            $shortcodeParams['show_date'] = $_POST['showDate'];
        }

        if (!empty($_POST['category'])) {
            $shortcodeParams['category'] = $_POST['category'];
        }

        if (!empty($_POST['selectedProjects'])) {
            $shortcodeParams['selected_projects'] = $_POST['selectedProjects'];
        }

        if (!empty($_POST['showLoadMore'])) {
            $shortcodeParams['show_load_more'] = $_POST['showLoadMore'];
        }

        if (!empty($_POST['skin'])) {
            $shortcodeParams['skin'] = $_POST['skin'];
        }

        if (!empty($_POST['showResult'])) {
            $shortcodeParams['show_result'] = $_POST['show_result'];
        }

        if (!empty($_POST['nextPage'])) {
            $shortcodeParams['next_page'] = $_POST['nextPage'];
        }

        return $shortcodeParams;
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
		if (function_exists('vc_map')) {
			vc_map(array(
					'name'                      => esc_html__('Match List', 'edge-core'),
					'base'                      => $this->getBase(),
					'category' => esc_html__( 'by EDGE', 'edge-core' ),
					'icon'                      => 'icon-wpb-match extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array_merge(
						array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Style', 'edge-core'),
								'param_name'  => 'skin',
								'value'       => array(
									esc_html__('Dark', 'edge-core')  => 'dark',
									esc_html__('Light', 'edge-core') => 'light'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Title Tag', 'edge-core'),
								'param_name'  => 'title_tag',
								'value'       => array(
									''   => '',
									'h2' => 'h2',
									'h3' => 'h3',
									'h4' => 'h4',
									'h5' => 'h5',
									'h6' => 'h6',
								),
								'group'       => esc_html__('Layout Options', 'edge-core'),
								'description' => ''
							),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Team Name Tag', 'edge-core'),
                                'param_name'  => 'team_title_tag',
                                'value'       => array(
                                    ''   => '',
                                    'h2' => 'h2',
                                    'h3' => 'h3',
                                    'h4' => 'h4',
                                    'h5' => 'h5',
                                    'h6' => 'h6',
                                ),
                                'group'       => esc_html__('Layout Options', 'edge-core'),
                                'description' => ''
                            ),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Show Categories', 'edge-core'),
								'param_name'  => 'show_categories',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => esc_html__('Default value is Yes', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Show Date', 'edge-core'),
                                'param_name'  => 'show_date',
                                'value'       => array(
                                    esc_html__('Yes', 'edge-core') => 'yes',
                                    esc_html__('No', 'edge-core')  => 'no',
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => esc_html__('Default value is Yes', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            ),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Show Load More', 'edge-core'),
								'param_name'  => 'show_load_more',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => esc_html__('Default value is No', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Show Result', 'edge-core'),
                                'param_name'  => 'show_result',
                                'value'       => array(
                                    esc_html__('No', 'edge-core')  => 'no',
                                    esc_html__('Yes', 'edge-core') => 'yes',
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => esc_html__('Default value is Yes', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            )
						),
						MatchLib\MatchQuery::getInstance()->queryVCParams()
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
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'skin'                          => 'dark',
			'title_tag'                     => 'h4',
			'team_title_tag'                => 'h5',
			'show_categories'               => 'no',
			'show_date'                     => 'yes',
			'show_load_more'                => 'no',
            'show_result'                   => 'yes',
		);

		$matchQuery = MatchLib\MatchQuery::getInstance();

		$args = array_merge($args, $matchQuery->getShortcodeAtts());
		$params = shortcode_atts($args, $atts);

		extract($params);

		$queryResults = $matchQuery->buildQueryObject($params);
		$params['query_results'] = $queryResults;

		$holder_classes = $this->getMatchHolderClasses($params);
		$dataAtts = $this->getDataAtts($params);
		$dataAtts .= ' data-max-num-pages = ' . $queryResults->max_num_pages;

		$html = '<div class="edgt-match-list-holder-outer';

		if($show_load_more == 'yes') {
            $html .= ' edgt-match-load-more';
        }
        $html .= '">';

		$html .= '<div ' . edgt_core_get_class_attribute($holder_classes) . ' ' . $dataAtts . '>';

		if ($queryResults->have_posts()) {
			while ($queryResults->have_posts()) {
				$queryResults->the_post();

                $new_params = $this->getTeamsOptions($params);
                $new_params['title_tag'] = $params['title_tag'];
                $new_params['team_title_tag'] = $params['team_title_tag'];

				$html .= edgt_core_get_shortcode_module_template_part('match-list/templates/match', 'match', '', $new_params);
			}

		} else {
			$html .= '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'edge-core') . '</p>';
		}

		$html .= '</div>'; //close edgt-match-list-holder

		if ($show_load_more == 'yes') {
			$html .= edgt_core_get_shortcode_module_template_part('match-list/templates/load-more-template', 'match', '', $params);
		}

		wp_reset_postdata();

		$html .= '</div>'; // close edgt-match-list-holder-outer
		return $html;
	}

	/**
	 * Generates match item categories html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
    public function getItemCategoriesHtml($params) {
        $id = get_the_ID();

        $category_html = '';
        if($params['show_categories'] == 'yes') {

            $categories = wp_get_post_terms($id, 'match-category');
            $category_html = '<span class="edgt-match-category-holder">';
            $k = 1;
            foreach ($categories as $cat) {
                $category_html .= '<span>' . $cat->name . '</span>';
                if (count($categories) != $k) {
                    $category_html .= ', ';
                }
                $k++;
            }
            $category_html .= '</span>';
        }

        return $category_html;
    }

    /**
     * Generates match item date html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemDateHtml($params) {
        $id = get_the_ID();
        $html = '';

        if($params['show_date'] == 'yes') {

            $date = get_post_meta($id, 'edgt_match_date_meta', true);

            $dateobj = date_create_from_format('Y-m-d', $date);

            $date = date_format($dateobj, 'jS F Y');


            $time = get_post_meta($id, 'edgt_match_time_meta', true);

            $html = '<span class="edgt-match-date">' . $date . ', ' . $time . '</span>';
        }

        return $html;
    }

	/**
	 * Generates datta attributes array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getDataAtts($params) {

		$data_attr = array();
		$data_return_string = '';

		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if (!empty($paged)) {
			$data_attr['data-next-page'] = $paged + 1;
		}

		if (!empty($params['order_by'])) {
			$data_attr['data-order-by'] = $params['order_by'];
		}

		if (!empty($params['order'])) {
			$data_attr['data-order'] = $params['order'];
		}

		if (!empty($params['number'])) {
			$data_attr['data-number'] = $params['number'];
		}

		if (!empty($params['category'])) {
			$data_attr['data-category'] = $params['category'];
		}

		if (!empty($params['selected_projectes'])) {
			$data_attr['data-selected-projects'] = $params['selected_projectes'];
		}

		if (!empty($params['title_tag'])) {
			$data_attr['data-title-tag'] = $params['title_tag'];
		}

        if (!empty($params['team_title_tag'])) {
            $data_attr['data-team-title-tag'] = $params['team_title_tag'];
        }

		if (!empty($params['show_categories'])) {
			$data_attr['data-show-categories'] = $params['show_categories'];
		}

        if (!empty($params['show_date'])) {
            $data_attr['data-show-date'] = $params['show_date'];
        }

        if (!empty($params['skin'])) {
            $data_attr['data-skin'] = $params['skin'];
        }

        if (!empty($params['show_result'])) {
            $data_attr['data-show-result'] = $params['show_result'];
        }

		if (!empty($params['show_load_more'])) {
			$data_attr['data-show-load-more'] = $params['show_load_more'];
		}


		foreach ($data_attr as $key => $value) {
			if ($key !== '') {
				$data_return_string .= $key . '= ' . esc_attr($value) . ' ';
			}
		}


		return $data_return_string;
	}


	/**
	 * Checks if match has external link and returns it. Else returns link to match single page
	 *
	 * @param $params
	 *
	 * @return false|mixed|string
	 */
	public function getItemLink($params) {

		$match_link_array = array();

		$id = get_the_ID();
		$match_link = get_permalink($id);
		$match_target = '';

		$match_link_array['href'] = $match_link;
		$match_link_array['target'] = $match_target;

		return $match_link_array;

	}

	/**
     * Get shortcode classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getMatchHolderClasses($params) {

        $classes = array();

        $classes[] = 'edgt-match-list-holder';

        if($params['skin'] != '') {
            $classes[] = 'edgt-match-skin-' . $params['skin'];
        }

        return implode(' ', $classes);

	}

	/**
     * Get shortcode classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getMatchItemClasses($params) {

        $classes = array();

        $status = get_post_meta($id = get_the_ID(), 'edgt_match_status_meta', true);

        if($status) {
            $classes[] = 'edgt-match-status-' . $status;
        }

        return implode(' ', $classes);

	}

	/**
     * Get versus image
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getVSImageURL($params) {

        $url = '';

        $status = get_post_meta(get_the_ID(), 'edgt_match_status_meta', true);

        if($status == 'finished') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_finished.png';
        }

        if($params['skin'] == 'light') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_light.png';
        }

        if($params['skin'] == 'dark') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_dark.png';
        }

        return $url;

	}

    private function getTeamsOptions($params) {

        $new_params = array();

        $id = get_the_ID();
        $new_params['item_classes'] = $this->getMatchItemClasses($params);
        $new_params['link_atts'] = $this->getItemLink($params);
        $new_params['vs_image'] = $this->getVSImageURL($params);

        $new_params['status'] = get_post_meta($id, 'edgt_match_status_meta', true);
        $new_params['category'] = $this->getItemCategoriesHtml($params);
        $new_params['date'] = $this->getItemDateHtml($params);
        $new_params['team_one_name'] = get_post_meta($id, 'edgt_match_team_one_name_meta', true);
        $new_params['team_two_name'] = get_post_meta($id, 'edgt_match_team_two_name_meta', true);
        $new_params['team_one_image'] = get_post_meta($id, 'edgt_match_team_one_image_meta', true);
        $new_params['team_two_image'] = get_post_meta($id, 'edgt_match_team_two_image_meta', true);

        $new_params['result'] = '';
        if($params['show_result'] == 'yes') {
            $new_params['result'] = get_post_meta($id, 'edgt_match_result_meta', true);
        }


        return $new_params;
    }

}