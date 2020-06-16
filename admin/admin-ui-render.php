<?php

/**
 * Admin UI setup and render
 *
 * @since 1.0
 * @function	mpn_general_settings_section_callback()	Callback function for General Settings section
 * @function	mpn_general_settings_field_callback()	Callback function for General Settings field
 * @function	mpn_admin_interface_render()				Admin interface renderer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Callback function for Auth0 Settings section
 *
 * @since 1.0
 */
function mpn_auth0_settings_section_callback()
{
	echo '<p>' . __('Please register your application under Auth0 then complete the information below.', 'mobility-platform-notifications-plugin') . '</p>';
}

/**
 * Callback function for Notifications API Settings section
 *
 * @since 1.0
 */
function mpn_notifications_settings_section_callback()
{
	echo '<p>' . __('Enter the URL of the Notifications API below. More informations at: https://mobility-platform-docs.netlify.app/', 'mobility-platform-notifications-plugin') . '</p>';
}

/**
 * Callback function for Client Id Settings field
 *
 * @since 1.0
 */
function mpn_auth0_settings_field_client_id_callback()
{
	$settings = mpn_get_settings();
?>
	<fieldset>
		<input type="text" name="mpn_settings[client_id]" class="regular-text" value="<?php if (isset($settings['client_id']) && (!empty($settings['client_id']))) echo esc_attr($settings['client_id']); ?>" />
	</fieldset>
<?php
}

/**
 * Callback function for Client Secret Settings field
 *
 * @since 1.0
 */
function mpn_auth0_settings_field_client_secret_callback()
{
	$settings = mpn_get_settings();
?>
	<fieldset>
		<input type="text" name="mpn_settings[client_secret]" class="regular-text" value="<?php if (isset($settings['client_secret']) && (!empty($settings['client_secret']))) echo esc_attr($settings['client_secret']); ?>" />
	</fieldset>
<?php
}

/**
 * Callback function for Domain Settings field
 *
 * @since 1.0
 */
function mpn_auth0_settings_field_domain_callback()
{
	$settings = mpn_get_settings();
?>
	<fieldset>
		<input type="text" name="mpn_settings[domain]" class="regular-text" value="<?php if (isset($settings['domain']) && (!empty($settings['domain']))) echo esc_attr($settings['domain']); ?>" />
	</fieldset>
<?php
}

/**
 * Callback function for Notifications API Settings field
 *
 * @since 1.0
 */
function mpn_notifications_settings_field_notifications_api_callback()
{
	$settings = mpn_get_settings();
?>
	<fieldset>
		<input type="text" name="mpn_settings[notifications_api]" class="regular-text" value="<?php if (isset($settings['notifications_api']) && (!empty($settings['notifications_api']))) echo esc_attr($settings['notifications_api']); ?>" />
	</fieldset>
<?php
}

/**
 * Admin interface renderer
 *
 * @since 1.0
 */
function mpn_admin_interface_render()
{

	if (!current_user_can('manage_options')) {
		return;
	}

	/**
	 * If settings are inside WP-Admin > Settings, then WordPress will automatically display Settings Saved. If not used this block
	 * @refer	https://core.trac.wordpress.org/ticket/31000
	 * If the user have submitted the settings, WordPress will add the "settings-updated" $_GET parameter to the url
	 *
	if ( isset( $_GET['settings-updated'] ) ) {
		// Add settings saved message with the class of "updated"
		add_settings_error( 'mpn_settings_saved_message', 'mpn_settings_saved_message', __( 'Settings are Saved', 'mobility-platform-notifications-plugin' ), 'updated' );
	}
 
	// Show Settings Saved Message
	settings_errors( 'mpn_settings_saved_message' ); */ ?>

	<div class="wrap">
		<h1>Mobility Platform Notifications</h1>

		<form action="options.php" method="post">
			<?php
			// Output nonce, action, and option_page fields for a settings page.
			settings_fields('mpn_settings_group');

			// Prints out all settings sections added to a particular settings page. 
			do_settings_sections('mobility-platform-notifications-plugin');	// Page slug

			// Output save settings button
			submit_button(__('Save Settings', 'mobility-platform-notifications-plugin'));
			?>
		</form>
	</div>
<?php
}
