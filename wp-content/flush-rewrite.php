<?php
// WordPress core files inclusion
define('WP_USE_THEMES', false);
require_once(dirname(__FILE__) . '/../wp-load.php');

// Flush rewrite rules
flush_rewrite_rules(true);
echo "Rewrite rules flushed successfully!\n";

// Done
echo "Done!\n";