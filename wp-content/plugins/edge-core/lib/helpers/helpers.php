<?php

if (!function_exists('edgt_core_version_class')) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function edgt_core_version_class($classes) {
		$classes[] = 'edgt-core-' . EDGE_CORE_VERSION;

		return $classes;
	}

	add_filter('body_class', 'edgt_core_version_class');
}

if (!function_exists('edgt_core_theme_installed')) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function edgt_core_theme_installed() {
		return defined('EDGE_ROOT');
	}
}

if (!function_exists('edgt_core_get_carousel_slider_array')) {
	/**
	 * Function that returns associative array of carousels,
	 * where key is term slug and value is term name
	 * @return array
	 */
	function edgt_core_get_carousel_slider_array() {
		$carousels_array = array();
		$terms = get_terms('carousels_category');

		if (is_array($terms) && count($terms)) {
			$carousels_array[''] = '';
			foreach ($terms as $term) {
				$carousels_array[$term->slug] = $term->name;
			}
		}

		return $carousels_array;
	}
}

if (!function_exists('edgt_core_get_carousel_slider_array_vc')) {
	/**
	 * Function that returns array of carousels formatted for Visual Composer
	 *
	 * @return array array of carousels where key is term title and value is term slug
	 *
	 * @see edgt_core_get_carousel_slider_array
	 */
	function edgt_core_get_carousel_slider_array_vc() {
		return array_flip(edgt_core_get_carousel_slider_array());
	}
}

