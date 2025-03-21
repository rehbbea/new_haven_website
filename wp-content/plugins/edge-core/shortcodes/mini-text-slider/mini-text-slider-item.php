<?php
namespace Eldritch\Modules\Shortcodes\MiniTextSliderItem;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class MiniTextSliderItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_mini_text_slider_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'      => esc_html__('Mini Text Slider Item', 'edge-core'),
			'base'      => $this->base,
			'icon'      => 'icon-wpb-mini-text-slider-item extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'as_child' => array('only' => 'edgt_mini_text_slider'),
			'params'    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Title', 'edge-core'),
					'param_name'  => 'title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Subtitle', 'edge-core'),
					'param_name'  => 'subtitle',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Text', 'edge-core'),
					'param_name'  => 'text',
					'admin_label' => true,
				),
			)
		));
	}

	public function render($atts, $content = null) {

		$args   = array(
			'title' => '',
			'subtitle' => '',
			'text' => ''
		);
		$params = shortcode_atts($args, $atts);
		extract($params);

        $html = edge_core_get_core_shortcode_template_part('templates/mini-text-slider-item-template', 'mini-text-slider', '', $params);

		return $html;

	}

}
