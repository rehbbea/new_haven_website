<?php
namespace Eldritch\Modules\ImageWithTextOver;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class ImageWithTextOver
 */
class ImageWithTextOver implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_image_with_text_over';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Image With Text Over', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-image-with-text-over extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__('Image', 'edge-core'),
					'param_name'  => 'image',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Text', 'edge-core'),
					'param_name'  => 'text',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Link', 'edge-core'),
					'param_name'  => 'link',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Link Target', 'edge-core'),
					'param_name'  => 'link_target',
					'value'       => array(
						esc_html__('Same Window', 'edge-core')     => '_self',
						esc_html__('New Window', 'edge-core')      => '_blank'
					),
					'dependency'  => array(
						'element'   => 'link',
						'not_empty' => true
					),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Enable Hover Animation', 'edge-core'),
					'param_name'  => 'enable_hover_animation',
					'value'       => array(
						esc_html__('Yes', 'edge-core')     => 'yes',
						esc_html__('No', 'edge-core')      => ''
					),
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Text font size (px)', 'edge-core'),
					'param_name'  => 'font_size',
					'group'		  => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Overlay Text color', 'edge-core'),
					'param_name'  => 'text_color',
					'group'		  => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Overlay color', 'edge-core'),
					'param_name'  => 'text_background_color',
					'group'		  => esc_html__('Design Options', 'edge-core')
				),
			)
		));

	}

	public function render($atts, $content = null) {

		$args = array(
			'image'     	=> '',
			'text'      	=> '',
			'link'      	=> '',
			'link_target'   => '_self',
			'enable_hover_animation' => '',
			'font_size' 	=> '',
			'text_color'	=> '',
			'text_background_color'	=> '',
		);

		$params = shortcode_atts($args, $atts);

		$params['text_style'] = $this->getTextStyle($params);
		$params['holder_classes'] = $this->getIwtOverClasses($params);

		$html = edge_core_get_core_shortcode_template_part('templates/image-with-text-over-template', 'image-with-text-over', '', $params);

		return $html;
	}

	/* Return Style for text
	*
	* @param $params
	*
	* @return string
	*/
	private function getTextStyle($params) {

		$styles = array();

		if (!empty($params['font_size'])) {
			$styles[] = 'font-size: ' . eldritch_edge_filter_px($params['font_size']) . 'px';
		}

		if (!empty($params['text_color'])) {
			$styles[] = 'color: ' . $params['text_color'];
		}

		if (!empty($params['text_background_color'])) {
			$styles[] = 'background-color: ' . $params['text_background_color'];
		}

		return $styles;
	}

	/**
	 * Return Classes for IWT Over 
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getIwtOverClasses($params) {
		$classes = array("edgt-iwt-over");

		if ($params['enable_hover_animation'] == 'yes') {
			$classes[] = 'edgt-enable-hover-animation';
		}

		return $classes;
	}
}