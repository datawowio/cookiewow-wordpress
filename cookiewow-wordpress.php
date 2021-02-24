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

function cookiewow_admin_init() {
	register_setting( 'cookiewow_settings_fields', 'cookiewow_option' );

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

function cookiewow_settings_fields() {
	$options = get_option( 'cookiewow_option' );
	printf(
		'<input type="text" id="token" name="cookiewow_option[token]" class="regular-text" value="%s" />',
		isset( $options['token'] ) ? esc_attr( $options['token']) : ''
	);
}

function cookiewow_settings_page() {
	require_once plugin_dir_path( __FILE__ ) . 'settings.php';
}

function cookiewow_settings_section_description() {
}

add_action( 'admin_menu', 'cookiewow_admin_menu' );
add_action( 'admin_init', 'cookiewow_admin_init');
