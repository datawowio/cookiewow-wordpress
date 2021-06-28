<?php
/**
 * Cookie Wow Banner
 *
 * @package cookiewow-banner
 *
 * @wordpress-plugin
 * Plugin Name: Cookie Wow Banner
 * Plugin URI:  https://github.com/datawowio/cookiewow-wordpress
 * Description: An easy way to manage cookie consent on web pages.
 * Version:     1.1.3
 * Author:      Cookie Wow
 * Author URI:  https://cookiewow.com/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

define( 'WP_COOKIEWOW_SLUG', 'cookiewow-settings' );
define( 'WP_COOKIEWOW_FILE', __FILE__ );

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

	add_settings_section( $id, $title, $callback, WP_COOKIEWOW_SLUG );

	$id       = 'cookiewow_token';
	$title    = 'Cookie Banner ID';
	$callback = 'cookiewow_settings_fields';
	$section  = 'cookiewow_setting_section_id';
	$args     = null;
	add_settings_field( $id, $title, $callback, WP_COOKIEWOW_SLUG, $section, $args );
}

/**
 * Add admin menu.
 */
function cookiewow_admin_menu () {
	$parent_slug = 'options-general.php';
	$page_title  = 'Cookie Wow Settings';
	$menu_title  = 'Cookie Wow';
	$capability  = 'manage_options';
	$function    = 'cookiewow_settings_page';

	add_submenu_page($parent_slug, $page_title, $menu_title, $capability, WP_COOKIEWOW_SLUG, $function);
}

/**
 * Admin menu icon.
 */
function cookiewow_admin_menu_icon() {
	$file_contents = file_get_contents( plugin_dir_path( __FILE__ ) . 'static/images/icon-cookiewow.b64' );
	return "data:image/svg+xml;base64,$file_contents";
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
 * Link to the configuration page of the plugin & documentation
 */
function cookiewow_settings_action_links( $actions ) {
	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'https://help.cookiewow.com/th/?utm_source=wp_plugin&utm_medium=wp_cookiewow', __( 'Docs', 'cookiewow' ) ) );

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=' . WP_COOKIEWOW_SLUG ), __( 'Settings', 'cookiewow' ) ) );

	return $actions;
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
	$src          = 'https://cookiecdn.com/cwc.js';
	$dependencies = array();
	$version      = null;
	$in_footer    = false;
	wp_enqueue_script( $script_name, $src, $dependencies, $version, $in_footer );

	$token = esc_attr( $option['cookiewow_token'] );

	$script_name  = 'cookiewow_configs_script';
	$src          = "https://cookiecdn.com/configs/{$token}";
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
add_filter( 'plugin_action_links_' . plugin_basename( WP_COOKIEWOW_FILE ), 'cookiewow_settings_action_links' );
add_filter( 'script_loader_tag', 'cookiewow_script_loader_tag', $priority = 1, $accepted_args = 3 );
register_uninstall_hook( __FILE__, 'cookiewow_uninstall' );
