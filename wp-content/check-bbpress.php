<?php
// WordPress core files inclusion
define('WP_USE_THEMES', false);
require_once(dirname(__FILE__) . '/../wp-load.php');

// Flush rewrite rules
echo "Flushing rewrite rules...\n";
flush_rewrite_rules(true);
echo "Rewrite rules flushed.\n";

// Check BBPress enablement status
echo "Checking BBPress settings:\n";
$bbp_enable_forums = get_option('_bbp_enable_forums');
echo "- Forums enabled: " . ($bbp_enable_forums ? 'Yes' : 'No') . "\n";

// Check for active plugins
echo "\nActive plugins:\n";
$active_plugins = get_option('active_plugins');
foreach ($active_plugins as $plugin) {
    echo "- $plugin\n";
}

// Verify BBPress post types are properly registered
echo "\nRegistered post types:\n";
$post_types = get_post_types(['public' => true], 'names');
foreach ($post_types as $post_type) {
    echo "- $post_type\n";
}

// Check BBPress rewrite rules
echo "\nBBPress related rewrite rules:\n";
$rules = get_option('rewrite_rules');
$bbp_rules = array_filter($rules, function($key) {
    return strpos($key, 'forums') !== false;
}, ARRAY_FILTER_USE_KEY);

$count = 0;
foreach ($bbp_rules as $rule => $redirect) {
    echo "- Rule: $rule\n  Redirect: $redirect\n";
    $count++;
    if ($count >= 10) {
        echo "... (more rules omitted)\n";
        break;
    }
}

// Enable forums if not enabled
if (!$bbp_enable_forums) {
    echo "\nAttempting to enable forums...\n";
    update_option('_bbp_enable_forums', '1');
    echo "Forums option updated. Please check if it's now enabled.\n";
    
    // Flush rewrite rules again after enabling forums
    flush_rewrite_rules(true);
    echo "Rewrite rules flushed again.\n";
}

// Check permalink structure
$permalink_structure = get_option('permalink_structure');
echo "\nCurrent permalink structure: " . $permalink_structure . "\n";

// Display BBPress-related settings
echo "\nBBPress Options:\n";
$bbp_options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE '%bbp%'");
foreach ($bbp_options as $option) {
    echo "- {$option->option_name}: {$option->option_value}\n";
}

echo "\nDone!\n";