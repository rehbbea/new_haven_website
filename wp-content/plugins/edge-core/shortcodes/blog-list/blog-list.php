<?php

namespace Eldritch\Modules\BlogList;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class BlogList
 */
class BlogList implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'edgt_blog_list';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Blog List', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-blog-list extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Type', 'edge-core'),
					'param_name'  => 'type',
					'value'       => array(
						esc_html__('Minimal', 'edge-core')      => 'minimal',
						esc_html__('Simple', 'edge-core')       => 'simple',
						esc_html__('Masonry', 'edge-core')      => 'masonry',
						esc_html__('Image in box', 'edge-core') => 'image-in-box'
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Columns', 'edge-core'),
					'param_name'  => 'columns',
					'description' => '',
					'value'       => array(
						esc_html__('Default (3)', 'edge-core') => '3',
						'1'                                        => '1',
						'2'                                        => '2',
						'3'                                        => '3',
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'simple'
					),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Columns', 'edge-core'),
					'param_name'  => 'masonry_columns',
					'description' => '',
					'value'       => array(
						'3' => '3',
						'4' => '4',
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'masonry'
					),
					'save_always' => true
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Simple boxed', 'edge-core'),
					'param_name'  => 'simple_boxed',
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'simple'
					),
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Skin', 'edge-core'),
					'param_name'  => 'skin',
					'value'       => array(
						esc_html__('Light', 'edge-core') => 'light',
						esc_html__('Dark', 'edge-core')  => 'dark'
					),
					'dependency'  => array(
						'element'   => 'simple_boxed',
						'not_empty' => true
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Number of Posts', 'edge-core'),
					'param_name'  => 'number_of_posts',
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Order By', 'edge-core'),
					'param_name'  => 'order_by',
					'value'       => array(
						esc_html__('Title', 'edge-core') => 'title',
						esc_html__('Date', 'edge-core')  => 'date'
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
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Category Slug', 'edge-core'),
					'param_name'  => 'category',
					'description' => esc_html__('Leave empty for all or use comma for list', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Text length', 'edge-core'),
					'param_name'  => 'text_length',
					'description' => esc_html__('Number of characters', 'edge-core'),
					'dependency'  => array(
						'element' => 'type',
						'value'   => array('minimal', 'simple', 'image-in-box')
					),
				)
			)
		));

	}

	public function render($atts, $content = null) {

		$default_atts = array(
			'type'                    => 'minimal',
			'columns'                 => '3',
			'masonry_columns'         => '3',
			'simple_boxed'            => '',
			'skin'                    => '',
			'number_of_posts'         => '',
			'order_by'                => '',
			'order'                   => '',
			'category'                => '',
			'text_length'             => '90',
			//widget attributes
			'data_attrs'              => '',
		);

		$params = shortcode_atts($default_atts, $atts);
		$params['holder_classes'] = $this->getBlogHolderClasses($params);


		$queryArray = $this->generateBlogQueryArray($params);
		$query_result = new \WP_Query($queryArray);
		$params['query_result'] = $query_result;

		$html = '';
		$html .= edge_core_get_core_shortcode_template_part('templates/blog-list-holder', 'blog-list', '', $params);

		return $html;

	}

	/**
	 * Generates holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getBlogHolderClasses($params) {
		$holderClasses = array(
			'edgt-blog-list-holder',
			'edgt-' . $params['type'],
		);

		if ($params['type'] === 'simple' && $params['simple_boxed']) {
			$holderClasses[] = 'boxed';
		}

		if ($params['type'] === 'masonry') {
			if ($params['masonry_columns'] == '4') {
				$holderClasses[] = 'edgt-four';
			} else {
				$holderClasses[] = 'edgt-three';
			}
		}

		if ($params['type'] === 'simple') {
			$holderClasses[] = 'edgt-' . $params['columns'];
		}


		if ($params['skin'] !== '') {
			$holderClasses[] = $params['skin'];
		}

		return $holderClasses;

	}

	/**
	 * Generates query array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function generateBlogQueryArray($params) {

		$queryArray = array(
			'orderby'        => $params['order_by'],
			'order'          => $params['order'],
			'posts_per_page' => $params['number_of_posts'],
			'category_name'  => $params['category']
		);

		return $queryArray;
	}
}
