<?php
/**
 *
 * Admin menu for the product countdown plugin
 *
 * @link       https://indianic.com
 * @since      1.0.0
 *
 * @package    product-countdown
 * @subpackage product-countdown/admin
 */


/**
 * Admin menu hook
 * @since 1.0
 * */
add_action('admin_menu', 'pcd_setting_menu');
function pcd_setting_menu() { 
	add_menu_page( 
		__('Product countdown settings','product-countdown'), 
		__('Product countdown settings','product-countdown'), 
		'manage_options', 
		'pcd_menu_settings', 
		'pcd_setting_menu_callback_function', 
		'dashicons-hourglass' 
	);
}
/**
 * Admin menu product countdown settings callback function
 * @since 1.0
 * */
function pcd_setting_menu_callback_function(){
	include_once plugin_dir_path( __FILE__ ).'pcd-settings-form.php';
}