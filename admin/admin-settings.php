<?php
/**
 * Provide a admin area view for the plugin
 *
 * Change product countdown settings
 *
 * @link       https://profiles.wordpress.org/wpteamindianic/#content-plugins
 * @since      1.0.0
 *
 * @package    product-countdown
 * @subpackage product-countdown/admin
 */
/**
 * Add meta-box for product countdown.
 *
 * @since       1.0.0
 * @param       string    $plugin_name      Product countdown.
 * @param       string    $version          1.0.0.
 */
add_action( 'add_meta_boxes', 'pcd_meta_box' );
function pcd_meta_box() {
    add_meta_box(
        'product-countdown-sec',
        __( 'Product countdown', 'product-countdown' ),
        'pcd_meta_box_callback',
        'product',
        'side'
    );
}
/**
 * Callback function for meta-box.
 *
 * @since       1.0.0
 * @param       string    $plugin_name      Product countdown.
 * @param       string    $version          1.0.0.
 */
function pcd_meta_box_callback(){    
    global $post;
    $postId = $post->ID;
    $product_countdown_title = get_post_meta($postId, 'product-countdown-title', true);
    $pdc = get_post_meta($postId, 'product-countdown', true);
    $product_countdown = (!empty($pdc) && ($pdc != '')) ? $pdc : '';
    $product_countdown_timezone = get_post_meta($postId, 'product-countdown-local-timezone', true); ?>
    <p>
        <label for="product-countdown">
            <input type="text" id="product-countdown-title" name="product-countdown-title" value="<?php echo esc_attr($product_countdown_title); ?>" placeholder="<?php echo esc_attr( __( 'Enter product countdown title', 'product-countdown' ) ); ?>">
        </label>
    </p>
    <p>
        <label for="product-countdown">
            <input type="hidden" id="product-countdown-local-timezone" name="product-countdown-local-timezone" value="">
            <input type="hidden" id="product-countdown-default" name="product-countdown-default" value="<?php echo esc_attr($product_countdown); ?>">
            <input type="text" id="product-countdown" name="product-countdown" value="<?php echo esc_attr($product_countdown); ?>" placeholder="<?php echo esc_attr( __( 'yyyy/mm/dd HH:ii', 'product_countdown' ) ); ?>">
        </label>
    </p>
    <?php
}
/**
 * Save product countdown value as post-meta.
 *
 * @since           1.0.0
 * @param       string    $plugin_name          WooCommerce coming soon.
 * @param       string    $version                  1.0.0.
 */
add_action( 'save_post', 'pcd_save_meta_box' );
function pcd_save_meta_box( $post_id ) {
    if ( ! isset( $_POST['woocommerce_meta_nonce'] ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( isset( $_POST['post_type'] ) && ('product' === $_POST['post_type']) ) {
        if($_POST['product-countdown']){
            $default_server_timezone = date_default_timezone_get();            
            $product_countdown_timezone = sanitize_text_field($_POST['product-countdown-local-timezone']);
            date_default_timezone_set($product_countdown_timezone);
            $product_countdown = sanitize_text_field(strtotime($_POST['product-countdown']));
            $product_countdown_title = sanitize_text_field($_POST['product-countdown-title']);
            date_default_timezone_set("UTC");
            $product_countdown = date('Y/m/d H:i:s',$product_countdown);
            update_post_meta($post_id,'product-countdown-title',$product_countdown_title);
            update_post_meta($post_id,'product-countdown', $product_countdown);
            date_default_timezone_set($default_server_timezone);
        }else{
            update_post_meta($post_id,'product-countdown-title','');
            update_post_meta($post_id,'product-countdown',0);
        }
    }
}
/**
 * Add CSS and JS to Admin side
 *
 * @since       1.0.0
 * @param       string    $plugin_name      Product countdown.
 * @param       string    $version          1.0.0.
 * */
function pcd_add_admin_jscss(){
    $screen = get_current_screen();
    $pcd_screen = 'post';
    if( is_object( $screen ) && (($pcd_screen == $screen->base)) ) {
        wp_enqueue_style('pcd-datetimepicker-css',PCD_URL . '/admin/css/datetimepicker.css');
        wp_enqueue_script('pcd-datetimepicker-js',PCD_URL . '/admin/js/datetimepicker.js',array('jquery'), false, true);        
    }
    $pcd_screen = 'toplevel_page_pcd_menu_settings';
    if( is_object( $screen ) && (($pcd_screen == $screen->base)) ) {
        wp_enqueue_style('pcd-simple-wp-smtp-open-props-css',PCD_URL . '/admin/css/open-props.css');
        wp_enqueue_style('pcd-simple-wp-smtpforms-js',PCD_URL . '/admin/css/forms.css');        
    }
    wp_enqueue_script('pcd-admin-js',PCD_URL . '/admin/js/admin.js',array('jquery'), false, true);
}
add_action('admin_enqueue_scripts','pcd_add_admin_jscss');