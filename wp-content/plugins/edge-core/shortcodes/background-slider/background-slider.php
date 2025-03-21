<?php

namespace Eldritch\Modules\Shortcodes\BackgroundSlider;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class BackgroundSlider
 */
class BackgroundSlider implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * Sets base attribute and registers shortcode with Visual Composer
	 */
	public function __construct() {
		$this->base = 'edgt_background_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base attribute
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/*
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 */
	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Background Slider', 'edge-core'),
			'base'                      => $this->getBase(),
			'as_child'                  => array('only' => 'edgt_elements_holder_item'),
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-background-slider extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'attach_images',
					'heading'     => esc_html__('Images', 'edge-core'),
					'param_name'  => 'images',
					'description' => esc_html__('Select images from media library', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Image Size', 'edge-core'),
					'param_name'  => 'image_size',
					'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__('Navigation skin', 'edge-core'),
					'param_name'  => 'navigation_skin',
					'value'       => array(
						esc_html__('Default', 'edge-core') => '',
						esc_html__('Light', 'edge-core')   => 'light',
						esc_html__('Dark', 'edge-core')    => 'dark',
					),
					'save_always' => true
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
			'images'          => '',
			'image_size'      => 'thumbnail',
			'navigation_skin' => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['images'] = $this->getSliderImages($params);
		$params['classes'] = $this->getClasses($params);

		//Get HTML from template
		$html = edge_core_get_core_shortcode_template_part('templates/background-slider-template', 'background-slider', '', $params);

		return $html;
	}

	/**
	 * Return images for gallery
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getSliderImages($params) {
		$image_ids = array();
		$images = array();
		$i = 0;

		if ($params['images'] !== '') {
			$image_ids = explode(',', $params['images']);
		}

		foreach ($image_ids as $id) {

			$image['image_id'] = $id;
			$image_original = wp_get_attachment_image_src($id, 'full');
			$image['url'] = $image_original[0];
			$image['title'] = get_the_title($id);

			$images[$i] = $image;
			$i++;
		}

		return $images;

	}

	/**
	 * Return classes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getClasses($params) {
		$classes = array('edgt-bckg-slider');

		$classes[] = $params['navigation_skin'];

		return $classes;
	}
}