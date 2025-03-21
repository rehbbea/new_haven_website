<?php
namespace Eldritch\Modules\Shortcodes\Button;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;


/**
 * Class Button that represents button shortcode
 * @package Eldritch\Modules\Shortcodes\Button
 */
class Button implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * Sets base attribute and registers shortcode with Visual Composer
	 */
	public function __construct() {
		$this->base = 'edgt_button';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base attribute
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer
	 */
	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Button', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-button extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array_merge(
				array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Type', 'edge-core'),
						'param_name'  => 'type',
						'value'       => array_flip(eldritch_edge_get_btn_types(true)),
						'save_always' => true,
						'admin_label' => true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Size', 'edge-core'),
						'param_name'  => 'size',
						'value'       => array(
							esc_html__('Default', 'edge-core')                => '',
							esc_html__('Small', 'edge-core')                  => 'small',
							esc_html__('Medium', 'edge-core')                 => 'medium',
							esc_html__('Large', 'edge-core')                  => 'large',
							esc_html__('Extra Large', 'edge-core')            => 'huge',
							esc_html__('Extra Large Full Width', 'edge-core') => 'huge-full-width'
						),
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'save_always' => true,
						'admin_label' => true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Hover Type', 'edge-core'),
						'param_name'  => 'hover_type',
						'value'       => array_flip(eldritch_edge_get_btn_types(true)),
						'save_always' => true,
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'admin_label' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Text', 'edge-core'),
						'param_name'  => 'text',
						'admin_label' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Link', 'edge-core'),
						'param_name'  => 'link',
						'admin_label' => true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Link Target', 'edge-core'),
						'param_name'  => 'target',
						'value'       => array(
							esc_html__('Self', 'edge-core')  => '_self',
							esc_html__('Blank', 'edge-core') => '_blank'
						),
						'save_always' => true,
						'admin_label' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Custom CSS class', 'edge-core'),
						'param_name'  => 'custom_class',
						'admin_label' => true
					)
				),
				eldritch_edge_icon_collections()->getVCParamsArray(array(), '', true),
				array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Hover Animation', 'edge-core'),
						'param_name'  => 'hover_animation',
						'group'       => esc_html__('Hover Animation', 'edge-core'),
						'value'       => array_flip(eldritch_edge_get_btn_hover_animation_types(true)),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Color', 'edge-core'),
						'param_name'  => 'color',
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black', 'underline')
						),
						'group'       => esc_html__('Design Options', 'edge-core'),

						'admin_label' => true
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Color', 'edge-core'),
						'param_name'  => 'hover_color',
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'group'       => esc_html__('Design Options', 'edge-core'),

						'admin_label' => true
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Background Color', 'edge-core'),
						'param_name'  => 'background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value' => array('solid')
						),
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Background Color', 'edge-core'),
						'param_name'  => 'hover_background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Border Color', 'edge-core'),
						'param_name'  => 'border_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Border Color', 'edge-core'),
						'param_name'  => 'hover_border_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value'   => array('outline', 'solid', 'white', 'white-outline', 'black')
						),
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Font Size (px)', 'edge-core'),
						'param_name'  => 'font_size',
						'admin_label' => true,
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Icon Font Size (px)', 'edge-core'),
						'param_name'  => 'icon_font_size',
						'admin_label' => true,
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Icon Margin', 'edge-core'),
						'param_name'  => 'icon_margin',
						'description' => esc_html__('Insert margin in format: 0px 0px 0px 0px', 'edge-core'),
						'admin_label' => true,
						'group'       => esc_html__('Design Options', 'edge-core')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Font Weight', 'edge-core'),
						'param_name'  => 'font_weight',
						'value'       => array_flip(eldritch_edge_get_font_weight_array(true)),
						'admin_label' => true,
						'group'       => esc_html__('Design Options', 'edge-core'),
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Margin', 'edge-core'),
						'param_name'  => 'margin',
						'description' => esc_html__('Insert margin in format: 0px 0px 1px 0px', 'edge-core'),
						'admin_label' => true,
						'group'       => esc_html__('Design Options', 'edge-core')
					)
				)
			) //close array_merge
		));
	}

	/**
	 * Renders HTML for button shortcode
	 *
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {
		$default_atts = array(
			'type'                   => '',
			'size'                   => '',
			'hover_type'             => '',
			'text'                   => '',
			'link'                   => '',
			'target'                 => '',
			'color'                  => '',
			'hover_color'            => '',
			'background_color'       => '',
			'hover_background_color' => '',
			'border_color'           => '',
			'hover_border_color'     => '',
			'font_size'              => '',
			'font_weight'            => '',
			'margin'                 => '',
			'custom_class'           => '',
			'html_type'              => 'anchor',
			'input_name'             => '',
			'hover_animation'        => '',
			'icon_font_size'		 => '',
			'icon_margin'			 => '',
			'custom_attrs'           => array()
		);

		$default_atts = array_merge($default_atts, eldritch_edge_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($default_atts, $atts);

		if ($params['html_type'] !== 'input') {
			$iconPackName = eldritch_edge_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
			$params['icon'] = $iconPackName ? $params[$iconPackName] : '';
		}

		$params['size'] = !empty($params['size']) ? $params['size'] : 'medium';
		$params['type'] = !empty($params['type']) ? $params['type'] : 'solid';


		$params['link'] = !empty($params['link']) ? $params['link'] : '#';
		$params['target'] = !empty($params['target']) ? $params['target'] : '_self';

		$params['hover_animation'] = $this->getHoverAnimation($params);

		//prepare params for template
		$params['button_classes'] = $this->getButtonClasses($params);
		$params['button_custom_attrs'] = !empty($params['custom_attrs']) ? $params['custom_attrs'] : array();
		$params['button_styles'] = $this->getButtonStyles($params);
		$params['button_data'] = $this->getButtonDataAttr($params);
		$params['show_icon'] = !empty($params['icon']);
		$params['display_helper'] = $params['hover_animation'] !== '' && ($params['hover_type'] !== 'outline' || $params['hover_type'] !== 'white-outline');
		$params['helper_styles'] = $this->getHelperStyles($params);
		$params['icon_styles'] = $this->getIconHolderStyles($params);

		return edge_core_get_core_shortcode_template_part('templates/' . $params['html_type'], 'button', '', $params);
	}

	/**
	 * Returns array of button styles
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getButtonStyles($params) {
		$styles = array();

		if (!empty($params['color'])) {
			$styles[] = 'color: ' . $params['color'];
		}

		if (!empty($params['background_color']) && $params['type'] !== 'outline') {
			$styles[] = 'background-color: ' . $params['background_color'];
		}

		if (!empty($params['border_color'])) {
			$styles[] = 'border-color: ' . $params['border_color'];
		}

		if (!empty($params['font_size'])) {
			$styles[] = 'font-size: ' . eldritch_edge_filter_px($params['font_size']) . 'px';
		}

		if (!empty($params['font_weight'])) {
			$styles[] = 'font-weight: ' . $params['font_weight'];
		}

		if (!empty($params['margin'])) {
			$styles[] = 'margin: ' . $params['margin'];
		}

		return $styles;
	}

	/**
	 *
	 * Returns array of button data attr
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getButtonDataAttr($params) {
		$data = array();

		if (!empty($params['hover_background_color']) && ($params['hover_animation'] === '' || $params['hover_animation'] === 'disable')) {
			$data['data-hover-bg-color'] = $params['hover_background_color'];
		}

		if (!empty($params['hover_color'])) {
			$data['data-hover-color'] = $params['hover_color'];
		}

		if (!empty($params['hover_border_color'])) {
			$data['data-hover-border-color'] = $params['hover_border_color'];
		}

		return $data;
	}

	/**
	 * Returns array of HTML classes for button
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getButtonClasses($params) {
		$buttonClasses = array(
			'edgt-btn',
			'edgt-btn-' . $params['type']
		);

		if ($params['type'] != 'underline') {
			$buttonClasses[] = 'edgt-btn-' . $params['size'];
		}

		if (!empty($params['hover_background_color'])) {
			$buttonClasses[] = 'edgt-btn-custom-hover-bg';
		}

		if (!empty($params['hover_border_color'])) {
			$buttonClasses[] = 'edgt-btn-custom-border-hover';
		}

		if (!empty($params['hover_color'])) {
			$buttonClasses[] = 'edgt-btn-custom-hover-color';
		}

		if (!empty($params['icon'])) {
			$buttonClasses[] = 'edgt-btn-icon';
		}

		if (!empty($params['custom_class'])) {
			$buttonClasses[] = $params['custom_class'];
		}

		if (!empty($params['hover_animation']) && $params['hover_animation'] !== 'disable') {
			$buttonClasses[] = 'edgt-btn-' . $params['hover_animation'];
			$buttonClasses[] = 'edgt-btn-with-animation';
		}

		$hoverType = $this->getHoverStyle($params);
		$buttonClasses[] = 'edgt-btn-hover-' . $hoverType;

		return $buttonClasses;
	}

	private function getHoverStyle($params) {
		if (!empty($params['hover_type'])) {
			$hoverType = $params['hover_type'];
		} else {
			switch ($params['type']) {
				case 'outline':
				case 'white':
				case 'black':
					$hoverType = 'solid';
					break;
				case 'solid':
					$hoverType = 'solid';
					break;
				case 'underline':
					$hoverType = '';
					break;
				default:
					$hoverType = 'outline';
					break;
			}
		}

		return $hoverType;
	}

	private function getHoverAnimation($params) {
		if (!empty($params['hover_animation']) && ($params['hover_type'] !== 'outline' || $params['hover_type'] !== 'white-outline')) {
			return $params['hover_animation'];
		}

		return eldritch_edge_options()->getOptionValue('button_hover_animation');
	}

	private function getHelperStyles($params) {
		$styles = array();

		if ($params['display_helper']) {
			if (!empty($params['hover_background_color'])) {
				$styles[] = 'background-color: ' . $params['hover_background_color'];
			}
		}

		return $styles;
	}


	private function getIconHolderStyles($params){
		$styles ='';

		if($params['icon_font_size']!=''){
			$styles = 'font-size: ' . eldritch_edge_filter_px($params['icon_font_size']) . 'px;';
		}

		if($params['icon_margin']!=''){
			$styles .= 'margin: ' . $params['icon_margin'];
		}



		return $styles;
	}
}