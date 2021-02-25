<?php
/**
 * Plugin Name: Cookie Wow WordPress
 * Plugin URI: https://cookiewow.com/
 * Description:
 * Version: 1.0.0
 * Author: Cookie Wow
 * Author URI: https://cookiewow.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

function cookiewow_admin_init() {
	register_setting(
		$option_group = 'cookiewow_settings_fields',
		$option_name  = 'cookiewow_option',
		$args         = array( 'sanitize_callback' => 'cookiewow_sanitize_settings_fields' )
	);

	add_settings_section(
		$id       = 'setting_section_id',
		$title    = '',
		$callback = 'cookiewow_settings_section_description',
		$page     = 'cookiewow-settings'
	);

	add_settings_field(
		$id       = 'token',
		$title    = 'Token',
		$callback = 'cookiewow_settings_fields',
		$page     = 'cookiewow-settings',
		$section  = 'setting_section_id',
		$args     = null
	);
}

function cookiewow_admin_menu() {
	add_menu_page(
		$page_title = 'Cookie Wow Settings',
		$menu_title = 'Cookie Wow',
		$capability = 'manage_options',
		$menu_slug  = 'cookiewow-settings',
		$function   = 'cookiewow_settings_page',
		$icon_url   = 'dashicons-admin-plugins',
		$position   = '25'
	);
}

function cookiewow_admin_notices() {
	settings_errors();
}

function cookiewow_settings_fields() {
	$option = get_option( 'cookiewow_option' );
	printf(
		'<input type="text" id="token" name="cookiewow_option[token]" class="regular-text" value="%s" />',
		isset( $option['token'] ) ? esc_attr( $option['token']) : ''
	);
}

function cookiewow_settings_page() {
	require_once plugin_dir_path( __FILE__ ) . 'settings.php';
}

function cookiewow_sanitize_settings_fields( $fields ) {
	$sanitized_fields = array();

	if ( isset( $fields['token'] ) ) {
		$sanitized_fields['token'] = sanitize_text_field( ( $fields['token'] ) );
	}

	return $sanitized_fields;
}

function cookiewow_settings_section_description() {
}

add_action( 'admin_init', 'cookiewow_admin_init');
add_action( 'admin_menu', 'cookiewow_admin_menu' );
add_action( 'admin_notices', 'cookiewow_admin_notices');
