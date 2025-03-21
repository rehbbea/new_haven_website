<?php
namespace Eldritch\Modules\VideoButton;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class VideoButton
 */
class VideoButton implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_video_button';

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
			'name'                      => esc_html__('Video Button', 'edge-core'),
			'base'                      => $this->getBase(),
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-video-button extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Video Link', 'edge-core'),
					'param_name' => 'video_link',
					'value'      => ''
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title', 'edge-core'),
					'param_name' => 'title',
					'value'      => '',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Video Button Style', 'edge-core'),
					'param_name'  => 'title_style',
					'value'       => array(
						esc_html__('Dark', 'edge-core')  => 'dark',
						esc_html__('Light', 'edge-core') => 'light'
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Title Tag', 'edge-core'),
					'param_name' => 'title_tag',
					'value'      => array(
						'h1' => 'h1',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
					),
					'dependency' => array(
						'element'   => 'title',
						'not_empty' => true
					)
				),
			)
		));

	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
            'video_link'     => '#',
			'title'          => '',
			'title_style'    => 'dark',
			'title_tag'      => 'h1',
		);

		$params = shortcode_atts($args, $atts);

		$title_class = '';

		if ($params['title_style'] === 'light') {
			$title_class .= 'edgt-light';
		}

		$params['button_light'] = $title_class;
        
		$params['video_title_tag'] = $this->getVideoButtonTitleTag($params, $args);

		//Get HTML from template
		$html = edge_core_get_core_shortcode_template_part('templates/video-button-template', 'videobutton', '', $params);

		return $html;

	}

	/**
	 * Return Title Tag. If provided heading isn't valid get the default one
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getVideoButtonTitleTag($params, $args) {
		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		return (in_array($params['title_tag'], $headings_array)) ? $params['title_tag'] : $args['title_tag'];
	}
}