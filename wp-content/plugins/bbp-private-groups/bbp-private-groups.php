<?php

/*
Plugin Name: bbP private groups
Plugin URI: http://www.rewweb.co.uk/bbp-private-groups/
Description: This plugin adds private groups to the forums, allocating users to groups, and combinations of forums to those groups, creating multiple closed forums.
Version: 3.9.7
Text Domain: bbp-private-groups
Domain Path: /lang
Author: Robin Wilson
Author URI: http://www.rewweb.co.uk
License: GPL2
*/
/*  Copyright 2013-2015  PLUGIN_AUTHOR_NAME  (email : wilsonrobine@btinternet.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	

/*******************************************
* global variables
*******************************************/

// load the plugin options
$rpg_settingsf = get_option( 'rpg_settingsf' );
$rpg_settingsg = get_option( 'rpg_settingsg' );
$rpg_groups = get_option ( 'rpg_groups') ;
$rpg_roles = get_option ( 'rpg_roles') ;
$rpg_topic_permissions = get_option ('rpg_topic_permissions') ;
$rpg_disable_groups = get_option ('rpg_disable_groups') ;


if(!defined('PG_PLUGIN_DIR'))
	define('PG_PLUGIN_DIR', dirname(__FILE__));
	
function bbp_private_groups_init() {
  load_plugin_textdomain('bbp-private-groups', false, basename( dirname( __FILE__ ) ) . '/lang' );
}
add_action('plugins_loaded', 'bbp_private_groups_init');


/*******************************************
* file includes 
*******************************************/
include(PG_PLUGIN_DIR . '/includes/user-profile.php');
include(PG_PLUGIN_DIR . '/includes/meta-box.php');
include(PG_PLUGIN_DIR . '/includes/forum-filters.php');
include(PG_PLUGIN_DIR . '/includes/functions.php');
include(PG_PLUGIN_DIR . '/includes/user-view-post.php');
include(PG_PLUGIN_DIR . '/includes/pg_forum_widgets.php');
include(PG_PLUGIN_DIR . '/includes/settings.php');
include(PG_PLUGIN_DIR . '/includes/search.php');
include(PG_PLUGIN_DIR . '/includes/topics.php');
include(PG_PLUGIN_DIR . '/includes/replies.php');
include(PG_PLUGIN_DIR . '/includes/link_query.php');
include(PG_PLUGIN_DIR . '/includes/mark-as-read-filter.php');
include(PG_PLUGIN_DIR . '/includes/shortcodes.php');
include(PG_PLUGIN_DIR . '/includes/user_management.php');
include(PG_PLUGIN_DIR . '/includes/role_assignment.php');
include(PG_PLUGIN_DIR . '/includes/widget_warning.php');
include(PG_PLUGIN_DIR . '/includes/shortcode_warning.php');
include(PG_PLUGIN_DIR . '/includes/plugin-info.php');
include(PG_PLUGIN_DIR . '/includes/help.php');
include(PG_PLUGIN_DIR . '/includes/topic_permissions.php');
include(PG_PLUGIN_DIR . '/includes/private_groups_adds_class.php');
include(PG_PLUGIN_DIR . '/includes/programmers_help.php');
include(PG_PLUGIN_DIR . '/includes/disable_groups.php');
include(PG_PLUGIN_DIR . '/includes/topic_filters.php');
include(PG_PLUGIN_DIR . '/includes/management_info.php');
