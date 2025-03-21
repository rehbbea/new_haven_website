<?php
/*
Plugin Name: Edge Instagram Feed
Description: Plugin that adds Instagram feed functionality to our theme
Author: Edge Themes
Version: 2.0.1
*/
define('EDGE_INSTAGRAM_FEED_VERSION', '2.0.1');

include_once 'load.php';

if (!function_exists('edgt_instagram_feed_text_domain')) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function edgt_instagram_feed_text_domain() {
		load_plugin_textdomain('edge-instagram-feed', false, EDGE_INSTAGRAM_FEED_REL_PATH . '/languages');
	}

	add_action('plugins_loaded', 'edgt_instagram_feed_text_domain');
}