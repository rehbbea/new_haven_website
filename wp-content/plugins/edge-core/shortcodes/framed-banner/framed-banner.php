<?php
namespace Eldritch\Modules\FramedBanner;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class FramedBanner
 */
class FramedBanner implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_framed_banner';

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
			'name'                      => esc_html__('Framed Banner', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-framed-banner extended-custom-icon',
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
				)
			)
		));

	}

	public function render($atts, $content = null) {

		$args = array(
			'image'     			=> '',
			'text'      			=> '',
			'link'      			=> '',
			'link_target'   		=> '_self'
		);

		$params = shortcode_atts($args, $atts);

		$html = edge_core_get_core_shortcode_template_part('templates/framed-banner-template', 'framed-banner', '', $params);

		return $html;
	}
}