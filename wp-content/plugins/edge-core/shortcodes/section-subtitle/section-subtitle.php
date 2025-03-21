<?php
namespace Eldritch\Modules\Shortcodes\SectionSubtitle;

use Eldritch\Modules\Shortcodes\Lib;

class SectionSubtitle implements Lib\ShortcodeInterface {
	private $base;

	/**
	 * SectionSubtitle constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_section_subtitle';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Section Subtitle', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-section-subtitle extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Color', 'edge-core'),
					'param_name'  => 'color',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Choose color of your subtitle', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Text Align', 'edge-core'),
					'param_name'  => 'text_align',
					'value'       => array(
						''                                  => '',
						esc_html__('Center', 'edge-core') => 'center',
						esc_html__('Left', 'edge-core')   => 'left',
						esc_html__('Right', 'edge-core')  => 'right'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Choose color of your subtitle', 'edge-core')
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__('Text', 'edge-core'),
					'param_name'  => 'text',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Width (%)', 'edge-core'),
					'param_name'  => 'width',
					'description' => esc_html__('Adjust the width of section subtitle in percentages. Ommit the unit', 'edge-core'),
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'text'       => '',
			'color'      => '',
			'text_align' => '',
			'width'      => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		if ($params['text'] !== '') {

			$params['styles'] = array();
			$params['classes'] = array('edgt-section-subtitle-holder');

			if ($params['color'] !== '') {
				$params['styles'][] = 'color: ' . $params['color'];
			}

			if ($params['text_align'] !== '') {
				$params['styles'][] = 'text-align: ' . $params['text_align'];

				$params['classes'][] = 'edgt-section-subtitle-' . $params['text_align'];
			}

			$params['holder_styles'] = array();

			if ($params['width'] !== '') {
				$params['holder_styles'][] = 'width: ' . $params['width'] . '%';
			}

			return edge_core_get_core_shortcode_template_part('templates/section-subtitle-template', 'section-subtitle', '', $params);
		}
	}

}
