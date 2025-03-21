<?php
namespace Eldritch\Modules\Shortcodes\ElementsHolderItem;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ElementsHolderItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_elements_holder_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		if (function_exists('vc_map')) {
			vc_map(
				array(
					'name'                    => esc_html__('Elements Holder Item', 'edge-core'),
					'base'                    => $this->base,
					'as_child'                => array('only' => 'edgt_elements_holder'),
					'as_parent'               => array('except' => 'vc_row, vc_accordion, no_cover_boxes, no_portfolio_list, no_portfolio_slider'),
					'content_element'         => true,
					'category' => esc_html__( 'by EDGE', 'edge-core' ),
					'icon'                    => 'icon-wpb-elements-holder-item extended-custom-icon',
					'show_settings_on_create' => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Width', 'edge-core'),
							'param_name'  => 'item_width',
							'value'       => array(
								'1/1' => '1-1',
								'1/2' => '1-2',
								'1/3' => '1-3',
								'2/3' => '2-3',
								'1/4' => '1-4',
								'3/4' => '3-4',
								'1/5' => '1-5',
								'2/5' => '2-5',
								'3/5' => '3-5',
								'4/5' => '4-5',
								'1/6' => '1-6',
								'5/6' => '5-6',
							),
							'save_always' => true
						),
						array(
							'type'       => 'colorpicker',
							'class'      => '',
							'heading'    => esc_html__('Background Color', 'edge-core'),
							'param_name' => 'background_color',
							'value'      => ''
						),
						array(
							'type'       => 'attach_image',
							'class'      => '',
							'heading'    => esc_html__('Background Image', 'edge-core'),
							'param_name' => 'background_image',
							'value'      => ''
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'heading'     => esc_html__('Inner Padding', 'edge-core'),
							'param_name'  => 'item_padding',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'heading'     => esc_html__('Inner Margin', 'edge-core'),
							'param_name'  => 'item_margin',
							'value'       => '',
							'description' => esc_html__('Please insert margin in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'       => 'dropdown',
							'class'      => '',
							'heading'    => esc_html__('Inner Border', 'edge-core'),
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
                            'type'       => 'dropdown',
                            'class'      => '',
                            'heading'    => esc_html__('Animation on Hover', 'edge-core'),
                            'param_name' => 'hover_animation',
                            'value'      => array(
                                esc_html__('No', 'edge-core')  => 'no',
                                esc_html__('Yes', 'edge-core') => 'yes'
                            )
                        ),
						array(
							'type'       => 'textfield',
							'class'      => '',
							'heading'    => esc_html__('Border radius', 'edge-core'),
							'param_name' => 'border_radius',
							'value'      => ''
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Horizontal Alignment', 'edge-core'),
							'param_name'  => 'horizontal_aligment',
							'value'       => array(
								esc_html__('Left', 'edge-core')   => 'left',
								esc_html__('Right', 'edge-core')  => 'right',
								esc_html__('Center', 'edge-core') => 'center'
							),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Vertical Alignment', 'edge-core'),
							'param_name'  => 'vertical_alignment',
							'value'       => array(
								esc_html__('Middle', 'edge-core') => 'middle',
								esc_html__('Top', 'edge-core')    => 'top',
								esc_html__('Bottom', 'edge-core') => 'bottom'
							),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'class'      => '',
							'heading'    => esc_html__('Animation Name', 'edge-core'),
							'param_name' => 'animation_name',
							'value'      => array(
								esc_html__('No Animation', 'edge-core')          => '',
								esc_html__('Flip In', 'edge-core')               => 'flip-in',
								esc_html__('Grow In', 'edge-core')               => 'grow-in',
								esc_html__('X Rotate', 'edge-core')              => 'x-rotate',
								esc_html__('Z Rotate', 'edge-core')              => 'z-rotate',
								esc_html__('Y Translate', 'edge-core')           => 'y-translate',
								esc_html__('Fade In', 'edge-core')               => 'fade-in',
								esc_html__('Fade In Down', 'edge-core')          => 'fade-in-down',
								esc_html__('Fade In Left X Rotate', 'edge-core') => 'fade-in-left-x-rotate'
							)
						),
						array(
							'type'       => 'textfield',
							'class'      => '',
							'heading'    => esc_html__('Animation Delay (ms)', 'edge-core'),
							'param_name' => 'animation_delay',
							'value'      => '',
							'dependency' => array(
								'element'   => 'animation_name',
								'not_empty' => true
							)
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on screen size between 1280px-1440px', 'edge-core'),
							'param_name'  => 'item_padding_1280_1440',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on screen size between 1024px-1280px', 'edge-core'),
							'param_name'  => 'item_padding_1024_1280',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on screen size between 768px-1024px', 'edge-core'),
							'param_name'  => 'item_padding_768_1024',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on screen size between 600px-768px', 'edge-core'),
							'param_name'  => 'item_padding_600_768',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on screen size between 480px-600px', 'edge-core'),
							'param_name'  => 'item_padding_480_600',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'edge-core'),
							'heading'     => esc_html__('Padding on Screen Size Bellow 480px', 'edge-core'),
							'param_name'  => 'item_padding_480',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'edge-core')
						)
					)
				)
			);
		}
	}

	public function render($atts, $content = null) {
		$args = array(
			'item_width'             => '1-1',
			'background_color'       => '',
			'background_image'       => '',
			'item_margin'            => '',
			'item_padding'           => '',
			'border'                 => '',
			'border_width'           => '',
			'border_style'           => '',
			'border_color'           => '',
			'border_radius'          => '',
			'box_shadow'             => '',
            'hover_animation'        => '',
			'horizontal_aligment'    => 'left',
			'vertical_alignment'     => '',
			'animation_name'         => '',
			'animation_delay'        => '',
			'item_padding_1280_1440' => '',
			'item_padding_1024_1280' => '',
			'item_padding_768_1024'  => '',
			'item_padding_600_768'   => '',
			'item_padding_480_600'   => '',
			'item_padding_480'       => ''
		);

		$params = shortcode_atts($args, $atts);
		extract($params);
		$params['content'] = $content;

		$rand_class = 'edgt-elements-holder-custom-' . mt_rand(100000, 1000000);

		$params['elements_holder_item_style'] = $this->getElementsHolderItemStyle($params);
		$params['elements_holder_item_content_style'] = $this->getElementsHolderItemContentStyle($params);
		$params['elements_holder_item_class'] = $this->getElementsHolderItemClass($params);
		$params['elements_holder_item_content_class'] = $rand_class;
		$params['elements_holder_item_data'] = $this->getData($params);

		$html = edge_core_get_core_shortcode_template_part('templates/elements-holder-item-template', 'elements-holder', '', $params);

		return $html;
	}


	/**
	 * Return Elements Holder Item style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemStyle($params) {

		$element_holder_item_style = array();

		if ($params['animation_delay'] !== '') {
			$element_holder_item_style[] = 'transition-delay:' . $params['animation_delay'] . 'ms;' . '-webkit-transition-delay:' . $params['animation_delay'] . 'ms';
		}

		return $element_holder_item_style;

	}

	/**
	 * Return Elements Holder Item Content style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemContentStyle($params) {

		$element_holder_item_content_style = array();

		if ($params['border_radius'] !== '') {
			$element_holder_item_content_style[] = 'border-radius: ' . eldritch_edge_filter_px($params['border_radius']) . 'px';
		}

		if ($params['background_color'] !== '') {
			$element_holder_item_content_style[] = 'background-color: ' . $params['background_color'];
		}

		if ($params['background_image'] !== '') {
			$element_holder_item_content_style[] = 'background-image: url(' . wp_get_attachment_url($params['background_image']) . ')';
		}

		if ($params['item_padding'] !== '') {
			$element_holder_item_content_style[] = 'padding: ' . $params['item_padding'];
		}

		if ($params['item_margin'] !== '') {
			$element_holder_item_content_style[] = 'margin: ' . $params['item_margin'];
		}

		if ($params['border_width'] !== '') {
			$element_holder_item_content_style[] = 'border-width: ' . eldritch_edge_filter_px($params['border_width']) . 'px';
		}

		if ($params['border_style'] !== '') {
			$element_holder_item_content_style[] = 'border-style: ' . $params['border_style'];
		}

		if ($params['border_color'] !== '') {
			$element_holder_item_content_style[] = 'border-color: ' . $params['border_color'];
		}

		return $element_holder_item_content_style;
	}

	/**
	 * Return Elements Holder Item classes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemClass($params) {

		$element_holder_item_class = array('edgt-elements-holder-item');

		if ($params['item_width'] !== '') {
			$element_holder_item_class[] = 'edgt-width-' . $params['item_width'];
		}

		if ($params['vertical_alignment'] !== '') {
			$element_holder_item_class[] = 'edgt-vertical-alignment-' . $params['vertical_alignment'];
		}

		if ($params['horizontal_aligment'] !== '') {
			$element_holder_item_class[] = 'edgt-horizontal-alignment-' . $params['horizontal_aligment'];
		}

		if ($params['animation_name'] !== '') {
			$element_holder_item_class[] = 'edgt-' . $params['animation_name'];
		}

		if ($params['border'] == 'yes') {
			$element_holder_item_class[] = 'edgt-border';
		}

		if ($params['box_shadow'] == 'yes') {
			$element_holder_item_class[] = 'edgt-shadow';
		}

        if ($params['hover_animation'] == 'yes') {
            $element_holder_item_class[] = 'edgt-hover-animation';
        }

		return $element_holder_item_class;
	}

	private function getData($params) {
		$data = array();

		if ($params['animation_name'] !== '') {
			$data['data-animation'] = 'edgt-' . $params['animation_name'];
		}

		$data['data-item-class'] = $params['elements_holder_item_content_class'];

		if ($params['item_padding_1280_1440'] !== '') {
			$data['data-1280-1440'] = $params['item_padding_1280_1440'];
		}

		if ($params['item_padding_1024_1280'] !== '') {
			$data['data-1024-1280'] = $params['item_padding_1024_1280'];
		}

		if ($params['item_padding_768_1024'] !== '') {
			$data['data-768-1024'] = $params['item_padding_768_1024'];
		}

		if ($params['item_padding_600_768'] !== '') {
			$data['data-600-768'] = $params['item_padding_600_768'];
		}

		if ($params['item_padding_480_600'] !== '') {
			$data['data-480-600'] = $params['item_padding_480_600'];
		}

		if ($params['item_padding_480'] !== '') {
			$data['data-480'] = $params['item_padding_480'];
		}

		return $data;
	}
}
