<?php
namespace Eldritch\Modules\UnorderedList;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class unordered List
 */
class UnorderedList implements ShortcodeInterface {

	private $base;

	function __construct() {
		$this->base = 'edgt_unordered_list';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**\
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('List - Unordered', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-unordered-list extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Style', 'edge-core'),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__('Circle', 'edge-core') => 'circle',
						esc_html__('Line', 'edge-core')   => 'line'
					),
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Animate List', 'edge-core'),
					'param_name'  => 'animate',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Font Weight', 'edge-core'),
					'param_name'  => 'font_weight',
					'value'       => array(
						esc_html__('Default', 'edge-core') => '',
						esc_html__('Light', 'edge-core')   => 'light',
						esc_html__('Normal', 'edge-core')  => 'normal',
						esc_html__('Bold', 'edge-core')    => 'bold'
					),
					'description' => ''
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Padding left (px)', 'edge-core'),
					'param_name' => 'padding_left',
					'value'      => ''
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__('Content', 'edge-core'),
					'param_name'  => 'content',
					'value'       => '<ul><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li><li>' . esc_html__('Lorem Ipsum', 'edge-core') . '</li></ul>',
					'description' => ''
				)
			)
		));

	}


	public function render($atts, $content = null) {
		$args = array(
			'style'        => '',
			'animate'      => '',
			'font_weight'  => '',
			'padding_left' => ''
		);
		$params = shortcode_atts($args, $atts);

		//Extract params for use in method
		extract($params);

		$list_item_classes = "";

		if ($style != '') {
			if ($style == 'circle') {
				$list_item_classes .= ' edgt-circle';
			} elseif ($style == 'line') {
				$list_item_classes .= ' edgt-line';
			}
		}

		if ($animate == 'yes') {
			$list_item_classes .= ' edgt-animate-list';
		}

		$list_style = '';
		if ($padding_left != '') {
			$list_style .= 'padding-left: ' . $padding_left . 'px;';
		}
		$html = '';

		$html .= '<div class="edgt-unordered-list ' . $list_item_classes . '" ' . eldritch_edge_get_inline_style($list_style) . '>';
		$html .= eldritch_edge_remove_auto_ptag($content, true);
		$html .= '</div>';

		return $html;
	}

}