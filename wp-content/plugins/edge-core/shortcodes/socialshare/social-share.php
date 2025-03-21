<?php
namespace Eldritch\Modules\SocialShare;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class SocialShare implements ShortcodeInterface {

	private $base;
	private $socialNetworks;

	function __construct() {
		$this->base = 'edgt_social_share';
		$this->socialNetworks = array(
			'facebook',
			'twitter',
			'google_plus',
			'linkedin',
			'tumblr',
			'pinterest',
			'vk'
		);
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function getSocialNetworks() {
		return $this->socialNetworks;
	}

	/**
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 */
	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Social Share', 'edge-core'),
			'base'                      => $this->getBase(),
			'icon'                      => 'icon-wpb-social-share extended-custom-icon',
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Type', 'edge-core'),
					'param_name'  => 'type',
					'admin_label' => true,
					'description' => esc_html__('Choose type of Social Share', 'edge-core'),
					'value'       => array(
						esc_html__('List', 'edge-core')     => 'list',
						esc_html__('Dropdown', 'edge-core') => 'dropdown'
					),
					'save_always' => true
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
			'type' => 'list'
		);

		//Shortcode Parameters
		$params = shortcode_atts($args, $atts);

		//Is social share enabled
		$params['enable_social_share'] = (eldritch_edge_options()->getOptionValue('enable_social_share') == 'yes') ? true : false;

		//Is social share enabled for post type
		$post_type = get_post_type();
		$params['enabled'] = (eldritch_edge_options()->getOptionValue('enable_social_share_on_' . $post_type)) ? true : false;


		//Social Networks Data
		$params['networks'] = $this->getSocialNetworksParams($params);

		$html = '';

		if ($params['enable_social_share']) {
			if ($params['enabled']) {
				$html .= edge_core_get_core_shortcode_template_part('templates/' . $params['type'], 'socialshare', '', $params);
			}
		}

		return $html;

	}

	/**
	 * Get Social Networks data to display
	 * @return array
	 */
	private function getSocialNetworksParams($params) {

		$networks = array();

		foreach ($this->socialNetworks as $net) {

			$html = '';
			if (eldritch_edge_options()->getOptionValue('enable_' . $net . '_share') == 'yes') {

				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$params = array(
					'name' => $net,
					'type' => $params['type']
				);
				$params['link'] = $this->getSocialNetworkShareLink($net, $image);
				$params['label'] = $this->getSocialNetworkLabel($net);
				$params['icon'] = $this->getSocialNetworkIcon($net);
				$params['class_name'] = $this->getSocialNetworkClass($net);
				$params['custom_icon'] = (eldritch_edge_options()->getOptionValue($net . '_icon')) ? eldritch_edge_options()->getOptionValue($net . '_icon') : '';
				$html = edge_core_get_core_shortcode_template_part('templates/parts/network', 'socialshare', '', $params);

			}

			$networks[$net] = $html;

		}

		return $networks;

	}

	/**
	 * Get share link for networks
	 *
	 * @param $net
	 * @param $image
	 *
	 * @return string
	 */
	private function getSocialNetworkShareLink($net, $image) {
		$image = ! empty( $image ) && isset( $image[0] ) ? $image : array('');
		
		switch ($net) {
			case 'facebook':
				if (wp_is_mobile()) {
					$link = 'window.open(\'https://m.facebook.com/sharer.php?u=' . urlencode(get_permalink()) . '\');';
				} else {
					$link = 'window.open(\'https://www.facebook.com/sharer.php?u=' . urlencode(get_permalink()) . '\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');';
				}
				break;
			case 'twitter':
				$count_char = (is_ssl()) ? 23 : 22;
				$twitter_via = (eldritch_edge_options()->getOptionValue('twitter_via') !== '') ? ' via ' . eldritch_edge_options()->getOptionValue('twitter_via') . ' ' : '';
				$link =  'window.open(\'https://twitter.com/intent/tweet?text=' . urlencode( eldritch_edge_the_excerpt_max_charlength( $count_char ) . $twitter_via ) . ' ' . get_permalink() . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');';
				break;
			case 'google_plus':
				$link = 'popUp=window.open(\'https://plus.google.com/share?url=' . urlencode(get_permalink()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;';
				break;
			case 'linkedin':
				$link = 'popUp=window.open(\'https://linkedin.com/shareArticle?mini=true&amp;url=' . urlencode(get_permalink()) . '&amp;title=' . urlencode(get_the_title()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;';
				break;
			case 'tumblr':
				$link = 'popUp=window.open(\'https://www.tumblr.com/share/link?url=' . urlencode(get_permalink()) . '&amp;name=' . urlencode(get_the_title()) . '&amp;description=' . urlencode(get_the_excerpt()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;';
				break;
			case 'pinterest':
				$link = 'popUp=window.open(\'https://pinterest.com/pin/create/button/?url=' . urlencode(get_permalink()) . '&amp;description=' . sanitize_title(get_the_title()) . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;';
				break;
			case 'vk':
				$link = 'popUp=window.open(\'https://vkontakte.ru/share.php?url=' . urlencode(get_permalink()) . '&amp;title=' . urlencode(get_the_title()) . '&amp;description=' . urlencode(get_the_excerpt()) . '&amp;image=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;';
				break;
			default:
				$link = '';
		}

		return $link;

	}

	private function getSocialNetworkIcon($net) {

		switch ($net) {
			case 'facebook':
				$icon = 'fa fa-facebook';
				break;
			case 'twitter':
				$icon = 'fa fa-twitter';
				break;
			case 'google_plus':
				$icon = 'fa fa-google-plus';
				break;
			case 'linkedin':
				$icon = 'fa fa-linkedin';
				break;
			case 'tumblr':
				$icon = 'fa fa-tumblr';
				break;
			case 'pinterest':
				$icon = 'fa fa-pinterest-p';
				break;
			case 'vk':
				$icon = 'fa fa-vk';
				break;
			default:
				$icon = '';
		}

		return $icon;

	}

	private function getSocialNetworkClass($net) {
		$classes = array('edgt-' . $net . '-share');

		$classes[] = eldritch_edge_options()->getOptionValue($net . '_icon') ? 'edgt-custom-icon' : '';

		return $classes;
	}


	private function getSocialNetworkLabel($net) {

		switch ($net) {
			case 'facebook':
				$label = esc_html__('Facebook', 'edge-core');
				break;
			case 'twitter':
				$label = esc_html__('Twitter', 'edge-core');
				break;
			case 'google_plus':
				$label = esc_html__('Google Plus', 'edge-core');
				break;
			case 'linkedin':
				$label = esc_html__('LinkedIn', 'edge-core');
				break;
			case 'tumblr':
				$label = esc_html__('Tumblr', 'edge-core');
				break;
			case 'pinterest':
				$label = esc_html__('Pinterest', 'edge-core');
				break;
			case 'vk':
				$label = esc_html__('VKontakte', 'edge-core');
				break;
			default:
				$label = '';
		}

		return $label;

	}

}