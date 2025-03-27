=== BBPress URL Fix for Index.php ===
Contributors: Claude
Tags: bbpress, forum, url, permalink, index.php
Requires at least: 4.0
Tested up to: 6.5
Stable tag: 1.0
License: GPLv2 or later

Fixes BBPress user profile URL 404 errors when using index.php in permalink structure.

== Description ==

This plugin addresses a specific issue with BBPress user profile URLs when the WordPress site uses a permalink structure that includes /index.php/ in the URL path.

When WordPress is configured with a permalink structure like /index.php/%year%/%monthnum%/%day%/%postname%/, BBPress user profile URLs (such as /index.php/forums/users/username/topics/) may result in 404 errors despite being correctly formatted.

This plugin:

1. Ensures forum functionality is enabled
2. Flushes rewrite rules to properly register BBPress URL patterns
3. Adds custom template handling to properly load user profile pages

== Installation ==

1. Upload the `bbpress-url-fix` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it! The plugin will automatically fix BBPress user profile URLs

== Frequently Asked Questions ==

= Why am I getting 404 errors on BBPress user profile pages? =

When WordPress uses a non-standard permalink structure with /index.php/ in the URL path, BBPress may have difficulty properly handling user profile URLs. This plugin fixes that issue.

= How can I verify the plugin is working? =

After activating the plugin, visit a BBPress user profile URL (like /index.php/forums/users/username/). If you previously had a 404 error and now see the user profile page, the plugin is working correctly.

For administrators, you can add ?bbp_debug=1 to any BBPress URL to see debugging information.

== Changelog ==

= 1.0 =
* Initial release