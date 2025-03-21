<?php
namespace EdgeCore\CPT\Portfolio\Shortcodes;

use EdgeCore\Lib;
use EdgeCore\CPT\Portfolio\Lib as PortfolioLib;

/**
 * Class PortfolioList
 * @package EdgeCore\CPT\Portfolio\Shortcodes
 */
class PortfolioList implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * PortfolioList constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_portfolio_list';

		add_action('vc_before_init', array($this, 'vcMap'));

		add_action('wp_ajax_nopriv_edgt_core_portfolio_ajax_load_more', array($this, 'loadMorePortfolios'));
		add_action('wp_ajax_edgt_core_portfolio_ajax_load_more', array($this, 'loadMorePortfolios'));
	}


	/**
	 * Loads portfolios via AJAX
	 */
	public function loadMorePortfolios() {
		$shortcodeParams = $this->getShortcodeParamsFromPost();

		$html = '';
		$portfolioQuery = PortfolioLib\PortfolioQuery::getInstance();
		$queryResults = $portfolioQuery->buildQueryObject($shortcodeParams);

		if ($shortcodeParams['type'] !== 'masonry') {
			$shortcodeParams['thumb_size'] = $this->getImageSize($shortcodeParams);
			$shortcodeParams['use_custom_image_size'] = false;
			if ($shortcodeParams['thumb_size'] === 'custom' && !empty($shortcodeParams['custom_image_dimensions'])) {
				$shortcodeParams['use_custom_image_size'] = true;
				$shortcodeParams['custom_image_sizes'] = $this->getCustomImageSize($shortcodeParams['custom_image_dimensions']);
			}
		}

		if ($queryResults->have_posts()) {
			while ($queryResults->have_posts()) {
				$queryResults->the_post();

				$shortcodeParams['current_id'] = get_the_ID();

				if ($shortcodeParams['type'] === 'masonry') {
					$shortcodeParams['thumb_size'] = $this->getImageSize($shortcodeParams);
				}

				$shortcodeParams['article_masonry_size'] = $this->getMasonrySize($shortcodeParams);
				$shortcodeParams['item_classes'] = $this->getPortfolioItemClasses($shortcodeParams);
				$shortcodeParams['icon_html'] = $this->getPortfolioIconsHtml($shortcodeParams);
				$shortcodeParams['category_html'] = $this->getItemCategoriesHtml($shortcodeParams);
				$shortcodeParams['categories'] = $this->getItemCategories($shortcodeParams);
				$shortcodeParams['link_atts'] = $this->getItemLink($shortcodeParams);
				$shortcodeParams['shader_styles'] = $this->getShaderStyles($shortcodeParams);
				$shortcodeParams['title_tag'] = $this->getItemTitleTag($shortcodeParams);

				$html .= edgt_core_get_shortcode_module_template_part('portfolio-list/templates/' . $shortcodeParams['type'], 'portfolio', '', $shortcodeParams);
			}

			wp_reset_postdata();
		} else {
			$html .= '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'edge-core') . '</p>';
		}

		$returnObj = array(
			'html' => $html,
		);

		echo json_encode($returnObj);
		exit;
	}

	/**
	 * Prepares shortcode params array from $_POST and returns it
	 *
	 * @return array
	 */
	private function getShortcodeParamsFromPost() {
		$shortcodeParams = array();

		if (!empty($_POST['type'])) {
			$shortcodeParams['type'] = $_POST['type'];
		}

		if (!empty($_POST['columns'])) {
			$shortcodeParams['columns'] = $_POST['columns'];
		}

		if (!empty($_POST['gridSize'])) {
			$shortcodeParams['grid_size'] = $_POST['gridSize'];
		}

		if (!empty($_POST['orderBy'])) {
			$shortcodeParams['order_by'] = $_POST['orderBy'];
		}

		if (!empty($_POST['order'])) {
			$shortcodeParams['order'] = $_POST['order'];
		}

		if (!empty($_POST['number'])) {
			$shortcodeParams['number'] = $_POST['number'];
		}
		if (!empty($_POST['imageSize'])) {
			$shortcodeParams['image_size'] = $_POST['imageSize'];
		}

		if (!empty($_POST['shaderBackgroundStyle'])) {
			$shortcodeParams['shader_background_style'] = $_POST['shaderBackgroundStyle'];
		}

		if (!empty($_POST['shaderBackgroundColor'])) {
			$shortcodeParams['shader_background_color'] = $_POST['shaderBackgroundColor'];
		}

		if (!empty($_POST['titleTag'])) {
			$shortcodeParams['title_tag'] = $_POST['titleTag'];
		}

		if (!empty($_POST['showCategories'])) {
			$shortcodeParams['show_categories'] = $_POST['showCategories'];
		}

		if (!empty($_POST['customImageDimensions'])) {
			$shortcodeParams['custom_image_dimensions'] = $_POST['customImageDimensions'];
		}

		if (!empty($_POST['filter'])) {
			$shortcodeParams['filter'] = $_POST['filter'];
		}

		if (!empty($_POST['filterOrderBy'])) {
			$shortcodeParams['filter_order_by'] = $_POST['filterOrderBy'];
		}

		if (!empty($_POST['category'])) {
			$shortcodeParams['category'] = $_POST['category'];
		}

		if (!empty($_POST['textLength'])) {
			$shortcodeParams['text_length'] = $_POST['textLength'];
		}

        if (!empty($_POST['showExcerpt']) && $_POST['showExcerpt'] == 'no') {
            $shortcodeParams['text_length'] = '0';
        }

		if (!empty($_POST['selectedProjects'])) {
			$shortcodeParams['selected_projects'] = $_POST['selectedProjects'];
		}

		if (!empty($_POST['showLoadMore'])) {
			$shortcodeParams['show_load_more'] = $_POST['showLoadMore'];
		}

		if (!empty($_POST['nextPage'])) {
			$shortcodeParams['next_page'] = $_POST['nextPage'];
		}

		if (!empty($_POST['activeFilterCat'])) {
			$shortcodeParams['active_filter_cat'] = $_POST['activeFilterCat'];
		}

		return $shortcodeParams;
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
	 * @see vc_map
	 */
	public function vcMap() {
		if (function_exists('vc_map')) {
			vc_map(array(
					'name'                      => esc_html__('Portfolio List', 'edge-core'),
					'base'                      => $this->getBase(),
					'category' => esc_html__( 'by EDGE', 'edge-core' ),
					'icon'                      => 'icon-wpb-portfolio extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array_merge(
						array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Portfolio List Template', 'edge-core'),
								'param_name'  => 'type',
								'value'       => array(
									esc_html__('Standard', 'edge-core')  => 'standard',
									esc_html__('Simple', 'edge-core')    => 'simple',
									esc_html__('Gallery', 'edge-core')   => 'gallery',
									esc_html__('Masonry', 'edge-core')   => 'masonry',
									esc_html__('Pinterest', 'edge-core') => 'pinterest'
								),
								'admin_label' => true,
								'description' => '',
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Boxed', 'edge-core'),
								'param_name'  => 'standard_boxed',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'dependency'  => array(
									'element' => 'type',
									'value'   => 'standard'
								),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Hover type', 'edge-core'),
								'param_name'  => 'hover_type_simple',
								'value'       => array(
									esc_html__('Translate', 'edge-core') => 'translate',
									esc_html__('Tilt', 'edge-core')      => 'tilt',
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => 'simple'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Appear effect', 'edge-core'),
								'param_name'  => 'appear_effect',
								'value'       => array(
									esc_html__('None', 'edge-core')       => 'none',
									esc_html__('One by one', 'edge-core') => 'one_by_one',
									esc_html__('Random', 'edge-core')     => 'random',
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => array('simple', 'gallery', 'masonry', 'pinterest')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Style', 'edge-core'),
								'param_name'  => 'style_default',
								'value'       => array(
									esc_html__('Dark', 'edge-core')  => 'dark',
									esc_html__('Light', 'edge-core') => 'light'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'dependency'  => array(
									'element' => 'standard_boxed',
									'value'   => 'no'
								),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Style', 'edge-core'),
								'param_name'  => 'style_boxed',
								'value'       => array(
									esc_html__('Light', 'edge-core') => 'light',
									esc_html__('Dark', 'edge-core')  => 'dark'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'dependency'  => array(
									'element' => 'type',
									'value'   => 'yes'
								),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Shader Styles', 'edge-core'),
								'param_name'  => 'shader_background_style',
								'value'       => array(
									esc_html__('Common Background Color', 'edge-core')   => 'common_background_color',
									esc_html__('Variable Background Color', 'edge-core') => 'variable_background_color'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => esc_html__('Variable background color is set on individual portfolio item single pages as Portfolio Background Color.', 'edge-core'),
								'dependency'  => array('element' => 'type', 'value' => array('gallery', 'masonry', 'pinterest')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => esc_html__('Shader Background Color', 'edge-core'),
								'param_name' => 'shader_background_color',
								'dependency' => array('element' => 'shader_background_style', 'value' => 'common_background_color'),
								'group'      => esc_html__('Layout Options', 'edge-core')
							),
                            array(
                                'type'       => 'colorpicker',
                                'heading'    => esc_html__('Hover Background Color', 'edge-core'),
                                'param_name' => 'standard_background_color',
                                'dependency' => array('element' => 'type', 'value' => 'standard'),
                                'group'      => esc_html__('Layout Options', 'edge-core')
                            ),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Image Proportions', 'edge-core'),
								'param_name'  => 'image_size',
								'value'       => array(
									esc_html__('Original', 'edge-core')  => 'full',
									esc_html__('Square', 'edge-core')    => 'square',
									esc_html__('Landscape', 'edge-core') => 'landscape',
									esc_html__('Portrait', 'edge-core')  => 'portrait',
									esc_html__('Custom', 'edge-core')    => 'custom'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'dependency'  => array('element' => 'type', 'value' => array('standard', 'gallery', 'simple')),
								'group'       => esc_html__('Layout Options', 'edge-core')
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
								'heading'     => esc_html__('Text Align', 'edge-core'),
								'param_name'  => 'text_align',
								'admin_label' => true,
								'value'       => array(
									esc_html__('Left', 'edge-core')   => 'left',
									esc_html__('Center', 'edge-core') => 'center',
									esc_html__('Right', 'edge-core')  => 'right'
								),
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => array('standard')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'textfield',
								'holder'      => 'div',
								'class'       => '',
								'heading'     => esc_html__('Text length', 'edge-core'),
								'param_name'  => 'text_length',
								'description' => esc_html__('Number of characters', 'edge-core'),
								'dependency'  => array(
									'element' => 'type',
									'value'   => array('standard')
								),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Hover type', 'edge-core'),
								'param_name'  => 'hover_type',
								'value'       => array(
									esc_html__('Type 1', 'edge-core') => 'type-one',
									esc_html__('Type 2', 'edge-core') => 'type-two',
									esc_html__('Type 3', 'edge-core') => 'type-three'
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => 'gallery'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Number of Columns', 'edge-core'),
								'param_name'  => 'columns',
								'value'       => array(
									''                              => '',
									esc_html__('Three', 'edge-core') => 'three',
									esc_html__('Four', 'edge-core')  => 'four',
									esc_html__('Five', 'edge-core')  => 'five',
									esc_html__('Six', 'edge-core')   => 'six'
								),
								'admin_label' => true,
								'description' => esc_html__('Default value is Three', 'edge-core'),
								'dependency'  => array('element' => 'type', 'value' => array('standard', 'gallery', 'simple')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Grid Size', 'edge-core'),
								'param_name'  => 'grid_size',
								'value'       => array(
									esc_html__('Default', 'edge-core')        => '',
									esc_html__('3 Columns Grid', 'edge-core') => 'three',
									esc_html__('4 Columns Grid', 'edge-core') => 'four',
									esc_html__('5 Columns Grid', 'edge-core') => 'five',
									esc_html__('6 Columns Grid', 'edge-core') => 'six'
								),
								'admin_label' => true,
								'description' => esc_html__('This option is only for Full Width Page Template', 'edge-core'),
								'dependency'  => array('element' => 'type', 'value' => array('pinterest', 'masonry')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
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
								'group'       => esc_html__('Layout Options', 'edge-core'),
								'description' => ''
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Show Categories', 'edge-core'),
								'param_name'  => 'show_categories',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => esc_html__('Default value is No', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Show Load More', 'edge-core'),
								'param_name'  => 'show_load_more',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => esc_html__('Default value is No', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Enable Category Filter', 'edge-core'),
								'param_name'  => 'filter',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => esc_html__('Default value is No', 'edge-core'),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
//							array(
//								'type'        => 'dropdown',
//								'heading'     => esc_html__('Filter levels', 'edge-core'),
//								'param_name'  => 'filter_levels',
//								'value'       => array(
//									esc_html__('1', 'edge-core') => '1',
//									esc_html__('2', 'edge-core') => '2',
//									esc_html__('3', 'edge-core') => '3'
//								),
//								'admin_label' => true,
//								'save_always' => true,
//								'dependency'  => array(
//									'element' => 'filter',
//									'value'   => array('yes')
//								),
//								'group'       => esc_html__('Layout Options', 'edge-core')
//							),
//							array(
//								'type'        => 'textfield',
//								'heading'     => esc_html__('Filter height', 'edge-core'),
//								'param_name'  => 'filter_height',
//								'admin_label' => true,
//								'save_always' => true,
//								'dependency'  => array(
//									'element' => 'filter',
//									'value'   => array('yes')
//								),
//								'group'       => esc_html__('Layout Options', 'edge-core')
//							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Filter Order By', 'edge-core'),
								'param_name'  => 'filter_order_by',
								'value'       => array(
									esc_html__('Name', 'edge-core')  => 'name',
									esc_html__('Count', 'edge-core') => 'count',
									esc_html__('Id', 'edge-core')    => 'id',
									esc_html__('Slug', 'edge-core')  => 'slug'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => esc_html__('Default value is Name', 'edge-core'),
								'dependency'  => array('element' => 'filter', 'value' => array('yes')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Filter Position', 'edge-core'),
								'param_name'  => 'filter_position',
								'value'       => array(
									esc_html__('Left', 'edge-core')   => 'left',
									esc_html__('Center', 'edge-core') => 'center',
									esc_html__('Right', 'edge-core')  => 'right',
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'filter', 'value' => array('yes')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Filter Style', 'edge-core'),
								'param_name'  => 'filter_style',
								'value'       => array(
									esc_html__('Dark', 'edge-core')  => 'dark',
									esc_html__('Light', 'edge-core') => 'light',
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'filter', 'value' => array('yes')),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__('Space Between Portfolio Items', 'edge-core'),
								'param_name'  => 'space_between_portfolio_items',
								'value'       => array(
									esc_html__('No', 'edge-core')  => 'no',
									esc_html__('Yes', 'edge-core') => 'yes'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => esc_html__('Default value is No', 'edge-core'),
								'dependency'  => array(
									'element' => 'type',
									'value'   => array('gallery', 'masonry', 'pinterest')
								),
								'group'       => esc_html__('Layout Options', 'edge-core')
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__('Subtitle', 'edge-core'),
								'param_name'  => 'msn_subtitle',
								'admin_label' => true,
								'dependency'  => array('element' => 'type', 'value' => array('masonry')),
								'group'       => esc_html__('Content Options', 'edge-core')
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__('Title', 'edge-core'),
								'param_name'  => 'msn_title',
								'admin_label' => true,
								'dependency'  => array('element' => 'type', 'value' => array('masonry')),
								'group'       => esc_html__('Content Options', 'edge-core')
							),
							array(
								'type'        => 'textarea',
								'heading'     => esc_html__('Text', 'edge-core'),
								'param_name'  => 'msn_text',
								'admin_label' => true,
								'dependency'  => array('element' => 'type', 'value' => array('masonry')),
								'group'       => esc_html__('Content Options', 'edge-core')
							),
							array(
								'type'        => 'attach_image',
								'heading'     => esc_html__('Image', 'edge-core'),
								'param_name'  => 'msn_image',
								'admin_label' => true,
								'dependency'  => array('element' => 'type', 'value' => array('masonry')),
								'group'       => esc_html__('Content Options', 'edge-core')
							)
						),
						PortfolioLib\PortfolioQuery::getInstance()->queryVCParams()
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
			'type'                          => 'standard',
			'standard_boxed'                => 'default',
			'style_default'                 => 'dark',
			'style_boxed'                   => 'light',
			'shader_background_style'       => 'global_background_color',
			'shader_background_color'       => '',
            'standard_background_color'     => '',
			'hover_type'                    => 'type-one',
			'hover_type_simple'             => 'translate',
			'appear_effect'                 => 'none',
			'columns'                       => 'three',
			'grid_size'                     => 'four',
			'title_tag'                     => 'h4',
			'show_categories'               => 'no',
			'image_size'                    => 'full',
			'filter'                        => 'no',
//			'filter_height'                 => '',
			'filter_order_by'               => 'name',
			'filter_position'               => 'left',
			'filter_style'                  => 'dark',
			'show_load_more'                => 'yes',
			'portfolio_slider'              => '',
			'portfolios_shown'              => '',
			'space_between_portfolio_items' => 'yes',
			'custom_image_dimensions'       => '',
			'text_align'                    => 'left',
			'text_length'                   => '',
			'msn_subtitle'                  => '',
			'msn_title'                     => '',
			'msn_text'                      => '',
			'msn_image'                     => ''
		);

		$portfolioQuery = PortfolioLib\PortfolioQuery::getInstance();

		$args = array_merge($args, $portfolioQuery->getShortcodeAtts());
		$params = shortcode_atts($args, $atts);
		$params['filter_levels'] = 1;

		extract($params);

		$queryResults = $portfolioQuery->buildQueryObject($params);
		$params['query_results'] = $queryResults;

		$holder_classes = $this->getPortfolioHolderClasses($params);
		$dataAtts = $this->getDataAtts($params);
		$dataAtts .= ' data-max-num-pages = "' . $queryResults->max_num_pages .'"';
		$params['masonry_filter'] = '';

		$html = '';

		if ($filter == 'yes' && ($type == 'masonry' || $type == 'pinterest')) {
			$top_category = get_term_by('slug', $params['category'], 'portfolio-category');
			$params['top_category_id'] = $top_category ? $top_category->term_id : 0;
//			$params['filter_styles'] = $this->getFilterStyles($params);
			$params['filter_categories'] = edgt_core_filter_cateogories_html($this->getFilterCategories($params), $params['top_category_id'], $params);
			$params['masonry_filter'] = 'edgt-masonry-filter ' . $params['filter_style'] . ' ' . $params['filter_position'];
			$html .= edgt_core_get_shortcode_module_template_part('portfolio-list/templates/portfolio-filter', 'portfolio', '', $params);
		}

		$html .= '<div ' . edgt_core_get_class_attribute($holder_classes) . ' ' . $dataAtts . '>';

		if ($filter == 'yes' && ($type == 'standard' || $type == 'gallery' || $type == 'simple')) {
			$top_category = get_term_by('slug', $params['category'], 'portfolio-category');
//			$params['filter_styles'] = $this->getFilterStyles($params);
			$params['top_category_id'] = $top_category ? $top_category->term_id : 0;
			$params['filter_categories'] = edgt_core_filter_cateogories_html($this->getFilterCategories($params), $params['top_category_id'], $params);
			$html .= edgt_core_get_shortcode_module_template_part('portfolio-list/templates/portfolio-filter', 'portfolio', '', $params);
		}

		$html .= '<div class = "edgt-portfolio-list-holder clearfix" >';
		if ($type == 'masonry' || $type == 'pinterest') {
			$html .= '<div class="edgt-portfolio-list-masonry-grid-sizer"></div>';
			$html .= '<div class="edgt-portfolio-list-masonry-grid-gutter"></div>';
		}

		if ($type == 'masonry') {
			if ($msn_subtitle !== '' || $msn_title !== '' || $msn_text !== '' || $msn_image !== '') {
				$html .= '<article class="edgt-portfolio-item edgt-large-width-height-masonry-item edgt-portfolio-masonry-content">';
				$html .= '<div class="edgt-masonry-content-inner-holder">';
				$html .= '<div class="edgt-masonry-content-inner">';
				$html .= '<h5 class="edgt-portfolio-masonry-subtitle">';
				$html .= esc_html($msn_subtitle);
				$html .= '</h5>';
				$html .= '<h1 class="edgt-portfolio-masonry-title">';
				$html .= esc_html($msn_title);
				$html .= '</h1>';
				$html .= '<p class="edgt-portfolio-masonry-text">';
				$html .= esc_html($msn_text);
				$html .= '</p>';
				$html .= wp_get_attachment_image($msn_image, 'full');
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</article>';
			}
		}

		if ($type !== 'masonry') {
			$params['thumb_size'] = $this->getImageSize($params);
			$params['use_custom_image_size'] = false;
			if ($params['thumb_size'] === 'custom' && !empty($params['custom_image_dimensions'])) {
				$params['use_custom_image_size'] = true;
				$params['custom_image_sizes'] = $this->getCustomImageSize($params['custom_image_dimensions']);
			}
		}

		if ($queryResults->have_posts()) {
			while ($queryResults->have_posts()) {
				$queryResults->the_post();

				$params['current_id'] = get_the_ID();

				if ($type === 'masonry') {
					$params['thumb_size'] = $this->getImageSize($params);
				}

				$params['icon_html'] = $this->getPortfolioIconsHtml($params);
				$params['category_html'] = $this->getItemCategoriesHtml($params);
				$params['categories'] = $this->getItemCategories($params);
				$params['article_masonry_size'] = $this->getMasonrySize($params);
				$params['link_atts'] = $this->getItemLink($params);
				$params['item_classes'] = $this->getPortfolioItemClasses($params);
				$params['shader_styles'] = $this->getShaderStyles($params);
				$params['title_tag'] = $this->getItemTitleTag($params);

				$html .= edgt_core_get_shortcode_module_template_part('portfolio-list/templates/' . $type, 'portfolio', '', $params);
			}

			if ($type == 'standard' || ($params['space_between_portfolio_items'] == 'yes' && $type == 'gallery')) {
				switch ($columns) {
					case 'two':
						$html .= '<div class="edgt-ptf-gap"></div>';
						break;
					case 'three':
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						break;
					case 'four':
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						break;
					case 'five':
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						break;
					case 'six':
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						$html .= '<div class="edgt-ptf-gap"></div>';
						break;
					default:
						break;
				}
			}
		} else {
			$html .= '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'edge-core') . '</p>';
		}

		$html .= '</div>'; //close edgt-portfolio-list-holder

		if ($show_load_more == 'yes') {
			$html .= edgt_core_get_shortcode_module_template_part('portfolio-list/templates/load-more-template', 'portfolio', '', $params);
		}

		wp_reset_postdata();

		$html .= '</div>'; // close edgt-portfolio-list-holder-outer
		return $html;
	}

	/**
	 * Generates portfolio icons html
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getPortfolioIconsHtml($params) {

		$html = '';
		$id = $params['current_id'];
		$slug_list_ = 'pretty_photo_gallery';

		$featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full'); //original size
		$large_image = is_array( $featured_image_array ) ? $featured_image_array[0] : '';

		$html .= '<div class="edgt-item-icons-holder">';

		$html .= '<a class="edgt-portfolio-lightbox" title="' . get_the_title($id) . '" href="' . $large_image . '" data-rel="prettyPhoto[' . $slug_list_ . ']"></a>';


		if (function_exists('eldritch_edge_like_portfolio_list')) {
			$html .= eldritch_edge_like_portfolio_list($id);
		}

		$html .= '<a class="edgt-preview" title="'.esc_attr__('Go to Project', 'edge-core').'" href="' . $this->getItemLink($params)['href'] . '" data-type="portfolio_list"></a>';

		$html .= '</div>';

		return $html;

	}

	/**
	 * Generates portfolio holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getPortfolioHolderClasses($params) {
		$classes = array('edgt-portfolio-list-holder-outer');
		$type = $params['type'];
		$columns = $params['columns'];
		$grid_size = $params['grid_size'];
		$appear_effect = $params['appear_effect'];

		switch ($type):
			case 'standard':
				$classes[] = 'edgt-ptf-standard';
				$classes[] = 'edgt-ptf-with-spaces';

				if ($params['standard_boxed'] == 'yes') {
					$classes[] = 'edgt-ptf-boxed';
					$classes[] = 'edgt-ptf-boxed-' . $params['style_boxed'];
				} else {
					$classes[] = 'edgt-ptf-' . $params['style_default'];
				}

				break;
			case 'gallery':
				$classes[] = 'edgt-ptf-gallery';
				$classes[] = 'edgt-hover-' . $params['hover_type'];

				if ($params['space_between_portfolio_items'] == 'yes') {
					$classes[] = 'edgt-ptf-with-spaces';
				}

				$classes[] = 'edgt-portfolio-gallery-hover';

				break;
			case 'masonry':
				$classes[] = 'edgt-ptf-masonry';
				$classes[] = 'edgt-portfolio-gallery-hover';

                if($params['space_between_portfolio_items'] == 'yes') {
                    $classes[] = 'edgt-ptf-with-spaces';
                }

				break;
			case 'pinterest':
				$classes[] = 'edgt-ptf-pinterest';

				$classes[] = 'edgt-portfolio-gallery-hover';

                if($params['space_between_portfolio_items'] == 'yes') {
                    $classes[] = 'edgt-ptf-with-spaces';
                }

				break;
			case 'simple':
				$classes[] = 'edgt-ptf-simple';
				$classes[] = 'edgt-hover-' . $params['hover_type_simple'];
				break;
		endswitch;

		if (empty($params['portfolio_slider'])) { // portfolio slider mustn't have this classes

			if ($type == 'standard' || $type == 'gallery' || $type == 'simple') {
				switch ($columns):
					case 'one':
						$classes[] = 'edgt-ptf-one-column';
						break;
					case 'two':
						$classes[] = 'edgt-ptf-two-columns';
						break;
					case 'three':
						$classes[] = 'edgt-ptf-three-columns';
						break;
					case 'four':
						$classes[] = 'edgt-ptf-four-columns';
						break;
					case 'five':
						$classes[] = 'edgt-ptf-five-columns';
						break;
					case 'six':
						$classes[] = 'edgt-ptf-six-columns';
						break;
				endswitch;
			}
			if ($params['show_load_more'] == 'yes') {
				$classes[] = 'edgt-ptf-load-more';
			}

		}

		if ($type == 'pinterest' || $type == 'masonry') {
			switch ($grid_size):
				case 'three':
					$classes[] = 'edgt-ptf-' . $type . '-three-columns';
					break;
				case 'four':
					$classes[] = 'edgt-ptf-' . $type . '-four-columns';
					break;
				case 'five':
					$classes[] = 'edgt-ptf-' . $type . '-five-columns';
					break;
				case 'six':
					$classes[] = 'edgt-ptf-' . $type . '-six-columns';
					break;
			endswitch;
		}

		if ($params['filter'] == 'yes') {
			$classes[] = 'edgt-ptf-has-filter';
			if ($params['type'] == 'masonry' || $params['type'] == 'pinterest') {
				if ($params['filter'] == 'yes') {
					$classes[] = 'edgt-ptf-masonry-filter';
					$classes[] = $params['filter_position'];
				}
			}
		}

		if (!empty($params['portfolio_slider']) && $params['portfolio_slider'] == 'yes') {
			$classes[] = 'edgt-portfolio-slider-holder';
		}

		if (empty($params['portfolio_slider']) && $type !== 'standard') {
			if ($appear_effect != 'none') {
				$classes[] = 'edgt-appear-effect';

				if ($appear_effect == 'one_by_one') {
					$classes[] = 'edgt-one-by-one';
				} else if ($appear_effect == 'random') {
					$classes[] = 'edgt-random';
				}
			}
		}

		return implode(' ', $classes);

	}

	/**
	 * Generates portfolio item classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getPortfolioItemClasses($params) {
		$classes = array('edgt-portfolio-item');
		$type = $params['type'];

		switch ($type):
			case 'standard':
				$classes[] = 'mix';
				break;
			case 'gallery':
				$classes[] = 'mix';
				break;
			case 'simple':
				$classes[] = 'mix';
				break;
			case 'masonry':
				$classes[] = $params['article_masonry_size'];
				break;
			case 'pinterest':
				break;
		endswitch;

		$classes[] = $params['categories'];

		return $classes;

	}

	/**
	 * Generates portfolio image size
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getImageSize($params) {

		$thumb_size = 'full';
		$type = $params['type'];

		if ($type == 'standard' || $type == 'gallery' || $type == 'simple') {
			if (!empty($params['image_size'])) {
				$image_size = $params['image_size'];

				switch ($image_size) {
					case 'landscape':
						$thumb_size = 'eldritch_edge_landscape';
						break;
					case 'portrait':
						$thumb_size = 'eldritch_edge_portrait';
						break;
					case 'square':
						$thumb_size = 'eldritch_edge_square';
						break;
					case 'full':
						$thumb_size = 'full';
						break;
					case 'custom':
						$thumb_size = 'custom';
						break;
					default:
						$thumb_size = 'full';
						break;
				}
			}
		} elseif ($type == 'masonry') {

			$id = $params['current_id'];
			$masonry_size = get_post_meta($id, 'portfolio_masonry_dimenisions', true);

			switch ($masonry_size):
				case 'default' :
					$thumb_size = 'eldritch_edge_square';
					break;
				case 'large_width' :
					$thumb_size = 'eldritch_edge_large_width';
					break;
				case 'large_height' :
					$thumb_size = 'eldritch_edge_large_height';
					break;
				case 'large_width_height' :
					$thumb_size = 'eldritch_edge_large_width_height';
					break;
			endswitch;
		}


		return $thumb_size;
	}

	/**
	 * Generates portfolio item categories ids.This function is used for filtering
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getItemCategories($params) {
		$id = $params['current_id'];
		$category_return_array = array('portfolio_category_0');

		$categories = wp_get_post_terms($id, 'portfolio-category');

		foreach ($categories as $cat) {
			$category_return_array[] = 'portfolio_category_' . $cat->term_id;
		}

		return implode(' ', $category_return_array);
	}

	/**
	 * Generates portfolio item categories html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getItemCategoriesHtml($params) {
		$id = $params['current_id'];

		$categories = wp_get_post_terms($id, 'portfolio-category');
		$category_html = '<div class="edgt-ptf-category-holder">';
		$k = 1;
		foreach ($categories as $cat) {
			$category_html .= '<span>' . $cat->name . '</span>';
			if (count($categories) != $k) {
				$category_html .= ', ';
			}
			$k++;
		}
		$category_html .= '</div>';

		return $category_html;
	}

	/**
	 * Generates masonry size class for each article( based on id)
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getMasonrySize($params) {
		$masonry_size_class = '';

		if ($params['type'] == 'masonry') {

			$id = $params['current_id'];
			$masonry_size = get_post_meta($id, 'portfolio_masonry_dimenisions', true);
			switch ($masonry_size):
				case 'default' :
					$masonry_size_class = 'edgt-default-masonry-item';
					break;
				case 'large_width' :
					$masonry_size_class = 'edgt-large-width-masonry-item';
					break;
				case 'large_height' :
					$masonry_size_class = 'edgt-large-height-masonry-item';
					break;
				case 'large_width_height' :
					$masonry_size_class = 'edgt-large-width-height-masonry-item';
					break;
			endswitch;
		}

		return $masonry_size_class;
	}

	/**
	 * Generates filter categories array
	 *
	 * @param $params
	 *
	 *
	 *
	 *
	 * * @return array
	 */
	public function getFilterCategories($params) {

		$filter_categories = array();

		$cat_id = 0;

		$top_category = get_term_by('slug', $params['category'], 'portfolio-category');

		if (!empty($top_category)) {
			$cat_id = $top_category->term_id;
		}

		$filter_categories[$cat_id] = edgt_core_add_categories_to_array($cat_id, $params);

		return $filter_categories;
	}

	/**
	 * Generates datta attributes array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getDataAtts($params) {

		$data_attr = array();
		$data_return_string = '';

		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if (!empty($paged)) {
			$data_attr['data-next-page'] = $paged + 1;
		}

		if (!empty($params['type'])) {
			$data_attr['data-type'] = $params['type'];
		}

		if (!empty($params['columns'])) {
			$data_attr['data-columns'] = $params['columns'];
		}

		if (!empty($params['grid_size'])) {
			$data_attr['data-grid-size'] = $params['grid_size'];
		}

		if (!empty($params['order_by'])) {
			$data_attr['data-order-by'] = $params['order_by'];
		}

		if (!empty($params['order'])) {
			$data_attr['data-order'] = $params['order'];
		}

		if (!empty($params['number'])) {
			$data_attr['data-number'] = $params['number'];
		}

		if (!empty($params['image_size'])) {
			$data_attr['data-image-size'] = $params['image_size'];
		}

		if (!empty($params['custom_image_dimensions'])) {
			$data_attr['data-custom-image-dimensions'] = $params['custom_image_dimensions'];
		}

		if (!empty($params['filter'])) {
			$data_attr['data-filter'] = $params['filter'];
		}

		if (!empty($params['filter_order_by'])) {
			$data_attr['data-filter-order-by'] = $params['filter_order_by'];
		}

		if (!empty($params['category'])) {
			$data_attr['data-category'] = $params['category'];
		}

		if (!empty($params['shader_background_style'])) {
			$data_attr['data-shader-background-style'] = $params['shader_background_style'];
		}

		if (!empty($params['shader_background_color'])) {
			$data_attr['data-shader-background-color'] = $params['shader_background_color'];
		}

		if (!empty($params['selected_projectes'])) {
			$data_attr['data-selected-projects'] = $params['selected_projectes'];
		}

		if (!empty($params['title_tag'])) {
			$data_attr['data-title-tag'] = $params['title_tag'];
		}

		if (!empty($params['show_categories'])) {
			$data_attr['data-show-categories'] = $params['show_categories'];
		}

		if (!empty($params['text_length'] || $params['text_length']) == '0') {
			$data_attr['data-text-length'] = $params['text_length'];

			if($params['text_length'] == '0') {
                $data_attr['data-show-excerpt'] = 'no';
            }
		}

		if (!empty($params['show_load_more'])) {
			$data_attr['data-show-load-more'] = $params['show_load_more'];
		}

		if (!empty($params['portfolio_slider']) && $params['portfolio_slider'] == 'yes') {
			$data_attr['data-items'] = $params['portfolios_shown'];
		}

		foreach ($data_attr as $key => $value) {
			if ($key !== '') {
				$data_return_string .= $key . '="' . esc_attr($value) . '" ';
			}
		}

		return $data_return_string;
	}


	/**
	 * Checks if portfolio has external link and returns it. Else returns link to portfolio single page
	 *
	 * @param $params
	 *
	 * @return false|mixed|string
	 */
	public function getItemLink($params) {

		$portfolio_link_array = array();

		$id = $params['current_id'];
		$portfolio_link = get_permalink($id);
		$portfolio_target = '';

		if (get_post_meta($id, 'portfolio_external_link', true) !== '') {
			$portfolio_link = get_post_meta($id, 'portfolio_external_link', true);
			$portfolio_target = get_post_meta($id, 'portfolio_external_link_target', true);
		}

		$portfolio_link_array['href'] = $portfolio_link;
		$portfolio_link_array['target'] = $portfolio_target;

		return $portfolio_link_array;

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
	 * Sets portfolio item title tag
	 *
	 * @param $params
	 *
	 * @return false|mixed|string
	 */
	public function getItemTitleTag($params) {

		$title_tag = 'h4';

		if ($params['title_tag'] !== '') {
			$title_tag = $params['title_tag'];
		}

		return $title_tag;
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

		if ($params['shader_background_style'] !== 'variable_background_color') {
			if ($params['shader_background_color'] !== '') {
				$style[] = 'background-color:' . $params['shader_background_color'];
			}
		} else {
			$id = $params['current_id'];
			if (get_post_meta($id, 'portfolio_background_color', true) !== '') {
				$style[] = 'background-color:' . get_post_meta($id, 'portfolio_background_color', true);
			}
		}

		return $style;
	}

	/**
	 * Generates portfolio item shader styles
	 *
	 * @param $params
	 *
	 * @return html
	 */
//	public function getFilterStyles($params) {
//		$style = array();
//
//		if (!empty($params['filter_height'])) {
//			$style[] = 'height:' . $params['filter_height'];
//		}
//
//		return $style;
//	}
}