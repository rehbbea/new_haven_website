<?php
/**
 * Plugin Name: BBPress URL Fix for Index.php
 * Description: Fixes the 404 errors for BBPress user profile URLs when using index.php in permalink structure
 * Version: 1.0
 * Author: Claude
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Main Plugin Class
 */
class BBPress_URL_Fix {

    /**
     * Constructor
     */
    public function __construct() {
        // Make sure BBPress is active before doing anything
        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Initialize plugin
     */
    public function init() {
        // Only run if BBPress is active
        if (!function_exists('bbpress')) {
            return;
        }

        // Ensure forum functionality is enabled
        update_option('_bbp_enable_forums', '1');
        
        // Add rewrite flushing detection
        if (!get_option('bbp_url_fix_rewrite_flushed')) {
            add_action('wp_loaded', array($this, 'flush_rewrite_rules'));
        }
        
        // Add filter to fix URL handling for BBPress user profiles
        add_filter('bbp_template_include', array($this, 'fix_bbpress_template_loading'), 10, 1);

        // Add debugging support
        add_action('init', array($this, 'add_debug_support'));
    }

    /**
     * Flush rewrite rules to ensure BBPress URLs work properly
     */
    public function flush_rewrite_rules() {
        flush_rewrite_rules(true);
        update_option('bbp_url_fix_rewrite_flushed', '1');
    }

    /**
     * Fix BBPress template loading for user profile URLs
     */
    public function fix_bbpress_template_loading($template) {
        // Check if we're on a user profile page via URL
        if (isset($_SERVER['REQUEST_URI'])) {
            $request_uri = sanitize_text_field($_SERVER['REQUEST_URI']);
            $user_pattern = '/index\.php\/forums\/users\/([^\/]+)/';
            
            // If this matches a BBPress user URL pattern
            if (preg_match($user_pattern, $request_uri, $matches)) {
                // Get the requested user
                $user_nicename = isset($matches[1]) ? $matches[1] : '';
                
                if (!empty($user_nicename)) {
                    // Force set the BBPress user query var
                    set_query_var('bbp_user', $user_nicename);
                    
                    // Check for specific user sections
                    if (strpos($request_uri, '/topics/') !== false) {
                        set_query_var('bbp_tops', 1);
                    } elseif (strpos($request_uri, '/replies/') !== false) {
                        set_query_var('bbp_reps', 1);
                    } elseif (strpos($request_uri, '/favorites/') !== false) {
                        set_query_var('bbp_favs', 1);
                    } elseif (strpos($request_uri, '/subscriptions/') !== false) {
                        set_query_var('bbp_subs', 1);
                    }
                    
                    // Get the user profile template
                    $new_template = bbp_get_single_user_template();
                    
                    if (!empty($new_template)) {
                        return $new_template;
                    }
                }
            }
        }
        
        return $template;
    }

    /**
     * Add debug support to log issues
     */
    public function add_debug_support() {
        if (isset($_GET['bbp_debug']) && current_user_can('manage_options')) {
            add_action('wp_footer', array($this, 'display_debug_info'));
        }
    }

    /**
     * Display debug information for administrators
     */
    public function display_debug_info() {
        global $wp_rewrite;
        
        // Only show for admins
        if (!current_user_can('manage_options')) {
            return;
        }
        
        echo '<div style="background:#f8f8f8; padding:20px; margin:20px; border:1px solid #ddd;">';
        echo '<h2>BBPress URL Fix Debug Info</h2>';
        
        // Show current user and query vars
        echo '<h3>User & Query Vars</h3>';
        echo '<pre>';
        echo 'Current User: ' . esc_html(bbp_get_displayed_user_id()) . "\n";
        echo 'BBP User Query Var: ' . esc_html(get_query_var('bbp_user')) . "\n";
        echo 'Request URI: ' . esc_html($_SERVER['REQUEST_URI']) . "\n";
        echo '</pre>';
        
        // Show rewrite rules relevant to forums
        echo '<h3>Forum Rewrite Rules</h3>';
        echo '<pre>';
        $rules = get_option('rewrite_rules');
        foreach ($rules as $rule => $query) {
            if (strpos($rule, 'forums/users') !== false) {
                echo esc_html($rule) . ' => ' . esc_html($query) . "\n";
            }
        }
        echo '</pre>';
        
        // Show permalink structure
        echo '<h3>Permalink Structure</h3>';
        echo '<pre>';
        echo 'Structure: ' . esc_html(get_option('permalink_structure')) . "\n";
        echo '</pre>';
        
        echo '</div>';
    }
}

// Initialize the plugin
new BBPress_URL_Fix();