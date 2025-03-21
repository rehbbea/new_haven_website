<?php
namespace Eldritch\Modules\Shortcodes\Process;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ProcessHolder implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'edgt_process_holder';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => esc_html__('Process', 'edge-core'),
			'base'                    => $this->getBase(),
			'as_parent'               => array('only' => 'edgt_process_item'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                    => 'icon-wpb-process-holder extended-custom-icon',
			'js_view'                 => 'VcColumnView',
			'params'                  => array(
				array(
					'type'        => 'dropdown',
					'param_name'  => 'process_type',
					'heading'     => esc_html__('Process type', 'edge-core'),
					'value'       => array(
						esc_html__('Horizontal', 'edge-core') => 'horizontal_process',
						esc_html__('Vertical', 'edge-core')   => 'vertical_process'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'process_skin',
					'heading'     => esc_html__('Skin', 'edge-core'),
					'value'       => array(
						esc_html__('Dark', 'edge-core')  => 'dark',
						esc_html__('Light', 'edge-core') => 'light'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'number_of_items',
					'heading'     => esc_html__('Number of Process Items', 'edge-core'),
					'value'       => array(
						esc_html__('Three', 'edge-core') => 'three',
						esc_html__('Four', 'edge-core')  => 'four'
					),
					'dependency'  => array(
						'element' => 'process_type',
						'value'   => 'horizontal_process'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => ''
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'process_type'    => 'horizontal_process',
			'process_skin'    => '',
			'number_of_items' => ''
		);

		$params = shortcode_atts($default_atts, $atts);
		$params['content'] = $content;
		$params['holder_classes'] = $this->getClasses($params);

		if ($params['process_type'] == 'horizontal_process') {
			return edge_core_get_core_shortcode_template_part('templates/horizontal-process-holder-template', 'process', '', $params);
		} else {
			return edge_core_get_core_shortcode_template_part('templates/vertical-process-holder-template', 'process', '', $params);
		}
	}

	public function getClasses($params) {
		$holder_classes = array('edgt-process-holder');
		$holder_classes[] = 'edgt-process-' . $params['process_skin'];

		if ($params['process_type'] == 'horizontal_process') {
			$holder_classes[] = 'edgt-process-horizontal';
			$holder_classes[] = 'edgt-process-holder-items-' . $params['number_of_items'];
		} else {
			$holder_classes[] = 'edgt-process-vertical';
		}

		return $holder_classes;
	}
}