if (!function_exists('edgt_core_get_shortcode_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @see eldritch_edge_get_template_part()
	 */
	function edgt_core_get_shortcode_module_template_part($template, $module, $slug = '', $params = array()) {

		//HTML Content from template
		$html = '';
		$template_path = EDGE_CORE_CPT_PATH . '/' . $module . '/shortcodes';

		$temp = $template_path . '/' . $template;
		if (is_array($params) && count($params)) {
			extract($params);
		}

		$template = '';

		if ($temp !== '') {
			if ($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
			$template = $temp . '.php';
		}
		if ($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}

		return $html;
	}
}

if (!function_exists('edgt_core_ajax_url')) {
	/**
	 * load themes ajax functionality
	 *
	 */
	function edgt_core_ajax_url() {
		echo '<script type="application/javascript">var edgtCoreAjaxUrl = "' . admin_url('admin-ajax.php') . '"</script>';
	}

	add_action('wp_enqueue_scripts', 'edgt_core_ajax_url');

}

if (!function_exists('edgt_core_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 *
	 * @param $value string | array attribute value
	 *
	 */
	function edgt_core_inline_style($value) {
		echo edgt_core_get_inline_style($value);
	}
}

if (!function_exists('edgt_core_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 *
	 * @param $value string | array value of style attribute
	 *
	 * @return string generated style attribute
	 *
	 */
	function edgt_core_get_inline_style($value) {
		return edgt_core_get_inline_attr($value, 'style', ';');
	}
}

if (!function_exists('edgt_core_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 *
	 * @param $value string value of class attribute
	 *
	 * @see edgt_core_get_class_attribute()
	 */
	function edgt_core_class_attribute($value) {
		echo edgt_core_get_class_attribute($value);
	}
}

if (!function_exists('edgt_core_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 *
	 * @param $value string value of class attribute
	 *
	 * @return string generated class attribute
	 *
	 * @see edgt_core_get_inline_attr()
	 */
	function edgt_core_get_class_attribute($value) {
		return edgt_core_get_inline_attr($value, 'class', ' ');
	}
}

if (!function_exists('edgt_core_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 *
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 *
	 * @return string generated html attribute
	 */
	function edgt_core_get_inline_attr($value, $attr, $glue = '') {
		if (!empty($value)) {

			if (is_array($value) && count($value)) {
				$properties = implode($glue, $value);
			} elseif ($value !== '') {
				$properties = $value;
			}

			return $attr . '="' . esc_attr($properties) . '"';
		}

		return '';
	}
}

if (!function_exists('edgt_core_inline_attr')) {
	/**
	 * Function that generates html attribute
	 *
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 *
	 * @return string generated html attribute
	 */
	function edgt_core_inline_attr($value, $attr, $glue = '') {
		echo edgt_core_get_inline_attr($value, $attr, $glue);
	}
}

if (!function_exists('edgt_core_get_inline_attrs')) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param $attrs
	 *
	 * @return string
	 */
	function edgt_core_get_inline_attrs($attrs) {
		$output = '';

		if (is_array($attrs) && count($attrs)) {
			foreach ($attrs as $attr => $value) {
				$output .= ' ' . edgt_core_get_inline_attr($value, $attr);
			}
		}

		ltrim($output);

		return $output;
	}
}

if (!function_exists('edgt_core_get_attachment_id_from_url')) {
	/**
	 * Function that retrieves attachment id for passed attachment url
	 *
	 * @param $attachment_url
	 *
	 * @return null|string
	 */
	function edgt_core_get_attachment_id_from_url($attachment_url) {
		global $wpdb;
		$attachment_id = '';

		//is attachment url set?
		if ($attachment_url !== '') {
			//prepare query

			$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $attachment_url);

			//get attachment id
			$attachment_id = $wpdb->get_var($query);
		}

		//return id
		return $attachment_id;
	}
}

/**
 * Edit Yith Wishlist options
 */

if (!function_exists('eldritch_edge_wishlist_admin_options')) {
	function eldritch_edge_wishlist_admin_options($options) {

		if (isset($options['general_settings']) && isset($options['general_settings']['add_to_wishlist_position'])) {

			$positions = $options['general_settings']['add_to_wishlist_position']['options'];
			$custom_positions = array(
				'title' => esc_html__('After Product Title', 'edge-core')
			);
			$positions = array_merge($custom_positions, $positions);
			$options['general_settings']['add_to_wishlist_position']['options'] = $positions;

			$options['general_settings']['add_to_wishlist_text']['default'] = esc_html__('Like', 'edge-core');
			$options['general_settings']['browse_wishlist_text']['default'] = esc_html__('Liked', 'edge-core');

			return $options;

		}

	}

	add_filter('yith_wcwl_admin_options', 'eldritch_edge_wishlist_admin_options', 10, 1);
}


if (!function_exists('eldritch_edge_add_to_wishlist_position')) {
	function eldritch_edge_add_to_wishlist_position($positions) {

		if (edgt_core_theme_installed()) {
			//Priority 100, after share
			$positions['title'] = array('hook' => 'woocommerce_single_product_summary', 'priority' => 8);
		}

		return $positions;

	}

	add_filter('yith_wcwl_positions', 'eldritch_edge_add_to_wishlist_position');
}

if (!function_exists('edgt_core_init_shortcode_loader')) {
	function edgt_core_init_shortcode_loader() {

		include_once 'shortcode-loader.php';
	}

	add_action('eldritch_edge_shortcode_loader', 'edgt_core_init_shortcode_loader');
}

if (!function_exists('edgt_core_add_user_custom_fields')) {
	/**
	 * Function creates custom social fields for users
	 *
	 * return $user_contact
	 */
	function edgt_core_add_user_custom_fields($user_contact) {

		/**
		 * Function that add custom user fields
		 **/
		$user_contact['position'] = esc_html__('Position', 'edge-core');
		$user_contact['instagram'] = esc_html__('Instagram', 'edge-core');
		$user_contact['twitter'] = esc_html__('Twitter', 'edge-core');
		$user_contact['pinterest'] = esc_html__('Pinterest', 'edge-core');
		$user_contact['tumblr'] = esc_html__('Tumbrl', 'edge-core');
		$user_contact['facebook'] = esc_html__('Facebook', 'edge-core');
		$user_contact['googleplus'] = esc_html__('Google Plus', 'edge-core');
		$user_contact['linkedin'] = esc_html__('Linkedin', 'edge-core');

		return $user_contact;
	}

	add_filter('user_contactmethods', 'edgt_core_add_user_custom_fields');
}

function edgt_core_get_child_categories_ids($cat_id, $params, $all) {
	$categoriesIds = array();

	$order = ($params['filter_order_by'] === 'count') ? 'DESC' : 'ASC';

	$args = array(
		'taxonomy'   => 'portfolio-category',
		'hide_empty' => false,
		'orderby'    => $params['filter_order_by'],
		'order'      => $order
	);

	if ($all) {
		$args['child_of'] = $cat_id;
	} else {
		$args['parent'] = $cat_id;
	}

	$categories = get_terms($args);

	foreach ($categories as $category) {
		$categoriesIds[] = $category->term_id;
	}

	return $categoriesIds;
}

function edgt_core_add_categories_to_array($cat_id, $params) {
	$params['filter_levels']--;

	if ($params['filter_levels'] < 1) {
		$categories = edgt_core_get_child_categories_ids($cat_id, $params, true);
	} else {
		$categories = edgt_core_get_child_categories_ids($cat_id, $params, false);
	}


	if (!is_array($categories) || $params['filter_levels'] < 0) {
		return array();
	}

	$child_cats = array();

	foreach ($categories as $child_cat_id) {
		$child_cats[$child_cat_id] = edgt_core_add_categories_to_array($child_cat_id, $params);
	}

	return $child_cats;
}

function edgt_core_filter_cateogories_html($filter_categories, $top_category_id, $params) {
	$data_group_id = '';
	$data_parent_id = 'data-parent-id="' . $top_category_id . '"';
	$last_level_class = $params['filter_levels'] == 1 ? 'edgt-filter-last-level' : 'edgt-filter-' . $params['filter_levels'] . '-level';
	$html = '<ul class="' . $last_level_class . ' clearfix" ' . $data_parent_id . '>';

	if ($params['filter_levels'] == 1) {
		$html .= '<li class="parent-filter edgt-filter filter" data-filter=".portfolio_category_0" ' . $data_parent_id . ' data-class="filter">' . esc_html__('All', 'edge-core') . '</li>';
	}

	$params['filter_levels']--;

	foreach ($filter_categories[$top_category_id] as $filter_category_id => $filter_category_value) {
		$data_group_id = 'data-group-id="' . $filter_category_id . '"';

		$html .= '<li class="parent-filter edgt-filter filter" data-filter=".portfolio_category_' . $filter_category_id . '" ' . $data_group_id . ' data-class="filter">' . get_term( $filter_category_id, 'portfolio-category')->name . '</li>';
	}

	foreach ($filter_categories[$top_category_id] as $filter_category_id => $filter_category_value) {
		if (!empty($filter_category_value)) {
			$html .= edgt_core_filter_cateogories_html($filter_categories[$top_category_id], $filter_category_id, $params);
			$html .= '</ul>';
		}
	}

	return $html;
}

/* Function for adding custom meta boxes hooked to default action */
if ( class_exists( 'WP_Block_Type' ) && defined( 'EDGE_ROOT' ) ) {
	add_action( 'admin_head', 'eldritch_edge_meta_box_add' );
} else {
	add_action( 'add_meta_boxes', 'eldritch_edge_meta_box_add' );
}

if ( ! function_exists( 'eldritch_edge_create_meta_box_handler' ) ) {
	function eldritch_edge_create_meta_box_handler( $box, $key, $screen ) {
		add_meta_box(
			'edgt-meta-box-' . $key,
			$box->title,
			'eldritch_edge_render_meta_box',
			$screen,
			'advanced',
			'high',
			array( 'box' => $box )
		);
	}
}

if ( ! function_exists( 'eldritch_edge_create_wp_widget' ) ) {
	function eldritch_edge_create_wp_widget( $widget ) {
		register_widget($widget);
	}
}

if ( ! function_exists( 'edge_core_get_core_shortcode_template_part' ) ) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $shortcode name of the shortcode folder
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function edge_core_get_core_shortcode_template_part( $template, $shortcode, $slug = '', $params = array() ) {

		//HTML Content from template
		$html          = '';
		$template_path = EDGE_CORE_SHORTCODES_PATH . '/' . $shortcode;

		$temp = $template_path . '/' . $template;

		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}

		$template = '';

		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";

				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		if ( $template ) {
			ob_start();
			include( $template );
			$html = ob_get_clean();
		}

		return $html;
	}
}

if (!function_exists('eldritch_edge_vc_custom_style')) {

	/**
	 * Function that print custom page style
	 */

	function eldritch_edge_vc_custom_style() {
		if (eldritch_edge_visual_composer_installed()) {
			$id = eldritch_edge_get_page_id();
			if (is_page() || is_single() || is_singular('portfolio-item')) {

				$shortcodes_custom_css = get_post_meta($id, '_wpb_shortcodes_custom_css', true);
				if (!empty($shortcodes_custom_css)) {
					echo '<style type="text/css" data-type="vc_shortcodes-custom-css-' . esc_attr($id) . '">';
					echo get_post_meta($id, '_wpb_shortcodes_custom_css', true);
					echo '</style>';
				}

				$post_custom_css = get_post_meta($id, '_wpb_post_custom_css', true);
				if (!empty($post_custom_css)) {
					echo '<style type="text/css" data-type="vc_custom-css-' . esc_attr($id) . '">';
					echo get_post_meta($id, '_wpb_post_custom_css', true);
					echo '</style>';
				}
			}
		}
	}
}