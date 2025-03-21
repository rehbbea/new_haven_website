<?php
namespace Eldritch\Modules\Shortcodes\TeamSliderItem;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Team Slider Item
 */
class TeamSliderItem implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_team_slider_item';

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
			'name'                      => esc_html__('Team Slider Item', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'as_child'                  => array('only' => 'edgt_team_slider'),
			'icon'                      => 'icon-wpb-team-slider-item extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__('Logo image', 'edge-core'),
					'param_name'  => 'logo_image',
					'description' => esc_html__('This image is shown if boxed slider type is selected', 'edge-core'),
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Team member image', 'edge-core'),
					'param_name' => 'team_member_image'
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Name', 'edge-core'),
					'param_name' => 'name'
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Position', 'edge-core'),
					'param_name' => 'position'
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Text', 'edge-core'),
					'param_name' => 'text'
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
		$default_atts = array(
			'slider_type'       => $atts['slider_type'],
			'logo_image'        => '',
			'team_member_image' => '',
			'name'              => '',
			'text'              => '',
			'position'          => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		return edge_core_get_core_shortcode_template_part('templates/' . $params['slider_type'] . '-team-slide', 'team-slider', '', $params);
	}


}