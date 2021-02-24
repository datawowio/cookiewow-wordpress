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
		$page_title = __( 'Cookie Wow', 'cookiewow' ),
		$menu_title = __( 'Cookie Wow', 'cookiewow' ),
		$capability = 'manage_options',
		$menu_slug  = '#',
		$function   = null,
		$icon_url   = null,
		$position   = '25'
	);
}

add_action ( 'admin_menu', 'cookiewow_admin_menu' );
