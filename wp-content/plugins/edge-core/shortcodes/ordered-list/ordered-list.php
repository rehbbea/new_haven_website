<?php
namespace Eldritch\Modules\OrderedList;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class OrderedList implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_list_ordered';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('List - Ordered', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-ordered-list extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Content', 'edge-core'),
					'param_name'  => 'content',
					'value'       => '<ol><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li></ol>',
					'description' => ''
				)
			)
		));

	}

	public function render($atts, $content = null) {
		$html = '';
		$html .= '<div class= "edgt-ordered-list" >' . eldritch_edge_remove_auto_ptag($content, true) . '</div>';

		return $html;
	}

}

