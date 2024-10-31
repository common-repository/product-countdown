<?php
/**
 * Plugin Name: Product countdown
 * Plugin URI: #
 * Description: Add product countdown on the product detail page and product listing page.
 * Version: 1.0.0
 * Author: MageINIC
 * Author URI: https://profiles.wordpress.org/wpteamindianic/#content-plugins
 * Text Domain: product-countdown
 * Domain Path: languages/
 * Requires at least: 5.8
 * Requires PHP: 7.2
 *
 * @package product-countdown
 */

defined( 'ABSPATH' ) || exit;
define('PCD_URL', plugin_dir_url(__FILE__));
define('PCD_PUBLIC_URL', PCD_URL . 'public/');

/**
 * Init Hook for plugin
 * @since 1.0
 * */
add_action( 'init', 'pcd_init' );
function pcd_init() {
    include_once plugin_dir_path( __FILE__ ).'admin/admin-menu.php';
    include_once plugin_dir_path( __FILE__ ).'admin/admin-settings.php';
    include_once plugin_dir_path( __FILE__ ).'public/frontside.php';
}
/**
 * Activation Hook
 * @since 1.0
 * */
register_activation_hook( __FILE__, 'pcd_flush_rewrites' );
function pcd_flush_rewrites() {
    //activate_pcd();
}
/**
 * Uninstall Hook
 * @since 1.0
 * */
register_uninstall_hook( __FILE__, 'pcd_uninstall' );
function pcd_uninstall() {  
}