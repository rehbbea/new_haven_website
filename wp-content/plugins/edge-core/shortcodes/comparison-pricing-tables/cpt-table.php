<?php

namespace Eldritch\Modules\Shortcodes\ComparisonPricingTables;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ComparisonPricingTable implements ShortcodeInterface {
	private $base;

	/**
	 * ComparisonPricingTable constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_comparison_pricing_table';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Comparison Pricing Table', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-cmp-pricing-table extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'as_child'                  => array('only' => 'edgt_comparison_pricing_tables_holder'),
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Title', 'edge-core'),
					'param_name'  => 'title',
					'value'       => esc_html__('Basic Plan', 'edge-core'),
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Title Size (px)', 'edge-core'),
					'param_name'  => 'title_size',
					'value'       => '',
					'description' => '',
					'dependency'  => array(
						'element'   => 'title',
						'not_empty' => true
					),
					'group'       => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Price', 'edge-core'),
					'param_name'  => 'price',
					'description' => esc_html__('Default value is 100', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Currency', 'edge-core'),
					'param_name'  => 'currency',
					'description' => esc_html__('Default mark is $', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Price Period', 'edge-core'),
					'param_name'  => 'price_period',
					'description' => esc_html__('Default label is monthly', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Featured package', 'edge-core'),
					'param_name'  => 'featured_package',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'description' => '',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Show Button', 'edge-core'),
					'param_name'  => 'show_button',
					'value'       => array(
						esc_html__('Yes', 'edge-core')     => 'yes',
						esc_html__('No', 'edge-core')      => 'no'
					),
					'description' => '',
					'save_always' => true,
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Button Text', 'edge-core'),
					'param_name'  => 'button_text',
					'dependency'  => array(
						'element' => 'show_button',
						'value'   => 'yes'
					)
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Button Link', 'edge-core'),
					'param_name'  => 'button_link',
					'dependency'  => array(
						'element' => 'show_button',
						'value'   => 'yes'
					)
				),
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Content', 'edge-core'),
					'param_name'  => 'content',
					'value'       => '<li>' . esc_html__('content content content', 'edge-core') . '</li><li>' . esc_html__('content content content', 'edge-core') . '</li><li>' . esc_html__('content content content', 'edge-core') . '</li>',
					'description' => '',
					'admin_label' => false
				),
				array(
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Border Top Color', 'edge-core'),
					'param_name'  => 'border_top_color',
					'value'       => '',
					'save_always' => true,
					'group'       => esc_html__('Design Options', 'edge-core')
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$args = array(
			'title'            => esc_html__('Basic Plan', 'edge-core'),
			'title_size'       => '',
			'price'            => '100',
			'currency'         => '',
			'price_period'     => '',
			'show_button'      => 'yes',
			'featured_package' => 'no',
			'button_link'      => '',
			'button_text'      => 'button',
			'border_top_color' => '',
		);

		$params = shortcode_atts($args, $atts);

		$params['content'] = $content;
		$params['border_style'] = $this->getBorderStyles($params);
		$params['display_border'] = is_array($params['border_style']) && count($params['border_style']);
		$params['table_classes'] = $this->getTableClasses($params);
		$params['button_parameters'] = $this->getButtonParameters($params);

		return edge_core_get_core_shortcode_template_part('templates/cpt-table-template', 'comparison-pricing-tables', '', $params);
	}

	private function getTableClasses($params) {
		$classes = array('edgt-comparision-table-holder', 'edgt-cpt-table');

		if ($params['featured_package'] == 'yes') {
			$classes[] = 'edgt-featured-comparision-table';
		}

		return $classes;
	}

	private function getBorderStyles($params) {
		$styles = array();

		if ($params['border_top_color'] !== '') {
			$styles[] = 'background-color: ' . $params['border_top_color'];
		}

		return $styles;
	}

	private function getButtonParameters($params) {
		$button_params_array = array();

		if (!empty($params['button_text'])) {
			$button_params_array['text'] = $params['button_text'];
		}

		if (!empty($params['button_link'])) {
			$button_params_array['link'] = $params['button_link'];
		}

		$button_params_array['size'] = 'small';


		$button_params_array['type'] = 'outline';

		return $button_params_array;
	}
}