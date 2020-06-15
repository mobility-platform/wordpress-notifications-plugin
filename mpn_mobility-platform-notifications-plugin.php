<?php
/**
 * Plugin Name: Mobility Platform Notifications
 * Plugin URI: https://github.com/mobility-platform/wordpress-notifications-plugin
 * Description: WordPress plugin to create notifications for new publications
 * Author: BECOMS
 * Author URI: https://becoms.tech
 * Version: 1.0
 * Text Domain: mobility-platform-notifications-plugin
 * Domain Path: /languages
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * This plugin was developed using the WordPress starter plugin template by Arun Basil Lal <arunbasillal@gmail.com>
 * Please leave this credit and the directory structure intact for future developers who might read the code.
 * @GitHub https://github.com/arunbasillal/WordPress-Starter-Plugin
 */
 
/**
 * ~ Directory Structure ~
 *
 * /admin/ 						- Plugin backend stuff.
 * /functions/					- Functions and plugin operations.
 * index.php					- Dummy file.
 * license.txt					- GPL v2
 * mpn_mobility-platform-notifications-plugin.php	- Main plugin file containing plugin name and other version info for WordPress.
 * readme.txt					- Readme for WordPress plugin repository. https://wordpress.org/plugins/files/2018/01/readme.txt
 * uninstall.php				- Fired when the plugin is uninstalled. 
 */
 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Define constants
 *
 * @since 1.0
 */
if ( ! defined( 'MPN_VERSION_NUM' ) ) 		define( 'MPN_VERSION_NUM'		, '1.0' ); // Plugin version constant
if ( ! defined( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN' ) )		define( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN'		, trim( dirname( plugin_basename( __FILE__ ) ), '/' ) ); // Name of the plugin folder eg - 'mobility-platform-notifications-plugin'
if ( ! defined( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_DIR' ) )	define( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_DIR'	, plugin_dir_path( __FILE__ ) ); // Plugin directory absolute path with the trailing slash. Useful for using with includes eg - /var/www/html/wp-content/plugins/mobility-platform-notifications-plugin/
if ( ! defined( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_URL' ) )	define( 'MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_URL'	, plugin_dir_url( __FILE__ ) ); // URL to the plugin folder with the trailing slash. Useful for referencing src eg - http://localhost/wp/wp-content/plugins/mobility-platform-notifications-plugin/

/**
 * Add plugin version to database
 *
 * @refer https://codex.wordpress.org/Creating_Tables_with_Plugins#Adding_an_Upgrade_Function
 * @since 1.0
 */
update_option( 'abl_mpn_version', MPN_VERSION_NUM );	// Change this to add_option if a release needs to check installed version.

// Load everything
require_once( MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_DIR . 'loader.php' );

// Register activation hook (this has to be in the main plugin file or refer bit.ly/2qMbn2O)
register_activation_hook( __FILE__, 'mpn_activate_plugin' );