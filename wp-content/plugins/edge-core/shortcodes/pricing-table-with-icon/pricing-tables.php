<?php
namespace Eldritch\Modules\PricingTablesWithIcon;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class PricingTablesWithIcon implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_pricing_tables_with_icon';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => esc_html__('Pricing Tables With Icon', 'edge-core'),
			'base'                    => $this->base,
			'as_parent'               => array('only' => 'edgt_pricing_table_with_icon'),
			'content_element'         => true,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                    => 'icon-wpb-pricing-tables-wi extended-custom-icon',
			'show_settings_on_create' => false,
			'js_view'                 => 'VcColumnView'
		));
	}

	public function render($atts, $content = null) {

		$html = '<div class="edgt-pricing-tables-wi clearfix">';
		$html .= do_shortcode($content);
		$html .= '</div>';

		return $html;
	}
}