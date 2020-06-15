<?php

/**
 * Admin setup for the plugin
 *
 * @since 1.0
 * @function	mpn_add_menu_links()		Add admin menu pages
 * @function	mpn_register_settings	Register Settings
 * @function	mpn_validater_and_sanitizer()	Validate And Sanitize User Input Before Its Saved To Database
 * @function	mpn_get_settings()		Get settings from database
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Add admin menu pages
 *
 * @since 1.0
 * @refer https://developer.wordpress.org/plugins/administration-menus/
 */
function mpn_add_menu_links()
{
	add_options_page(__('Mobility Platform Notifications', 'mobility-platform-notifications-plugin'), __('Mobility Platform Notifications', 'mobility-platform-notifications-plugin'), 'update_core', 'mobility-platform-notifications-plugin', 'mpn_admin_interface_render');
}
add_action('admin_menu', 'mpn_add_menu_links');

/**
 * Register Settings
 *
 * @since 1.0
 */
function mpn_register_settings()
{

	// Register Setting
	register_setting(
		'mpn_settings_group', 			// Group name
		'mpn_settings', 				// Setting name = html form <input> name on settings form
		'mpn_validater_and_sanitizer'	// Input sanitizer
	);

	// Register A New Section
	add_settings_section(
		'mpn_auth0_settings_section',							// ID
		__('Auth0 Settings', 'mobility-platform-notifications-plugin'),		// Title
		'mpn_auth0_settings_section_callback',					// Callback Function
		'mobility-platform-notifications-plugin'											// Page slug
	);

	// General Settings
	add_settings_field(
		'mpn_auth0_settings_field_client_id',							// ID
		__('Client ID', 'mobility-platform-notifications-plugin'),					// Title
		'mpn_auth0_settings_field_client_id_callback',					// Callback function
		'mobility-platform-notifications-plugin',											// Page slug
		'mpn_auth0_settings_section'							// Settings Section ID
	);

	add_settings_field(
		'mpn_auth0_settings_field_client_secret',							// ID
		__('Client Secret', 'mobility-platform-notifications-plugin'),					// Title
		'mpn_auth0_settings_field_client_secret_callback',					// Callback function
		'mobility-platform-notifications-plugin',											// Page slug
		'mpn_auth0_settings_section'							// Settings Section ID
	);
}
add_action('admin_init', 'mpn_register_settings');

/**
 * Validate and sanitize user input before its saved to database
 *
 * @since 1.0
 */
function mpn_validater_and_sanitizer($settings)
{

	// Sanitize text field
	$settings['text_input'] = sanitize_text_field($settings['text_input']);

	return $settings;
}

/**
 * Get settings from database
 *
 * @return	Array	A merged array of default and settings saved in database. 
 *
 * @since 1.0
 */
function mpn_get_settings()
{

	$defaults = array(
		'setting_one' 	=> '1',
		'setting_two' 	=> '1',
	);

	$settings = get_option('mpn_settings', $defaults);

	return $settings;
}

/**
 * Enqueue Admin CSS and JS
 *
 * @since 1.0
 */
function mpn_enqueue_css_js($hook)
{

	// Load only on Starer Plugin plugin pages
	if ($hook != "settings_page_mobility-platform-notifications-plugin") {
		return;
	}

	// Main CSS
	// wp_enqueue_style( 'mpn-admin-main-css', MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_URL . 'admin/css/main.css', '', MPN_VERSION_NUM );

	// Main JS
	// wp_enqueue_script( 'mpn-admin-main-js', MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN_URL . 'admin/js/main.js', array( 'jquery' ), false, true );
}
add_action('admin_enqueue_scripts', 'mpn_enqueue_css_js');
