<?php

namespace EdgeCore\CPT\Testimonials\Shortcodes;


use EdgeCore\Lib;

/**
 * Class Testimonials
 * @package EdgeCore\CPT\Testimonials\Shortcodes
 */
class Testimonials implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_testimonials';

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
				'name'                      => esc_html__('Testimonials', 'edge-core'),
				'base'                      => $this->base,
				'category' => esc_html__( 'by EDGE', 'edge-core' ),
				'icon'                      => 'icon-wpb-testimonials extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Set Dark/Light type', 'edge-core'),
						'param_name'  => 'dark_light_type',
						'value'       => array(
							esc_html__('Dark', 'edge-core')  => 'dark',
							esc_html__('Light', 'edge-core') => 'light',
						),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'holder'      => 'div',
						'class'       => '',
						'heading'     => esc_html__('Navigation Skin', 'edge-core'),
						'param_name'  => 'navigation_skin',
						'value'       => array(
							esc_html__('Disabled', 'edge-core')  => '',
							esc_html__('Dark', 'edge-core')  => 'dark',
							esc_html__('Light', 'edge-core') => 'light',
						),
						'description' => '',
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Category', 'edge-core'),
						'param_name'  => 'category',
						'value'       => '',
						'description' => esc_html__('Category Slug (leave empty for all)', 'edge-core')
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Number', 'edge-core'),
						'param_name'  => 'number',
						'value'       => '',
						'description' => esc_html__('Number of Testimonials', 'edge-core')
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Image', 'edge-core'),
						'param_name'  => 'show_image',
						'value'       => array(
                            esc_html__('No', 'edge-core')  => 'no',
                            esc_html__('Yes', 'edge-core') => 'yes',
						),
						'save_always' => true,
						'description' => ''
					),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Quote background color', 'edge-core'),
                        'param_name'  => 'quote_background_color',
                        'dependency'  => Array('element' => 'show_image', 'value' => 'yes'),
                        'save_always' => true
                    ),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Author', 'edge-core'),
						'param_name'  => 'show_author',
						'value'       => array(
							esc_html__('Yes', 'edge-core') => 'yes',
							esc_html__('No', 'edge-core')  => 'no'
						),
						'save_always' => true,
						'description' => ''
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Author Job Position', 'edge-core'),
						'param_name'  => 'show_position',
						'value'       => array(
							esc_html__('No', 'edge-core')  => 'no',
                            esc_html__('Yes', 'edge-core') => 'yes',
						),
						'save_always' => true,
						'dependency'  => array('element' => 'show_author', 'value' => array('yes')),
						'description' => ''
					)
				)
			));
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
			'number'                => '-1',
			'category'              => '',
			'show_image'            => 'no',
			'show_author'           => 'yes',
			'show_position'         => 'no',
			'dark_light_type'       => '',
			'navigation_skin'       => '',
            'quote_background_color' => '',
			'number_of_columns'     => ''
		);

		$params = shortcode_atts($args, $atts);

		//Extract params for use in method
		extract($params);

		$holder_classes = $this->getClasses($params);
        $params['quote_styles'] = $this->getInlineStyles($params);
		$query_args = $this->getQueryParams($params);

		$html = '';
		$html .= '<div class="edgt-testimonials-holder clearfix ' . $dark_light_type . '">';
		$html .= '<div ' . eldritch_edge_get_class_attribute($holder_classes) . '>';

		query_posts($query_args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				$logo_image = get_post_meta(get_the_ID(), 'edgt_testimonaial_logo_image', true);
				$author = get_post_meta(get_the_ID(), 'edgt_testimonial_author', true);
				$text = get_post_meta(get_the_ID(), 'edgt_testimonial_text', true);
				$title = get_post_meta(get_the_ID(), 'edgt_testimonial_title', true);
				$job = get_post_meta(get_the_ID(), 'edgt_testimonial_author_position', true);

				$counter_classes = '';

				if ($params['dark_light_type'] == 'light') {
					$counter_classes .= 'light';
				} elseif($params['dark_light_type'] == 'dark') {
                    $counter_classes .= 'dark';
                }


				$params['light_class'] = $counter_classes;

				$params['logo_image'] = $logo_image;
				$params['author'] = $author;
				$params['text'] = $text;
				$params['title'] = $title;
				$params['job'] = $job;
				$params['current_id'] = get_the_ID();

				$html .= edgt_core_get_shortcode_module_template_part('templates/testimonials-slider', 'testimonials', '', $params);

			endwhile;
		else:
			$html .= esc_html__('Sorry, no posts matched your criteria.', 'edge-core');
		endif;

		wp_reset_query();
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Generates testimonial classes array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getClasses($params) {
		$classes = array('edgt-testimonials');

		$classes[] = 'edgt-' . $params['navigation_skin'] . '-navigation';

		return $classes;
	}

    /**
     * Generates testimonial inline styles array
     *
     * @param $params
     *
     * @return array
     */
    private function getInlineStyles($params) {
        $styles = array();

        if (isset($params['quote_background_color'])) {
            $styles[] = 'background-color: ' . $params['quote_background_color'];
        }

        return $styles;
    }

	/**
	 * Generates testimonials query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getQueryParams($params) {

		$args = array(
			'post_type'      => 'testimonials',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'posts_per_page' => $params['number']
		);

		if ($params['category'] != '') {
			$args['testimonials_category'] = $params['category'];
		}

		return $args;
	}

}