<?php
namespace Eldritch\Modules\Shortcodes\MiniTextSlider;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class MiniTextSlider implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_mini_text_slider';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'            => esc_html__('Mini Text Slider', 'edge-core'),
			'base'            => $this->base,
			'icon'            => 'icon-wpb-mini-text-slider extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'content_element' => true,
			'as_parent'       => array('only' => 'edgt_mini_text_slider_item'),
			'js_view'         => 'VcColumnView',
			'params'          => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Skin', 'edge-core'),
					'param_name'  => 'skin',
					'value'       => array(
						esc_html__('Dark', 'edge-core')  => 'dark',
						esc_html__('Light', 'edge-core') => 'light'
					),
					'save_always' => true,
					'description' => ''
				),
			)
		));
	}

	public function render($atts, $content = null) {

		$args = array(
			'skin' => ''
		);
		
		$params = shortcode_atts($args, $atts);
		$params['content'] = $content;

		$params['classes'] = $this->getClasses($params);

		$html = edge_core_get_core_shortcode_template_part('templates/mini-text-slider-template', 'mini-text-slider', '', $params);

		return $html;

	}

	private function getClasses($params) {
		$classes = array('edgt-mini-text-slider');

		$classes[] = 'edgt-' . $params['skin'] . '-skin';

		return $classes;
	}
}
