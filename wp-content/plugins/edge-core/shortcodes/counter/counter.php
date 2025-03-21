<?php
namespace Eldritch\Modules\Counter;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Counter
 */
class Counter implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_counter';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 *
	 * @see edgt_core_get_carousel_slider_array_vc()
	 */
	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Counter', 'edge-core'),
			'base'                      => $this->getBase(),
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'admin_enqueue_css'         => array(eldritch_edge_get_skin_uri() . '/assets/css/edgt-vc-extend.css'),
			'icon'                      => 'icon-wpb-counter extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    =>
				array(
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Type', 'edge-core'),
						'param_name'  => 'type',
						'value'       => array(
							esc_html__('Zero Counter', 'edge-core')   => 'zero',
							esc_html__('Random Counter', 'edge-core') => 'random'
						),
						'save_always' => true,
						'description' => ''
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Style', 'edge-core'),
						'param_name'  => 'counter_style',
						'value'       => array(
                            esc_html__('Default', 'edge-core')  => 'default',
							esc_html__('Dark', 'edge-core')  => 'dark',
							esc_html__('Light', 'edge-core') => 'light'
						),
						'description' => '',
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Digit', 'edge-core'),
						'param_name'  => 'digit',
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Title', 'edge-core'),
						'param_name'  => 'title',
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Text', 'edge-core'),
						'param_name'  => 'text',
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Link', 'edge-core'),
						'param_name'  => 'link',
						'value'       => '',
						'admin_label' => true
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Link Text', 'edge-core'),
						'param_name' => 'link_text',
						'dependency' => array(
							'element'   => 'link',
							'not_empty' => true
						)
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__('Target', 'edge-core'),
						'param_name' => 'link_target',
						'value'      => array(
							''                              => '',
							esc_html__('Self', 'edge-core')  => '_self',
							esc_html__('Blank', 'edge-core') => '_blank'
						),
						'dependency' => array(
							'element'   => 'link',
							'not_empty' => true
						),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Link Color', 'edge-core'),
						'param_name'  => 'color',
						'dependency'  => array(
							'element'   => 'link',
							'not_empty' => true
						),
						'admin_label' => true
					)
				)
		));
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'type'          => '',
			'digit'         => '',
			'title'         => '',
			'text'          => '',
			'counter_style' => 'default',
			'link'          => '',
			'link_text'     => '',
			'link_target'   => '_self',
			'color'         => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['counter_classes'] = $this->getCounterClasses($params);
		$params['button_parameters'] = $this->getButtonParameters($params);

		//Get HTML from template
		$html = edge_core_get_core_shortcode_template_part('templates/counter-template', 'counter', '', $params);

		return $html;

	}

	/**
	 * Returns array of holder classes
	 *
	 * @param $params
	 *
	 * @return array
	 */

	private function getCounterClasses($params) {
		$counter_classes = array('edgt-counter-holder');

		if ($params['counter_style'] === 'light') {
			$counter_classes[] = 'edgt-counter-light';
		} elseif ($params['counter_style'] === 'dark') {
            $counter_classes[] = 'edgt-counter-dark';
        }

		return $counter_classes;
	}

	private function getButtonParameters($params) {
		$button_params_array = array();

		$button_params_array['type'] = 'underline';
		$button_params_array['custom_class'] = 'edgt-counter-link';

		if (!empty($params['link_text'])) {
			$button_params_array['text'] = $params['link_text'];
		}

		if (!empty($params['link'])) {
			$button_params_array['link'] = $params['link'];
		}

		if (!empty($params['target'])) {
			$button_params_array['target'] = $params['target'];
		}

		if (!empty($params['color'])) {
			$button_params_array['color'] = $params['color'];
		}

		return $button_params_array;
	}

}