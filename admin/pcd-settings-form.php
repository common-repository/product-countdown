<?php
/**
 * Product countdown settings form
 */
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html('Product countdown Settings'); ?></h1>
	<?php if(isset($_POST['submit'])){		
		if ( ! isset( $_POST['pcd_settings'] )  
			|| ! wp_verify_nonce( $_POST['pcd_settings'], 'pcd_settings' ) ) 
		{ ?>
			<div class="updated notice-error">
				<p><?php echo esc_html('Something went wrong please try again.'); ?></p>
			</div>
		<?php } else { 
		   	$data = get_option('product-countdown-settings');
			$data['custom_class_listing'] = sanitize_text_field($_POST['custom_class_listing']);
			$data['custom_class_detail'] = sanitize_text_field($_POST['custom_class_detail']);
			$data['countdown_template'] = sanitize_text_field($_POST['countdown_template']);
			$data['template_color'] = sanitize_text_field($_POST['template_color']);
			update_option( 'product-countdown-settings', $data ); ?>
			<div class="updated notice-success">
				<p><?php echo esc_html('Data saved.'); ?></p>		
			</div>
			<?php 
		}
	}
	$data = get_option('product-countdown-settings'); ?>
	<form class="form" method="post" action="">
		<?php wp_nonce_field( 'pcd_settings', 'pcd_settings' ); ?>
		<div class="form__linput">
			<label class="form__label" class="form__label" for="custom_class_listing"><?php _e('Custom class for listing','product-countdown'); ?></label>
			<input type="text" name="custom_class_listing" id="custom_class_listing" class="custom_class_listing form__input" value="<?php echo esc_attr($data['custom_class_listing']); ?>">
		</div>
		<div class="form__linput">
			<label class="form__label" class="form__label" for="custom_class_detail"><?php _e('Custom class for detail page','product-countdown'); ?></label>
			<input type="text" name="custom_class_detail" id="custom_class_detail" class="custom_class_detail form__input" value="<?php echo esc_attr($data['custom_class_detail']); ?>">
		</div>
		<div class="form__linput">
			<label class="form__label" for="countdown_template"><?php _e('Countdown template','product-countdown'); ?></label>
			<select name="countdown_template" id="countdown_template" class="countdown_template form__input">
				<?php $countDownTempl = $data['countdown_template'];
				$selected1 = $selected2 = $selected3 = '';
				if($countDownTempl == 'template1'){
					$selected1 = "selected=selected";
				}elseif($countDownTempl == 'template2'){
					$selected2 = "selected=selected";
				}elseif($countDownTempl == 'template3'){
					$selected3 = "selected=selected";
				} ?>
				<option value="template1" <?php echo esc_attr($selected1); ?> ><?php _e('Template 1','product-countdown'); ?></option>
				<option value="template2" <?php echo esc_attr($selected2); ?> ><?php _e('Template 2','product-countdown'); ?></option>
				<option value="template3" <?php echo esc_attr($selected3); ?> ><?php _e('Template 3','product-countdown'); ?></option>
			</select>
		</div>
		<div class="form__linput template-color">
			<label class="form__label" class="form__label" for="template_color"><?php _e('Circle color','product-countdown'); ?> <span>
				<img src="<?php echo esc_url( PCD_URL .'/admin/images/i.png'); ?>" title="<?php echo esc_attr( __('Enter the color name/code Eg.: green, red, #FFFFFF, #000000','product-countdown') ); ?>"></span></label>
			<input type="text" name="template_color" id="template_color" class="template_color form__input" value="<?php echo esc_attr($data['template_color']); ?>">
		</div>
		<div class="form__linput">
			<input type="submit" name="submit" id="submit" class="submit primary-button form__button" value="<?php echo esc_attr( __('Save','product-countdown') ); ?>">
		</div>
	</form>
</div>