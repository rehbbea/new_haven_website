<?php
namespace Eldritch\Modules\Shortcodes\Icon;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Icon
 * @package Eldritch\Modules\Shortcodes\Icon
 */
class Icon implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	/**
	 * Icon constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_icon';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 *
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
			'name'                      => esc_html__('Icon', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-icons extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array_merge(
				\EldritchEdgeIconCollections::get_instance()->getVCParamsArray(),
				array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Size', 'edge-core'),
						'admin_label' => true,
						'param_name'  => 'size',
						'value'       => array(
							esc_html__('Tiny', 'edge-core')       => 'edgt-icon-tiny',
							esc_html__('Small', 'edge-core')      => 'edgt-icon-small',
							esc_html__('Medium', 'edge-core')     => 'edgt-icon-medium',
							esc_html__('Large', 'edge-core')      => 'edgt-icon-large',
							esc_html__('Very Large', 'edge-core') => 'edgt-icon-huge'
						),
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Custom Size (px)', 'edge-core'),
						'param_name'  => 'custom_size',
						'value'       => ''
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Type', 'edge-core'),
						'param_name'  => 'type',
						'admin_label' => true,
						'value'       => array(
							esc_html__('Normal', 'edge-core') => 'normal',
							esc_html__('Circle', 'edge-core') => 'circle',
							esc_html__('Square', 'edge-core') => 'square',
							esc_html__('Gradient', 'edge-core') => 'gradient',
						),
						'save_always' => true
					),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Gradient Style', 'edge-core'),
                        'param_name'  => 'gradient_style',
                        'admin_label' => true,
                        'value'       => array_flip(eldritch_edge_get_gradient_left_bottom_to_right_top_styles('-text')),
                        'dependency'  => array(
							'element' => 'type',
							'value' => array('gradient')
						),
                        'save_always' => true
                    ),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Shadow', 'edge-core'),
						'param_name'  => 'icon_shadow',
						'admin_label' => true,
						'value'       => array(
							esc_html__('No', 'edge-core')  => 'no',
							esc_html__('Yes', 'edge-core') => 'yes'
						),
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle')
						),
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Border radius', 'edge-core'),
						'param_name'  => 'border_radius',
						'description' => esc_html__('Please insert border radius(Rounded corners) in px. For example: 4 ', 'edge-core'),
						'dependency'  => array(
							'element' => 'type',
							'value' => array('square')
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Shape Size (px)', 'edge-core'),
						'param_name'  => 'shape_size',
						'admin_label' => true,
						'value'       => '',
						'description' => '',
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Line height (px)', 'edge-core'),
                        'param_name'  => 'line_height',
                        'admin_label' => true,
                        'value'       => '',
                        'description' => '',
                        'dependency'  => array(
                            'element' => 'type',
                            'value' => array('circle', 'square')
                        )
                    ),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Icon Color', 'edge-core'),
						'param_name'  => 'icon_color',
						'admin_label' => true,
                        'dependency'  => array(
							'element' => 'type',
							'value' => array('normal', 'circle', 'square')
						)
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Border Color', 'edge-core'),
						'param_name'  => 'border_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Border Width', 'edge-core'),
						'param_name'  => 'border_width',
						'admin_label' => true,
						'description' => esc_html__('Enter just number. Omit pixels', 'edge-core'),
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Background Color', 'edge-core'),
						'param_name'  => 'background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Icon Color', 'edge-core'),
						'param_name'  => 'hover_icon_color',
						'admin_label' => true,
                        'dependency'  => array(
							'element' => 'type',
							'value' => array('normal', 'circle', 'square')
						)
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Border Color', 'edge-core'),
						'param_name'  => 'hover_border_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Background Color', 'edge-core'),
						'param_name'  => 'hover_background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'type',
							'value' => array('circle', 'square')
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Margin', 'edge-core'),
						'param_name'  => 'margin',
						'admin_label' => true,
						'description' => esc_html__('Margin (top right bottom left)', 'edge-core')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Icon Animation', 'edge-core'),
						'param_name'  => 'icon_animation',
						'admin_label' => true,
						'value'       => array(
							esc_html__('No', 'edge-core')  => '',
							esc_html__('Yes', 'edge-core') => 'yes'
						),
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Icon Animation Delay (ms)', 'edge-core'),
						'param_name'  => 'icon_animation_delay',
						'value'       => '',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'icon_animation',
							'value' => 'yes'
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Link', 'edge-core'),
						'param_name'  => 'link',
						'value'       => '',
						'admin_label' => true
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__('Use Link as Anchor', 'edge-core'),
						'value'       => array(esc_html__('Use this icon as Anchor?', 'edge-core') => 'yes'),
						'param_name'  => 'anchor_icon',
						'admin_label' => true,
						'description' => esc_html__('Check this box to use icon as anchor link (eg. #contact)', 'edge-core'),
						'dependency'  => array(
							'element' => 'link',
							'not_empty' => true
						)
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Target', 'edge-core'),
						'param_name'  => 'target',
						'admin_label' => true,
						'value'       => array(
							esc_html__('Self', 'edge-core')  => '_self',
							esc_html__('Blank', 'edge-core') => '_blank'
						),
						'save_always' => true,
						'dependency'  => array(
							'element' => 'link',
							'not_empty' => true
						)
					)
				)
			)
		));
	}

	/**
	 * Renders shortcode's HTML
	 *
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {
		$default_atts = array(
			'size'                   => '',
			'custom_size'            => '',
			'type'                   => 'normal',
            'gradient_style'         => '',
			'icon_shadow'            => 'no',
			'border_radius'          => '',
            'line_height'            => '',
			'shape_size'             => '',
			'icon_color'             => '',
			'border_color'           => '',
			'border_width'           => '',
			'background_color'       => '',
			'hover_icon_color'       => '',
			'hover_border_color'     => '',
			'hover_background_color' => '',
			'margin'                 => '',
			'icon_animation'         => '',
			'icon_animation_delay'   => '',
			'link'                   => '',
			'anchor_icon'            => '',
			'target'                 => '_self'
		);

		$default_atts = array_merge($default_atts, eldritch_edge_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($default_atts, $atts);

		$iconPackName = eldritch_edge_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);

		//generate icon holder classes

		$iconHolderClasses = array('edgt-icon-shortcode', $params['type']);

		if ($params['icon_shadow'] == 'yes') {
			$iconHolderClasses[] = 'shadow';
		}

		if ($params['icon_animation'] == 'yes') {
			$iconHolderClasses[] = 'edgt-icon-animation';
		}

		if ($params['custom_size'] == '') {
			$iconHolderClasses[] = $params['size'];
		}

        if($params['type'] == 'gradient') {
            $iconHolderClasses[] = $params['gradient_style'];
        }

		//prepare params for template
		$params['icon'] = $params[$iconPackName];
		$params['icon_holder_classes'] = $iconHolderClasses;
		$params['icon_holder_styles'] = $this->generateIconHolderStyles($params);
		$params['icon_holder_data'] = $this->generateIconHolderData($params);
		$params['icon_params'] = $this->generateIconParams($params);
		$params['icon_animation_holder'] = isset($params['icon_animation']) && $params['icon_animation'] == 'yes';
		$params['icon_animation_holder_styles'] = $this->generateIconAnimationHolderStyles($params);

		$html = edge_core_get_core_shortcode_template_part('templates/icon', 'icon', '', $params);

		return $html;
	}

	/**
	 * Generates icon parameters array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function generateIconParams($params) {
		$iconParams = array('icon_attributes' => array());

		$iconParams['icon_attributes']['style'] = $this->generateIconStyles($params);
		$iconParams['icon_attributes']['class'] = 'edgt-icon-element';

		return $iconParams;
	}

	/**
	 * Generates icon styles array
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function generateIconStyles($params) {
		$iconStyles = array();

		if (!empty($params['icon_color'])) {
			$iconStyles[] = 'color: ' . $params['icon_color'];
		}

		if (($params['type'] !== 'normal' && !empty($params['shape_size'])) ||
			($params['type'] == 'normal')
		) {
			if (!empty($params['custom_size'])) {
				$iconStyles[] = 'font-size:' . eldritch_edge_filter_px($params['custom_size']) . 'px';
			}
		}

		return implode(';', $iconStyles);
	}

	/**
	 * Generates icon holder styles for circle and square icon type
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function generateIconHolderStyles($params) {
		$iconHolderStyles = array();

		if (isset($params['margin']) && $params['margin'] !== '') {
			$iconHolderStyles[] = 'margin: ' . $params['margin'];
		}

		//generate styles attribute only if type isn't normal
		if (isset($params['type']) && $params['type'] !== 'normal') {
			$shapeSize = '';
			if (!empty($params['shape_size'])) {
				$shapeSize = $params['shape_size'];
			} elseif (!empty($params['custom_size'])) {
				$shapeSize = $params['custom_size'];
			}

			if (!empty($shapeSize)) {
				$iconHolderStyles[] = 'width: ' . eldritch_edge_filter_px($shapeSize) . 'px';
				$iconHolderStyles[] = 'height: ' . eldritch_edge_filter_px($shapeSize) . 'px';
			}

            if ($params['line_height'] !== '') {
                $iconHolderStyles[] = 'line-height: ' . eldritch_edge_filter_px($params['line_height']) . 'px';
            } else {
                $iconHolderStyles[] = 'line-height: ' . eldritch_edge_filter_px($shapeSize) . 'px';
            }

			if (!empty($params['background_color'])) {
				$iconHolderStyles[] = 'background-color: ' . $params['background_color'];
			}

			if (!empty($params['border_color']) && (isset($params['border_width']) && $params['border_width'] !== '')) {
				$iconHolderStyles[] = 'border-style: solid';
				$iconHolderStyles[] = 'border-color: ' . $params['border_color'];
				$iconHolderStyles[] = 'border-width: ' . eldritch_edge_filter_px($params['border_width']) . 'px';
			} else if (isset($params['border_width']) && $params['border_width'] !== '') {
				$iconHolderStyles[] = 'border-style: solid';
				$iconHolderStyles[] = 'border-width: ' . eldritch_edge_filter_px($params['border_width']) . 'px';
			} else if (!empty($params['border_color'])) {
				$iconHolderStyles[] = 'border-color: ' . $params['border_color'];
			}

			if ($params['type'] == 'square') {
				if (isset($params['border_radius']) && $params['border_radius'] !== '') {
					$iconHolderStyles[] = 'border-radius: ' . eldritch_edge_filter_px($params['border_radius']) . 'px';
				}
			}
		}

		return $iconHolderStyles;
	}

	/**
	 * Generates icon holder data attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function generateIconHolderData($params) {
		$iconHolderData = array();

		if (isset($params['type']) && $params['type'] !== 'normal') {
			if (!empty($params['hover_border_color'])) {
				$iconHolderData['data-hover-border-color'] = $params['hover_border_color'];
			}

			if (!empty($params['hover_background_color'])) {
				$iconHolderData['data-hover-background-color'] = $params['hover_background_color'];
			}
		}

		if ((isset($params['icon_animation']) && $params['icon_animation'] == 'yes')
			&& (isset($params['icon_animation_delay']) && $params['icon_animation_delay'] !== '')
		) {
			$iconHolderData['data-animation-delay'] = $params['icon_animation_delay'];
		}

		if (!empty($params['hover_icon_color'])) {
			$iconHolderData['data-hover-color'] = $params['hover_icon_color'];
		}

		if (!empty($params['icon_color'])) {
			$iconHolderData['data-color'] = $params['icon_color'];
		}

		return $iconHolderData;
	}

	private function generateIconAnimationHolderStyles($params) {
		$styles = array();

		if ((isset($params['icon_animation']) && $params['icon_animation'] == 'yes')
			&& (isset($params['icon_animation_delay']) && $params['icon_animation_delay'] !== '')
		) {
			$styles[] = 'transition-delay: ' . $params['icon_animation_delay'] . 'ms';
			$styles[] = '-webkit-transition-delay: ' . $params['icon_animation_delay'] . 'ms';
			$styles[] = '-moz-transition-delay: ' . $params['icon_animation_delay'] . 'ms';
			$styles[] = '-ms-transition-delay: ' . $params['icon_animation_delay'] . 'ms';
		}

		return $styles;
	}
}