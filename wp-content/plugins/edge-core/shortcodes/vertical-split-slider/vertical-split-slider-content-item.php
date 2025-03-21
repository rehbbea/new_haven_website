<?php
namespace Eldritch\Modules\Shortcodes\VerticalSplitSliderContentItem;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class VerticalSplitSliderContentItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_vertical_split_slider_content_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'      => esc_html__('Slide Content Item', 'edge-core'),
			'base'      => $this->base,
			'icon'      => 'icon-wpb-vertical-split-slider-content-item extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'as_parent' => array('except' => 'vc_row'),
			'as_child'  => array('only' => 'edgt_vertical_split_slider_left_panel,edgt_vertical_split_slider_right_panel'),
			'js_view'   => 'VcColumnView',
			'params'    => array(
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Background Color', 'edge-core'),
					'param_name' => 'background_color',
					'value'      => ''
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Background Image', 'edge-core'),
					'param_name' => 'background_image',
					'value'      => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Padding', 'edge-core'),
					'param_name'  => 'item_padding',
					'value'       => '',
					'description' => esc_html__('Please insert padding in format "10px 0 10px 0"', 'edge-core')
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Content Aligment', 'edge-core'),
					'param_name' => 'alignment',
					'value'      => array(
						esc_html__('Left', 'edge-core')   => 'left',
						esc_html__('Right', 'edge-core')  => 'right',
						esc_html__('Center', 'edge-core') => 'center'
					)
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Header/Bullets Style', 'edge-core'),
					'param_name' => 'header_style',
					'value'      => array(
						esc_html__('Default', 'edge-core') => '',
						esc_html__('Light', 'edge-core')   => 'light',
						esc_html__('Dark', 'edge-core')    => 'dark'
					)
				)
			)
		));
	}

	public function render($atts, $content = null) {

		$args   = array(
			'background_color' => '',
			'background_image' => '',
			'item_padding'     => '',
			'alignment'        => 'left',
			'header_style'     => '',
		);
		$params = shortcode_atts($args, $atts);
		extract($params);

		$params['content_style'] = $this->getContentStyle($params);
		$params['content_data']  = $this->getContentData($params);
		$params['content']       = $content;

		$html = edge_core_get_core_shortcode_template_part('templates/vertical-split-slider-content-item-template', 'vertical-split-slider', '', $params);

		return $html;

	}


	/**
	 * Return Content Style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getContentStyle($params) {

		$content_style = array();

		if($params['background_color'] !== '') {
			$content_style[] = 'background-color:'.$params['background_color'];
		}

		if($params['background_image'] !== '') {
			$url             = wp_get_attachment_url($params['background_image']);
			$content_style[] = 'background-image:url('.$url.')';
		}

		if($params['item_padding'] !== '') {
			$content_style[] = 'padding:'.$params['item_padding'];
		}

		if($params['alignment'] !== '') {
			$content_style[] = 'text-align:'.$params['alignment'];
		}


		return $content_style;
	}

	private function getContentData($params) {

		$data = array();

		if($params['header_style'] !== '') {
			$data['data-header-style'] = $params['header_style'];
		}


		return $data;
	}

}
