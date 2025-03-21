<?php
namespace Eldritch\Modules\Shortcodes\ImageGallery;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ImageGallery implements ShortcodeInterface {

	private $base;

	/**
	 * Image Gallery constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_image_gallery';

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
			'name'                      => esc_html__('Image Gallery', 'edge-core'),
			'base'                      => $this->base,
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'icon'                      => 'icon-wpb-image-gallery extended-custom-icon',
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
					'heading'     => esc_html__('Gallery Type', 'edge-core'),
					'admin_label' => true,
					'param_name'  => 'type',
					'value'       => array(
						esc_html__('Slider', 'edge-core')     => 'slider',
						esc_html__('Image Grid', 'edge-core') => 'image_grid'
					),
					'description' => esc_html__('Select gallery type', 'edge-core'),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Show Title & Description', 'edge-core'),
					'param_name'  => 'show_title_desc',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Slide duration', 'edge-core'),
					'admin_label' => true,
					'param_name'  => 'autoplay',
					'value'       => array(
						'3'                                  => '3',
						'5'                                  => '5',
						'10'                                 => '10',
						esc_html__('Disable', 'edge-core') => 'disable'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					),
					'description' => esc_html__('Auto rotate slides each X seconds', 'edge-core'),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Column Number', 'edge-core'),
					'param_name'  => 'column_number',
					'value'       => array(2, 3, 4, 5),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'image_grid'
						)
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Spacing', 'edge-core'),
					'param_name'  => 'spacing',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no'
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'image_grid'
						)
					),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Open PrettyPhoto on click', 'edge-core'),
					'param_name'  => 'pretty_photo',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Grayscale Images', 'edge-core'),
					'param_name'  => 'grayscale',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'image_grid'
						)
					)
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Enable Circle Overlay Hover', 'edge-core'),
					'param_name'  => 'circle_overlay_hover',
					'value'       => array(
						esc_html__('No', 'edge-core')  => 'no',
						esc_html__('Yes', 'edge-core') => 'yes'
					),
					'admin_label' => true,
					'save_always' => true,
					'description' => esc_html__('Default value is No', 'edge-core'),
					'dependency'  => array(
						'element' => 'pretty_photo',
						'value'   => array('yes')
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Show Navigation Arrows', 'edge-core'),
					'param_name'  => 'arrows',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no'
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Show Navigation Dots', 'edge-core'),
					'param_name'  => 'dots',
					'value'       => array(
						esc_html__('Yes', 'edge-core') => 'yes',
						esc_html__('No', 'edge-core')  => 'no'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					)
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
			'images'               => '',
			'image_size'           => 'thumbnail',
			'type'                 => 'slider',
			'show_title_desc'      => 'no',
			'autoplay'             => '5000',
			'pretty_photo'         => '',
			'column_number'        => '',
			'spacing'              => 'yes',
			'grayscale'            => '',
			'circle_overlay_hover' => '',
			'arrows'               => 'yes',
			'dots'                 => 'yes'
		);

		$params = shortcode_atts($args, $atts);
		$params['slider_data'] = $this->getSliderData($params);
		$params['image_size'] = $this->getImageSize($params['image_size']);
		$params['images'] = $this->getGalleryImages($params);
		$params['pretty_photo'] = ($params['pretty_photo'] == 'yes') ? true : false;
		$params['columns'] = 'edgt-gallery-columns-' . $params['column_number'];
		$params['gallery_classes'] = ($params['grayscale'] == 'yes') ? 'edgt-grayscale' : '';

		if ($params['type'] == 'image_grid') {
			$template = 'gallery-grid';
		} elseif ($params['type'] == 'slider') {
			$template = 'gallery-slider';
		}

		$image_hover = '';
		if ($params['circle_overlay_hover'] === 'yes') {
			$image_hover = 'edgt-image-galley-circle-overlay';
		}

		$params['hover_overlay'] = $image_hover;

		$image_space = '';
		if ($params['spacing'] == 'yes') {
			$image_space .= ' edgt-space';
		} elseif ($params['spacing'] == 'no') {
			$image_space .= ' edgt-no-space';
		}


		$params['space'] = $image_space;

		$html = edge_core_get_core_shortcode_template_part('templates/' . $template, 'imagegallery', '', $params);

		return $html;

	}

	/**
	 * Return images for gallery
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getGalleryImages($params) {
		$image_ids = array();
		$images = array();
		$i = 0;

		if ($params['images'] !== '') {
			$image_ids = explode(',', $params['images']);
		}

		foreach ($image_ids as $id) {

			$image['image_id'] = $id;
			$image_original = wp_get_attachment_image_src($id, 'full');
			$image['url'] = is_array( $image_original ) ? $image_original[0] : '';
			$image['title'] = get_the_title($id);

			$images[$i] = $image;
			$i++;
		}

		return $images;

	}

	/**
	 * Return image size or custom image size array
	 *
	 * @param $image_size
	 *
	 * @return array
	 */
	private function getImageSize($image_size) {

		$image_size = trim($image_size);
		//Find digits
		preg_match_all('/\d+/', $image_size, $matches);
		if (in_array($image_size, array('thumbnail', 'thumb', 'medium', 'large', 'full'))) {
			return $image_size;
		} elseif (!empty($matches[0])) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		} else {
			return 'thumbnail';
		}
	}

	/**
	 * Return all configuration data for slider
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getSliderData($params) {

		$slider_data = array();

		$slider_data['data-autoplay'] = ($params['autoplay'] !== '') ? $params['autoplay'] : '';
		$slider_data['data-arrows'] = ($params['arrows'] !== '') ? $params['arrows'] : '';
		$slider_data['data-dots'] = ($params['dots'] !== '') ? $params['dots'] : '';

		return $slider_data;

	}

}