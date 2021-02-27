<?php
/**
 * Cookie Wow WordPress
 *
 * @package cookiewow-wordpress
 *
 * @wordpress-plugin
 * Plugin Name: Cookie Wow WordPress
 * Plugin URI:  https://cookiewow.com/
 * Description:
 * Version:     1.0.0
 * Author:      Cookie Wow
 * Author URI:  https://cookiewow.com/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Initialize admin settings.
 */
function cookiewow_admin_init() {
	$option_group = 'cookiewow_settings_fields';
	$option_name  = 'cookiewow_option';
	$args         = array( 'sanitize_callback' => 'cookiewow_sanitize_settings_fields' );
	register_setting( $option_group, $option_name, $args );

	$id       = 'cookiewow_setting_section_id';
	$title    = '';
	$callback = 'cookiewow_settings_section_description';
	$page     = 'cookiewow-settings';
	add_settings_section( $id, $title, $callback, $page );

	$id       = 'cookiewow_token';
	$title    = 'Token';
	$callback = 'cookiewow_settings_fields';
	$page     = 'cookiewow-settings';
	$section  = 'cookiewow_setting_section_id';
	$args     = null;
	add_settings_field( $id, $title, $callback, $page, $section, $args );
}

/**
 * Add admin menu.
 */
function cookiewow_admin_menu() {
	$page_title = 'Cookie Wow Settings';
	$menu_title = 'Cookie Wow';
	$capability = 'manage_options';
	$menu_slug  = 'cookiewow-settings';
	$function   = 'cookiewow_settings_page';
	$icon_url   = 'dashicons-admin-plugins';
	$position   = '25';
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

/**
 * Display a notification when an error occurred in updating settings.
 */
function cookiewow_admin_notices() {
	settings_errors();
}

/**
 * Display admin settings fields.
 */
function cookiewow_settings_fields() {
	$option = get_option( 'cookiewow_option' );
	printf(
		'<input type="text" id="cookiewow_token" name="cookiewow_option[cookiewow_token]" class="regular-text" value="%s" />',
		isset( $option['cookiewow_token'] ) ? esc_attr( $option['cookiewow_token'] ) : ''
	);
}

/**
 * Display admin settings form.
 */
function cookiewow_settings_page() {
	require_once plugin_dir_path( __FILE__ ) . 'settings.php';
}

/**
 * Sanitize the setting fields before updating.
 *
 * @param string[] $fields The admin settings fields.
 */
function cookiewow_sanitize_settings_fields( $fields ) {
	$sanitized_fields = array();

	if ( isset( $fields['cookiewow_token'] ) ) {
		$sanitized_fields['cookiewow_token'] = sanitize_text_field( ( $fields['cookiewow_token'] ) );
	}

	return $sanitized_fields;
}

/**
 * Display description for admin settings form.
 */
function cookiewow_settings_section_description() {
}

/**
 * Uninstall the plugin.
 */
function cookiewow_uninstall() {
	delete_option( 'cookiewow_option' );
}

/**
 * Add JavaScript tag to <head>.
 */
function cookiewow_wp_head() {
	$option = get_option( 'cookiewow_option' );

	if ( ! isset( $option['cookiewow_token'] )
		|| '' === trim( $option['cookiewow_token'] ) ) {
		return;
	}

	$token       = esc_attr( $option['cookiewow_token'] );
	$script_path = 'https://script.cookiewow.com/cwc.js';
	$config_path = "https://script.cookiewow.com/configs/{$token}";

	echo sprintf('<!-- Cookie Consent by https://www.cookiewow.com -->
		<script type="text/javascript" src="%s"></script>
		<script id="cookieWow" type="text/javascript" src="%s" data-cwcid="%s"></script>', $script_path, $config_path, $token );
}

add_action( 'admin_init', 'cookiewow_admin_init' );
add_action( 'admin_menu', 'cookiewow_admin_menu' );
add_action( 'admin_notices', 'cookiewow_admin_notices' );
add_action( 'wp_head', 'cookiewow_wp_head', $priority = 1 );
register_uninstall_hook( __FILE__, 'cookiewow_uninstall' );
