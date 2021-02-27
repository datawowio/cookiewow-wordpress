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
 * Enqueue scripts to WordPress.
 */
function cookiewow_enqueue_scripts() {
	$option = get_option( 'cookiewow_option' );

	if ( ! isset( $option['cookiewow_token'] )
		|| '' === trim( $option['cookiewow_token'] ) ) {
		return;
	}

	$script_name  = 'cookiewow_script';
	$src          = 'https://script.cookiewow.com/cwc.js';
	$dependencies = array();
	$version      = null;
	$in_footer    = false;
	wp_enqueue_script( $script_name, $src, $dependencies, $version, $in_footer );

	$token = esc_attr( $option['cookiewow_token'] );

	$script_name  = 'cookiewow_configs_script';
	$src          = "https://script.cookiewow.com/configs/{$token}";
	$dependencies = array();
	$version      = null;
	$in_footer    = false;
	wp_enqueue_script( $script_name, $src, $dependencies, $version, $in_footer );
}

/**
 * To replace the default ID that generated by WordPress when enqueued script
 * and to add data-cwcid.
 *
 * @param string $tag The <script> tag for the enqueued script.
 * @param string $script_name The script's name that registered handle.
 * @param string $src The script's source URL..
 * @return string The $tag that has been modified.
 */
function cookiewow_script_loader_tag( $tag, $script_name, $src ) {
	if ( 'cookiewow_configs_script' === $script_name ) {
		$option = get_option( 'cookiewow_option' );
		$token  = esc_attr( $option['cookiewow_token'] );

		$replace_at_position = strpos( $tag, 'src' );
		$replace_to_position = -1;
		return substr_replace(
			$tag,
			"id='cookieWow' type='text/javascript' src='$src' data-cwcid='$token'></script>",
			$replace_at_position,
			$replace_to_position
		);
	}

	return $tag;
}

add_action( 'admin_init', 'cookiewow_admin_init' );
add_action( 'admin_menu', 'cookiewow_admin_menu' );
add_action( 'admin_notices', 'cookiewow_admin_notices' );
add_action( 'wp_enqueue_scripts', 'cookiewow_enqueue_scripts' );
add_filter( 'script_loader_tag', 'cookiewow_script_loader_tag', $priority = 1, $accepted_args = 3 );
register_uninstall_hook( __FILE__, 'cookiewow_uninstall' );
