<?php
/**
 * Add Count down in product listing page.
 *
 * @link       https://profiles.wordpress.org/wpteamindianic/#content-plugins
 * @since      1.0.0
 *
 * @package    product-countdown
 * @subpackage product-countdown/public
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'pcd_replace_default_button', 10, 2 );
function pcd_replace_default_button( $button, $product ){
    if ( $product->get_meta('product-countdown')){
        $countdowntime = $product->get_meta('product-countdown');
        $currentdate = strtotime(date('Y-m-d H:i:s'));
        $countdowntimedate = strtotime($product->get_meta('product-countdown'));
        $data = get_option('product-countdown-settings');
        if(ceil((($countdowntimedate))-(($currentdate))) > 0){
            $daysText = __("Days","product-countdown");
            $hoursText = __("Hours","product-countdown");
            $minsText = __("Mins","product-countdown");
            $secsText = __("Secs","product-countdown");
            if($data['countdown_template'] == 'template3'){
               $button = '<div class="countdown '.esc_attr($data['custom_class_listing']).'" data-time="'.esc_attr(ceil((($countdowntimedate))-(($currentdate)))).'"> <div class="tiles"></div> <div class="labels"> <ul><li>'.esc_html($daysText).'</li> <li>'.esc_html($hoursText).'</li> <li>'.esc_html($minsText).'</li> <li>'.esc_html($secsText).'</li></ul> </div> </div>';
            } else if ($data['countdown_template'] == 'template2'){
                $coundownDate = date('Y-m-d H:i:s',strtotime($product->get_meta('product-countdown')));
                $button = '<time class="countdown '.esc_attr($data['custom_class_listing']).'" date-time="'.esc_attr($coundownDate).'" style="--accent: '.esc_attr((($data['template_color'] != '') ? $data['template_color'] : 'green')).'"></time>';
            } else {
               $button = '<div class="countdown '.esc_attr($data['custom_class_listing']).'" data-time="'.esc_attr(ceil((($countdowntimedate))-(($currentdate)))).'"> <div class="tiles"></div> <div class="labels"> <ul><li>'.esc_html($daysText).'</li> <li>'.esc_html($hoursText).'</li> <li>'.esc_html($minsText).'</li> <li>'.esc_html($secsText).'</li></ul> </div> </div>';
            }
        }else{
            $button = $button;
        }
    }
    return $button;
}
/**
 * Add Count down in product detail page.
 *
 *
 * @since       1.0.0
 * @param       string    $plugin_name      Product countdown.
 * @param       string    $version          1.0.0.
 * */
add_action( 'woocommerce_single_product_summary', 'pcd_single_product_summary_callback', 1 );
function pcd_single_product_summary_callback() {
    global $product;
     if ( $product->get_meta('product-countdown')){
        $date = new DateTime();
        $countdowntime = $product->get_meta('product-countdown');
        $currentdate = strtotime(date('Y-m-d H:i:s'));
        $countdowntimedate = strtotime($product->get_meta('product-countdown'));
        if(ceil((($countdowntimedate))-(($currentdate))) > 0){
            if( $product->is_type( 'variable' ) ) {
                remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
                add_action( 'woocommerce_single_variation', 'pcd_add_to_cart_replacement_button', 20 );
            } else {
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                add_action( 'woocommerce_single_product_summary', 'pcd_add_to_cart_replacement_button', 30 );
            }
        }
    }
}
function pcd_add_to_cart_replacement_button(){
    $pcd_button = '';
    global $product;
    $id = $product->get_id();
    $countdowntime = $product->get_meta('product-countdown');
    $countdowntitle = $product->get_meta('product-countdown-title');
    $data = get_option('product-countdown-settings');
    if($countdowntitle){
        $pcd_button .= '<h5 class="countdownfronttitle" id="countdownfronttitle">'.wp_kses_post($countdowntitle).'</h5>';
    }
    $daysText = __("Days","product-countdown");
    $hoursText = __("Hours","product-countdown");
    $minsText = __("Mins","product-countdown");
    $secsText = __("Secs","product-countdown");
    if($data['countdown_template'] == 'template3'){
        $currentdate = strtotime(date('Y-m-d H:i:s'));
        $countdowntimedate = strtotime($product->get_meta('product-countdown'));
        $pcd_button .= '<div class="countdown '.esc_attr($data['custom_class_detail']).'" data-time="'.esc_attr(ceil((($countdowntimedate))-(($currentdate)))).'">';
            $pcd_button .= '<div class="tiles"></div>';
            $pcd_button .= '<div class="labels">';
                $pcd_button .= '<li>'.esc_html($daysText).'</li>';
                $pcd_button .= '<li>'.esc_html($hoursText).'</li>';
                $pcd_button .= '<li>'.esc_html($minsText).'</li>';
                $pcd_button .= '<li>'.esc_html($secsText).'</li>';
            $pcd_button .= '</div>';
        $pcd_button .= '</div>';
    } else if ($data['countdown_template'] == 'template2'){
        $coundownDate = date('Y-m-d H:i:s',strtotime($product->get_meta('product-countdown')));
        $pcd_button .= '<time class="countdown '.esc_attr($data['custom_class_detail']).'" date-time="'.esc_attr($coundownDate).'" style="--accent: '.esc_attr((($data['template_color'] != '')?$data['template_color']:'green')).'"></time>';
    } else {
        $currentdate = strtotime(date('Y-m-d H:i:s'));
        $countdowntimedate = strtotime($product->get_meta('product-countdown'));
        $pcd_button .= '<div class="countdown '.esc_attr($data['custom_class_detail']).'" data-time="'.esc_attr(ceil((($countdowntimedate))-(($currentdate)))).'">';
            $pcd_button .= '<div class="tiles"></div>';
            $pcd_button .= '<div class="labels">';
                $pcd_button .= '<li>'.esc_html($daysText).'</li>';
                $pcd_button .= '<li>'.esc_html($hoursText).'</li>';
                $pcd_button .= '<li>'.esc_html($minsText).'</li>';
                $pcd_button .= '<li>'.esc_html($secsText).'</li>';
            $pcd_button .= '</div>';
        $pcd_button .= '</div>';
    }
    echo $pcd_button;
}
/**
 * Add CSS and JS to Admin side
 *
 * @since       1.0.0
 * @param       string    $plugin_name      Product countdown.
 * @param       string    $version          1.0.0.
 * */
function pcd_add_front_jscss(){
    $data = get_option('product-countdown-settings');    
    if($data['countdown_template'] == 'template3'){
        wp_enqueue_style('template1',PCD_URL . '/public/css/template3.css');
        wp_enqueue_script('template1',PCD_URL . '/public/js/template3.js',array('jquery'), false, true);
    } else if ($data['countdown_template'] == 'template2'){
        wp_enqueue_style('template2',PCD_URL . '/public/css/template2.css');
        wp_enqueue_script('template2',PCD_URL . '/public/js/template2.js',array('jquery'), false, true);
        $date_time = new DateTime('now');
        $tz = 'GMT'.$date_time->format('P');
        wp_localize_script( 'template2', 'template2_object',
            array( 
                'obj1' => $tz
            )
        );
    } else {
        wp_enqueue_style('template1',PCD_URL . '/public/css/template1.css');
        wp_enqueue_script('template1',PCD_URL . '/public/js/template1.js',array('jquery'), false, true);
    }
}
add_action('wp_enqueue_scripts','pcd_add_front_jscss');