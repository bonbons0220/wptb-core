<?php
/*
Plugin Name: WPTB-Core Plugin
Plugin URI: git@github.com:bonbons0220/wptb-core.git
Description: Core Plug-in for wp-textbook suite
Version: 1.0.0
Author: Bonnie Souter
Author URI: http://zendgame.com
License: GPLv2

    Copyright 2015 Bonnie Souter  (email : bonnie@zendgame.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Only allow this script to be run within WordPress
defined('ABSPATH') or die("Unknown Access Error");

if ( defined( 'WPTB_CORE_VERSION' ) ) die('WPTB-Core Plugin version ' . WPTB_CORE_VERSION . ' is already running.');
define('WPTB_CORE_VERSION', '1.0.0');

// Are we debugging?
define('WPTB_DEBUG', TRUE );

define( 'WPTB_DIR_PATH' , trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WPTB_DIR_URL' , trailingslashit( plugins_url( '', __FILE__  ) ) );

/**
 * Gets the instance of the `WPTB_Core_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 */
function wptb_core_plugin() {
	return WPTB_Core_Plugin::get_instance();
}
require_once( WPTB_DIR_PATH . 'classes/wptb-core.php' );
wptb_core_plugin();
