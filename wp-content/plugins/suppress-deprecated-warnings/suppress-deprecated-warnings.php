<?php
/**
 * Plugin Name: Suppress Deprecated Warnings
 * Plugin URI: 
 * Description: Suppresses all PHP 8.2+ deprecated warnings in WordPress
 * Version: 1.0
 * Author: Claude AI
 * Author URI: 
 * License: GPL2
 */

defined('ABSPATH') or die('No direct script access allowed.');

// The simplest way - suppress all E_DEPRECATED and E_USER_DEPRECATED warnings
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// This function runs on plugin activation
function suppress_deprecated_warnings_activate() {
    // Nothing special needed on activation
}
register_activation_hook(__FILE__, 'suppress_deprecated_warnings_activate');

// Add an admin notice to inform about the suppression (only for admins)
function suppress_deprecated_warnings_admin_notice() {
    if (current_user_can('manage_options') && is_admin()) {
        $message = 'Deprecated PHP warnings are being suppressed by the "Suppress Deprecated Warnings" plugin.';
        $class = 'notice notice-info is-dismissible';
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }
}
add_action('admin_notices', 'suppress_deprecated_warnings_admin_notice');
