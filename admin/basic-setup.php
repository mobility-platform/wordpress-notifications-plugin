<?php 
/**
 * Basic setup functions for the plugin
 *
 * @since 1.0
 * @function	mpn_activate_plugin()		Plugin activatation todo list
 * @function	mpn_load_plugin_textdomain()	Load plugin text domain
 * @function	mpn_settings_link()			Print direct link to plugin settings in plugins list in admin
 * @function	mpn_plugin_row_meta()		Add donate and other links to plugins list
 * @function	mpn_footer_text()			Admin footer text
 * @function	mpn_footer_version()			Admin footer version
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
 
/**
 * Plugin activatation todo list
 *
 * This function runs when user activates the plugin. Used in register_activation_hook in the main plugin file. 
 * @since 1.0
 */
function mpn_activate_plugin() {
	
}

/**
 * Load plugin text domain
 *
 * @since 1.0
 */
function mpn_load_plugin_textdomain() {
    load_plugin_textdomain( 'mobility-platform-notifications-plugin', false, '/mobility-platform-notifications-plugin/languages/' );
}
add_action( 'plugins_loaded', 'mpn_load_plugin_textdomain' );

/**
 * Print direct link to plugin settings in plugins list in admin
 *
 * @since 1.0
 */
function mpn_settings_link( $links ) {
	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=mobility-platform-notifications-plugin' ) . '">' . __( 'Settings', 'mobility-platform-notifications-plugin' ) . '</a>'
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . MPN_MOBILITY_PLATFORM_NOTIFICATIONS_PLUGIN . '/mpn_mobility-platform-notifications-plugin.php', 'mpn_settings_link' );

/**
 * Add donate and other links to plugins list
 *
 * @since 1.0
 */
function mpn_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'mpn_mobility-platform-notifications-plugin.php' ) !== false ) {
		$new_links = array(
				'donate' 	=> '<a href="http://millionclues.com/donate/" target="_blank">Donate</a>',
				'kuttappi' 	=> '<a href="http://kuttappi.com/" target="_blank">My Travelogue</a>',
				'hireme' 	=> '<a href="http://millionclues.com/portfolio/" target="_blank">Hire Me For A Project</a>',
				);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'mpn_plugin_row_meta', 10, 2 );

/**
 * Admin footer text
 *
 * A function to add footer text to the settings page of the plugin. Footer text contains plugin rating and donation links.
 * Note: Remove the rating link if the plugin doesn't have a WordPress.org directory listing yet. (i.e. before initial approval)
 *
 * @since 1.0
 * @refer https://codex.wordpress.org/Function_Reference/get_current_screen
 */
function mpn_footer_text($default) {
    
	// Retun default on non-plugin pages
	$screen = get_current_screen();
	if ( $screen->id !== "settings_page_mobility-platform-notifications-plugin" ) {
		return $default;
	}
	
    $mpn_footer_text = sprintf( __( 'If you like this plugin, please <a href="%s" target="_blank">make a donation</a> or leave me a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating to support continued development. Thanks a bunch!', 'mobility-platform-notifications-plugin' ), 
								'http://millionclues.com/donate/',
								'https://wordpress.org/support/plugin/mobility-platform-notifications-plugin/reviews/?rate=5#new-post' 
						);
	
	return $mpn_footer_text;
}
add_filter('admin_footer_text', 'mpn_footer_text');

/**
 * Admin footer version
 *
 * @since 1.0
 */
function mpn_footer_version($default) {
	
	// Retun default on non-plugin pages
	$screen = get_current_screen();
	if ( $screen->id !== 'settings_page_mobility-platform-notifications-plugin' ) {
		return $default;
	}
	
	return 'Plugin version ' . MPN_VERSION_NUM;
}
add_filter( 'update_footer', 'mpn_footer_version', 11 );