=== Fix The Events Calendar Warnings ===
Contributors: 
Tags: tribe, events-calendar, deprecated, warnings, fix
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fix deprecated dynamic property warnings and parameter type warnings in The Events Calendar plugin for PHP 8.2+.

== Description ==

This plugin fixes various PHP 8.2+ deprecated warnings in The Events Calendar plugin:

* Fixes deprecated dynamic property creation warnings
* Adds explicit nullable type declarations to parameters
* Uses class aliasing to preserve original functionality
* No direct modification of original plugin files

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/fix-tribe-events-warnings` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. The warnings should be resolved immediately

== Changelog ==

= 1.0 =
* Initial release
