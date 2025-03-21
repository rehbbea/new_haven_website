<?php
namespace Eldritch\Modules\Shortcodes\TwitterSlider;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class TwitterSlider implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'edgt_twitter_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 *
	 */
	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Twitter Slider', 'edge-core'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-twitter-slider extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('User ID', 'edge-core'),
					'param_name'  => 'user_id',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Number of tweets', 'edge-core'),
					'param_name'  => 'count',
					'value'       => '',
					'description' => esc_html__('Default Number is 4', 'edge-core'),
					'admin_label' => true
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Tweets Color', 'edge-core'),
					'param_name'  => 'tweets_color',
					'value'       => '',
					'description' => '',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__('Tweet Cache Time', 'edge-core'),
					'param_name'  => 'transient_time',
					'value'       => '',
					'admin_label' => true
				)
			)
		));
	}


	/**
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {
		$params = array(
			'user_id'        => '',
			'count'          => '4',
			'tweets_color'   => '',
			'transient_time' => '0'
		);

		$params = shortcode_atts($params, $atts);

		$html = '';

		$twitter_api = \EdgeTwitterApi::getInstance();

		if ($twitter_api->hasUserConnected()) {
			$response = $twitter_api->fetchTweets($params['user_id'], $params['count'], array(
				'transient_time' => $params['transient_time'],
				'transient_id'   => 'edgt_twitter_slider_cache'
			));

			$params['response'] = $response;
			$params['twitter_api'] = $twitter_api;
			$params['tweet_styles'] = $this->getTweetStyles($params);

			$html .= edge_core_get_core_shortcode_template_part('templates/twitter-slider', 'twitter-slider', '', $params);
		} else {
			$html .= esc_html__('It seams that you haven\'t connected with your Twitter account', 'edge-core');
		}

		return $html;
	}

	/**
	 * @param $params
	 *
	 * @return array
	 */
	private function getTweetStyles($params) {
		$styles = array();

		if (!empty($params['tweets_color'])) {
			$styles[] = 'color: ' . $params['tweets_color'];
		}

		return $styles;
	}

}