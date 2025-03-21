<?php
namespace EdgeCore\CPT\Portfolio\Shortcodes;

use EdgeCore\Lib;
use EdgeCore\CPT\Portfolio\Lib\PortfolioQuery;

/**
 * Class PortfolioSlider
 * @package EdgeCore\CPT\Portfolio\Shortcodes
 */
class PortfolioSlider implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_portfolio_slider';

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
	 * Maps shortcode to Visual Composer
	 *
	 * @see vc_map()
	 */
	public function vcMap() {
		if (function_exists('vc_map')) {
			vc_map(array(
					'name'                      => esc_html__('Portfolio Slider', 'edge-core'),
					'base'                      => $this->base,
					'category' => esc_html__( 'by EDGE', 'edge-core' ),
					'icon'                      => 'icon-wpb-portfolio-slider extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array_merge(
						array(
							array(
								'type'        => 'dropdown',
								'admin_label' => true,
								'heading'     => esc_html__('Image size', 'edge-core'),
								'param_name'  => 'image_size',
								'value'       => array(
									esc_html__('Default', 'edge-core')       => '',
									esc_html__('Original Size', 'edge-core') => 'full',
									esc_html__('Square', 'edge-core')        => 'square',
									esc_html__('Landscape', 'edge-core')     => 'landscape',
									esc_html__('Portrait', 'edge-core')      => 'portrait',
									esc_html__('Custom', 'edge-core')        => 'custom'
								),
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Hover type', 'edge-core'),
								'param_name'  => 'slider_hover_type',
								'value'       => array(
									esc_html__('Type 1', 'edge-core') => 'type-one',
									esc_html__('Type 2', 'edge-core') => 'type-two',
									esc_html__('Type 3', 'edge-core') => 'type-three'
								),
								'admin_label' => true,
								'save_always' => true,
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => esc_html__('Shader Background Color', 'edge-core'),
								'param_name' => 'shader_background_color',
								'group'      => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'textfield',
								'admin_label' => true,
								'heading'     => esc_html__('Image Dimensions', 'edge-core'),
								'param_name'  => 'custom_image_dimensions',
								'value'       => '',
								'description' => esc_html__('Enter custom image dimensions. Enter image size in pixels: 200x100 (Width x Height)', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core'),
								'dependency'  => array('element' => 'image_size', 'value' => 'custom')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Number of Columns', 'edge-core'),
								'param_name'  => 'columns',
								'admin_label' => true,
								'value'       => array(
									esc_html__('One', 'edge-core')   => '1',
									esc_html__('Two', 'edge-core')   => '2',
									esc_html__('Three', 'edge-core') => '3',
									esc_html__('Four', 'edge-core')  => '4'
								),
								'description' => esc_html__('Number of portfolios that are showing at the same time in full width (on smaller screens is responsive so there will be less items shown)', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => esc_html__('Title Tag', 'edge-core'),
								'param_name'  => 'title_tag',
								'value'       => array(
									''   => '',
									'h2' => 'h2',
									'h3' => 'h3',
									'h4' => 'h4',
									'h5' => 'h5',
									'h6' => 'h6',
								),
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => esc_html__('Show Categories', 'edge-core'),
								'param_name'  => 'show_categories',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => esc_html__('Enable Navigation?', 'edge-core'),
								'param_name'  => 'dots',
								'value'       => array(
									esc_html__('Yes', 'edge-core') => 'yes',
									esc_html__('No', 'edge-core')  => 'no'
								),
								'save_always' => true,
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							)

						),
						PortfolioQuery::getInstance()->queryVCParams()
					)
				)
			);
		}
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
			'image_size'              => 'full',
			'title_tag'               => 'h4',
			'show_categories'         => '',
			'columns'                 => '1',
			'dots'                    => 'yes',
			'slider_hover_type'		  => '',
			'shader_background_color' => '',
			'custom_image_dimensions' => ''
		);

		$args = array_merge($args, PortfolioQuery::getInstance()->getShortcodeAtts());
		$params = shortcode_atts($args, $atts);

		$query = PortfolioQuery::getInstance()->buildQueryObject($params);

		$params['query'] = $query;
		$params['holder_data'] = $this->getHolderData($params);
		$params['thumb_size'] = $this->getThumbSize($params);
		$params['caller'] = $this;
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['shader_styles'] = $this->getShaderStyles($params);

		$params['use_custom_image_size'] = false;
		if ($params['thumb_size'] === 'custom' && !empty($params['custom_image_dimensions'])) {
			$params['use_custom_image_size'] = true;
			$params['custom_image_sizes'] = $this->getCustomImageSize($params['custom_image_dimensions']);
		}

		return edgt_core_get_shortcode_module_template_part('portfolio-slider/templates/portfolio-slider-holder', 'portfolio', '', $params);
	}

	private function getHolderData($params) {
		$data = array();

		$data['data-columns'] = $params['columns'];
		$data['data-dots'] = $params['dots'];

		return $data;
	}

	public function getThumbSize($params) {
		switch ($params['image_size']) {
			case 'landscape':
				$thumbSize = 'eldritch_edge_landscape';
				break;
			case 'portrait':
				$thumbSize = 'eldritch_edge_portrait';
				break;
			case 'square':
				$thumbSize = 'eldritch_edge_square';
				break;
			case 'full':
				$thumbSize = 'full';
				break;
			case 'custom':
				$thumbSize = 'custom';
				break;
			default:
				$thumbSize = 'full';
				break;
		}

		return $thumbSize;
	}

	private function getHolderClasses($params) {
		$classes = array(
			'edgt-portfolio-slider-holder',
			'edgt-carousel-pagination',
			'edgt-portfolio-list-holder-outer',
			'edgt-ptf-gallery',
			'edgt-portfolio-gallery-hover'
		);

		if ($params['slider_hover_type'] != '') {
			$classes[] = 'edgt-hover-' . $params['slider_hover_type'];
		}

		return $classes;
	}

	private function getCustomImageSize($customImageSize) {
		$imageSize = trim($customImageSize);
		//Find digits
		preg_match_all('/\d+/', $imageSize, $matches);
		if (!empty($matches[0])) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		}

		return false;
	}

	/**
	 * Generates portfolio item shader styles
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getShaderStyles($params) {
		$style = array();

		if ($params['shader_background_color'] !== '') {
			$style[] = 'background-color:' . $params['shader_background_color'];
		}

		return $style;
	}
}