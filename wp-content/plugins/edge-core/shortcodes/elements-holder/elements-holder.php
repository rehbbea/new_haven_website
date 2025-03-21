<?php
namespace Eldritch\Modules\Shortcodes\ElementsHolder;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ElementsHolder implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_elements_holder';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'      => esc_html__('Elements Holder', 'edge-core'),
			'base'      => $this->base,
			'icon'      => 'icon-wpb-elements-holder extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'as_parent' => array('only' => 'edgt_elements_holder_item, edgt_info_box'),
			'js_view'   => 'VcColumnView',
			'params'    => array(
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__('Background Color', 'edge-core'),
					'param_name' => 'background_color',
					'value'      => ''
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__('Equal height', 'edge-core'),
					'param_name'  => 'items_float_left',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no'
					),
					'save_always' => true
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__('Border', 'edge-core'),
					'param_name' => 'border',
					'value'      => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					)
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__('Border Width', 'edge-core'),
					'param_name'  => 'border_width',
					'value'       => '',
					'dependency'  => array(
						'element' => 'border',
						'value'   => array('yes')
					),
					'description' => esc_html__('Please insert border width in px. For example: 1 ', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Border Style', 'edge-core'),
					'param_name'  => 'border_style',
					'value'       => array(
						esc_html__('Solid', 'edge-core')  => 'solid',
						esc_html__('Dashed', 'edge-core') => 'dashed',
						esc_html__('Dotted', 'edge-core') => 'dotted'
					),
					'dependency'  => array(
						'element' => 'border',
						'value'   => array('yes')
					),
					'save_always' => true
				),
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__('Border Color', 'edge-core'),
					'param_name' => 'border_color',
					'value'      => '',
					'dependency' => array(
						'element' => 'border',
						'value'   => array('yes')
					)
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__('Box Shadow', 'edge-core'),
					'param_name' => 'box_shadow',
					'value'      => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					)
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
					'heading'     => esc_html__('Switch to One Column', 'edge-core'),
					'param_name'  => 'switch_to_one_column',
					'value'       => array(
						esc_html__('Default', 'edge-core')      => '',
						esc_html__('Below 1440px', 'edge-core') => '1440',
						esc_html__('Below 1280px', 'edge-core') => '1280',
						esc_html__('Below 1024px', 'edge-core') => '1024',
						esc_html__('Below 768px', 'edge-core')  => '768',
						esc_html__('Below 600px', 'edge-core')  => '600',
						esc_html__('Below 480px', 'edge-core')  => '480',
						esc_html__('Never', 'edge-core')        => 'never'
					),
					'description' => esc_html__('Choose on which stage item will be in one column', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
					'heading'     => esc_html__('Choose Alignment In Responsive Mode', 'edge-core'),
					'param_name'  => 'alignment_one_column',
					'value'       => array(
						esc_html__('Default', 'edge-core') => '',
						esc_html__('Left', 'edge-core')    => 'left',
						esc_html__('Center', 'edge-core')  => 'center',
						esc_html__('Right', 'edge-core')   => 'right'
					),
					'description' => esc_html__('Alignment When Items are in One Column', 'edge-core')
				)
			)
		));
	}

	public function render($atts, $content = null) {

		$args = array(
			'switch_to_one_column' => '',
			'alignment_one_column' => '',
			'items_float_left'     => '',
			'background_color'     => '',
			'border'               => '',
			'border_width'         => '',
			'border_style'         => '',
			'border_color'         => '',
			'box_shadow'           => ''
		);

		$params = shortcode_atts($args, $atts);
		extract($params);

		$html = '';

		$elements_holder_classes = array();
		$elements_holder_classes[] = 'edgt-elements-holder';


		//Elements holder classes
		if ($switch_to_one_column != '') {
			$elements_holder_classes[] = 'edgt-responsive-mode-' . $switch_to_one_column;
		} else {
			$elements_holder_classes[] = 'edgt-responsive-mode-768';
		}

		if ($alignment_one_column != '') {
			$elements_holder_classes[] = 'edgt-one-column-alignment-' . $alignment_one_column;
		}

		if ($items_float_left == 'no') {
			$elements_holder_classes[] = 'edgt-elements-items-float';
		}

		if ($border == 'yes') {
			$elements_holder_classes[] = 'edgt-border';
		}

		if ($box_shadow == 'yes') {
			$elements_holder_classes[] = 'edgt-shadow';
		}


		//Elements holder styles
		$elements_holder_style = array();

		if ($background_color != '') {
			$elements_holder_style[] = 'background-color:' . $background_color . ';';
		}

		if ($params['border_width'] !== '') {
			$elements_holder_style[] = 'border-width: ' . eldritch_edge_filter_px($params['border_width']) . 'px';
		}

		if ($params['border_style'] !== '') {
			$elements_holder_style[] = 'border-style: ' . $params['border_style'];
		}

		if ($params['border_color'] !== '') {
			$elements_holder_style[] = 'border-color: ' . $params['border_color'];
		}

		$elements_holder_class = implode(' ', $elements_holder_classes);

		$html .= '<div ' . eldritch_edge_get_class_attribute($elements_holder_class) . ' ' . eldritch_edge_get_inline_style($elements_holder_style, 'style') . '>';
		$html .= do_shortcode($content);
		$html .= '</div>';

		return $html;

	}

}
