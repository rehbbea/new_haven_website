<?php

namespace Eldritch\Modules\Shortcodes\ComparisonPricingTables;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ComparisonPricingTablesHolder implements ShortcodeInterface {
	private $base;

	/**
	 * ComparisonPricingTablesHolder constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_comparison_pricing_tables_holder';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => esc_html__('Comparison Pricing Tables', 'edge-core'),
			'base'                    => $this->base,
			'as_parent'               => array('only' => 'edgt_comparison_pricing_table'),
			'content_element'         => true,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                    => 'icon-wpb-cmp-pricing-tables extended-custom-icon',
			'show_settings_on_create' => true,
			'params'                  => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Columns', 'edge-core'),
					'param_name'  => 'columns',
					'value'       => array(
						esc_html__('Two', 'edge-core')   => 'edgt-two-columns',
						esc_html__('Three', 'edge-core') => 'edgt-three-columns',
						esc_html__('Four', 'edge-core')  => 'edgt-four-columns',
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'textarea',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Title', 'edge-core'),
					'param_name'  => 'title',
					'value'       => '',
					'save_always' => true
				),
				array(
					'type'        => 'exploded_textarea',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Features', 'edge-core'),
					'param_name'  => 'features',
					'value'       => '',
					'save_always' => true,
					'description' => esc_html__('Enter features. Separate each features with new line (enter).', 'edge-core')
				)
			),
			'js_view'                 => 'VcColumnView'
		));
	}

	public function render($atts, $content = null) {
		$args = array(
			'columns'  => 'edgt-two-columns',
			'features' => '',
			'title'    => '',
		);

		$params = shortcode_atts($args, $atts);

		$params['features'] = $this->getFeaturesArray($params);
		$params['content'] = $content;
		$params['holder_classes'] = $this->getHolderClasses($params);

		return edge_core_get_core_shortcode_template_part('templates/cpt-holder-template', 'comparison-pricing-tables', '', $params);
	}

	private function getFeaturesArray($params) {
		$features = array();

		if (!empty($params['features'])) {
			$features = explode(',', $params['features']);
		}

		return $features;
	}

	private function getHolderClasses($params) {
		$classes = array('edgt-comparision-pricing-tables-holder');

		if ($params['columns'] !== '') {
			$classes[] = $params['columns'];
		}

		return $classes;
	}
}