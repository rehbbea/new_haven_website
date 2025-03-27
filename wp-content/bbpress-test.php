<?php
// WordPress core files inclusion
define('WP_USE_THEMES', false);
require_once(dirname(__FILE__) . '/../wp-load.php');

// Test URL structure with current permalink structure
$permalink_structure = get_option('permalink_structure');
echo "Current permalink structure: " . $permalink_structure . "\n";

// BBPress enabled
$bbp_enable_forums = get_option('_bbp_enable_forums');
echo "Forums enabled: " . ($bbp_enable_forums ? 'Yes' : 'No') . "\n\n";

// Test user profile URLs
$test_user = get_user_by('login', 'ouroboros');
if ($test_user) {
    $user_id = $test_user->ID;
    echo "Test user found (ID: {$user_id})\n";
    
    // Get BBPress user profile URL
    wp_set_current_user($user_id);
    $profile_url = bbp_get_user_profile_url($user_id);
    echo "User profile URL: {$profile_url}\n";
    
    // Test various user section URLs
    $topics_url = bbp_get_user_topics_created_url($user_id);
    $replies_url = bbp_get_user_replies_created_url($user_id);
    $favorites_url = bbp_get_favorites_permalink($user_id);
    $subscriptions_url = bbp_get_subscriptions_permalink($user_id);
    
    echo "Topics URL: {$topics_url}\n";
    echo "Replies URL: {$replies_url}\n";
    echo "Favorites URL: {$favorites_url}\n";
    echo "Subscriptions URL: {$subscriptions_url}\n\n";
    
    // Now create the same URLs but explicitly adding /index.php/ to the path
    $site_url = site_url();
    $base_url = $site_url . '/index.php/forums/users/' . bbp_get_user_nicename($user_id);
    
    echo "Manual URLs (with /index.php/):\n";
    echo "User profile: {$base_url}/\n";
    echo "Topics: {$base_url}/topics/\n";
    echo "Replies: {$base_url}/replies/\n";
    echo "Favorites: {$base_url}/favorites/\n";
    echo "Subscriptions: {$base_url}/subscriptions/\n\n";
} else {
    echo "Test user 'ouroboros' not found.\n";
}

// Test if BBPress recognizes URLs correctly
function test_bbpress_url($url) {
    // Create a mock request
    $parsed_url = parse_url($url);
    $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    
    // Set up global variables similar to a real request
    $_SERVER['REQUEST_URI'] = $path;
    
    // Check if BBPress can parse this URL
    $is_user = bbp_is_single_user();
    $is_user_topics = bbp_is_single_user() && bbp_is_single_user_topics();
    $is_user_replies = bbp_is_single_user() && bbp_is_single_user_replies();
    
    echo "URL: {$url}\n";
    echo "  - Is user profile: " . ($is_user ? 'Yes' : 'No') . "\n";
    echo "  - Is user topics: " . ($is_user_topics ? 'Yes' : 'No') . "\n";
    echo "  - Is user replies: " . ($is_user_replies ? 'Yes' : 'No') . "\n";
}

// Test a few URLs
echo "Testing URL recognition:\n";
if (isset($profile_url)) {
    test_bbpress_url($profile_url);
    test_bbpress_url($topics_url);
    test_bbpress_url($replies_url);
}

// Check if there's a conflict between URL structures
echo "\nChecking rewrite rules for potential conflicts:\n";
$rules = get_option('rewrite_rules');
$conflicting_rules = [];

foreach ($rules as $pattern => $query) {
    if (strpos($pattern, 'forums/users') !== false) {
        echo "Rule: {$pattern}\n  Query: {$query}\n";
        
        // Check if this rule might conflict with others
        $conflicting_patterns = 0;
        foreach ($rules as $other_pattern => $other_query) {
            if ($pattern !== $other_pattern && similar_text($pattern, $other_pattern) > 10) {
                $conflicting_patterns++;
                $conflicting_rules[$pattern][] = $other_pattern;
            }
        }
        if ($conflicting_patterns > 0) {
            echo "  Potential conflicts: {$conflicting_patterns}\n";
        }
    }
}

// Check the template resolution for BBPress URLs
echo "\nTemplate Resolution Test:\n";
if (isset($profile_url)) {
    // Set up globals to simulate being on a BBPress page
    set_query_var('bbp_user', bbp_get_user_nicename($user_id));
    
    // Check if BBPress can find the right template
    $template = bbp_get_theme_compat_templates();
    echo "Template path: " . ($template ? $template : 'No template found') . "\n";
    
    // Check if the template exists
    if ($template && file_exists(STYLESHEETPATH . '/' . $template)) {
        echo "Template file exists in theme.\n";
    } elseif ($template && file_exists(TEMPLATEPATH . '/' . $template)) {
        echo "Template file exists in parent theme.\n";
    } elseif ($template) {
        echo "Template file doesn't exist in either theme.\n";
    }
}

echo "\nDone!\n";