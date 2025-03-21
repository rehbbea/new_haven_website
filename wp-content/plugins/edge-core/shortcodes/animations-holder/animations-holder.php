<?php
namespace Eldritch\Modules\Shortcodes\AnimationsHolder;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class AnimationsHolder implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'edgt_animations_holder';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(
			array(
				'name'                    => esc_html__('Animations Holder', 'edge-core'),
				'base'                    => $this->base,
				'as_parent'               => array('except' => 'vc_row, vc_accordion, vc_tabs, edgt_elements_holder, edgt_pricing_tables, edgt_text_slider_holder, edgt_info_card_slider, edgt_icon_slider'),
				'content_element'         => true,
				'category' => esc_html__( 'by EDGE', 'edge-core' ),
				'icon'                    => 'icon-wpb-animation-holder extended-custom-icon',
				'show_settings_on_create' => true,
				'js_view'                 => 'VcColumnView',
				'params'                  => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Animation', 'edge-core'),
						'param_name'  => 'css_animation',
						'value'       => array(
							esc_html__('No animation', 'edge-core')                    => '',
							esc_html__('Elements Shows From Left Side', 'edge-core')   => 'edgt-element-from-left',
							esc_html__('Elements Shows From Right Side', 'edge-core')  => 'edgt-element-from-right',
							esc_html__('Elements Shows From Top Side', 'edge-core')    => 'edgt-element-from-top',
							esc_html__('Elements Shows From Bottom Side', 'edge-core') => 'edgt-element-from-bottom',
							esc_html__('Elements Shows From Fade', 'edge-core')        => 'edgt-element-from-fade'
						),
						'save_always' => true,
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'class'       => '',
						'heading'     => esc_html__('Animation Delay (ms)', 'edge-core'),
						'param_name'  => 'animation_delay',
						'value'       => '',
						'description' => ''
					)
				)
			)
		);
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'css_animation'   => '',
			'animation_delay' => ''
		);

		$params = shortcode_atts($default_atts, $atts);
		$params['content'] = $content;
		$params['class'] = array(
			'edgt-animations-holder',
			$params['css_animation']
		);

		$params['style'] = $this->getHolderStyles($params);
		$params['data'] = array(
			'data-animation' => $params['css_animation']
		);

		return edge_core_get_core_shortcode_template_part('templates/animations-holder-template', 'animations-holder', '', $params);
	}

	private function getHolderStyles($params) {
		$styles = array();

		if ($params['animation_delay'] !== '') {
			$styles[] = 'transition-delay: ' . $params['animation_delay'] . 'ms';
			$styles[] = '-webkit-animation-delay: ' . $params['animation_delay'] . 'ms';
			$styles[] = 'animation-delay: ' . $params['animation_delay'] . 'ms';
		}

		return $styles;
	}
}