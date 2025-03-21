<?php

namespace Eldritch\Modules\Shortcodes\CardSlider;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class CardSlider implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'edgt_card_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'         => esc_html__('Card Slider', 'edge-core'),
			'base'         => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'         => 'icon-wpb-card-slider extended-custom-icon',
			'is_container' => true,
			'js_view'      => 'VcColumnView',
			'as_parent'    => array('only' => 'edgt_card_slider_item'),
			'params'       => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Number of Items in Row', 'edge-core'),
					'param_name'  => 'number_of_items',
					'description' => '',
					'value'       => array(
						'3' => '3',
						'4' => '4',
					),
					'save_always' => true
				),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Force In Grid', 'edge-core'),
                    'param_name'  => 'force_grid',
                    'value'       => array(
                        'Yes' => 'yes',
                        'No'  => 'no'
                    ),
                    'save_always' => true,
                ),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Show Navigation Dots', 'edge-core'),
					'param_name'  => 'dots',
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Text Align', 'edge-core'),
					'param_name'  => 'text_align',
					'value'       => array(
						esc_html__('Left', 'edge-core')   => 'left',
						esc_html__('Center', 'edge-core') => 'center',
						esc_html__('Right', 'edge-core')  => 'right'
					),
					'save_always' => true,
				),
                array(
                    'type' => 'dropdown',
                    'admin_label' => true,
                    'heading' => esc_html__('Skin', 'edge-core'),
                    'param_name' => 'skin',
                    'value' => array(
                        esc_html__('Default', 'edge-core') => 'default',
                        esc_html__('Dark', 'edge-core') => 'edgt-dark-skin',
                        esc_html__('Light', 'edge-core') => 'edgt-light-skin'
                    ),
                    'description' => '',
                    'save_always' => true
                ),
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'number_of_items' => '3',
			'force_grid'            => 'yes',
			'dots'            => 'yes',
			'text_align'      => 'left',
			'skin'      => 'default'
		);

		$params = shortcode_atts($default_atts, $atts);

		/* proceed slider type parameter to nested shortcode in order to call proper template */
		$params['content'] = $content;
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['slider_classes'] = $this->getSliderStyle($params);
		$params['data_attrs'] = $this->getDataAttribute($params);
		$params['styles'] = $this->getElementStyles($params);

		return edge_core_get_core_shortcode_template_part('templates/card-slider-template', 'card-slider', '', $params);
	}

	/**
	 * Returns array of holder classes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getHolderClasses($params) {
		$classes = array('edgt-card-slider-holder');

        if ($params['force_grid'] == 'yes') {
            $classes[] = 'edgt-grid';
        }

        if ($params['skin'] != 'default') {
            $classes[] = $params['skin'];
        }

		return $classes;
	}

	/**
	 * Return Card Slider data attribute
	 *
	 * @param $params
	 *
	 * @return string
	 */

	private function getDataAttribute($params) {

		$data_attrs = array();

		if ($params['number_of_items'] !== '') {
			$data_attrs['data-number_of_items'] = $params['number_of_items'];
		}

		if ($params['number_of_items'] !== '') {
			$data_attrs['data-dots'] = ($params['dots'] !== '') ? $params['dots'] : '';
		}

		return $data_attrs;
	}

	/**
	 * Returns array of element styles
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementStyles($params) {
		$styles = array();

		if (!empty($params['text_align'])) {
			$styles[] = 'text-align: ' . $params['text_align'];
		}

		return $styles;
	}

    /**
     * Generates sldier holder styles
     *
     * @param $params
     *
     * @return array
     */
    private function getSliderStyle($params) {
        $classes = array();


        if ($params['skin'] == 'edgt-dark-skin') {
            $classes[] = 'edgt-dark-navigation';
        }

        if ($params['skin'] == 'edgt-light-skin') {
            $classes[] = 'edgt-light-navigation';
        }


        return implode(';', $classes);
    }
}