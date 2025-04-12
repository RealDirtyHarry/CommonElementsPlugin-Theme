<?php
/**
 * Membership Billing Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-billing-container">
    <div class="ce-membership-billing-wrapper">
        <h1 class="ce-membership-billing-title"><?php _e('Billing Information', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : 
            $current_user = wp_get_current_user();
            $billing_first_name = get_user_meta($current_user->ID, 'billing_first_name', true);
            $billing_last_name = get_user_meta($current_user->ID, 'billing_last_name', true);
            $billing_company = get_user_meta($current_user->ID, 'billing_company', true);
            $billing_address_1 = get_user_meta($current_user->ID, 'billing_address_1', true);
            $billing_address_2 = get_user_meta($current_user->ID, 'billing_address_2', true);
            $billing_city = get_user_meta($current_user->ID, 'billing_city', true);
            $billing_state = get_user_meta($current_user->ID, 'billing_state', true);
            $billing_postcode = get_user_meta($current_user->ID, 'billing_postcode', true);
            $billing_country = get_user_meta($current_user->ID, 'billing_country', true);
            $billing_phone = get_user_meta($current_user->ID, 'billing_phone', true);
            $billing_email = get_user_meta($current_user->ID, 'billing_email', true) ?: $current_user->user_email;
        ?>
            <div class="ce-membership-billing-form">
                <form id="ce-membership-billing" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="billing_first_name"><?php _e('First Name', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_first_name" id="billing_first_name" value="<?php echo esc_attr($billing_first_name); ?>" required />
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="billing_last_name"><?php _e('Last Name', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_last_name" id="billing_last_name" value="<?php echo esc_attr($billing_last_name); ?>" required />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="billing_company"><?php _e('Company Name', 'common-elements-platform'); ?></label>
                        <input type="text" name="billing_company" id="billing_company" value="<?php echo esc_attr($billing_company); ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="billing_address_1"><?php _e('Address Line 1', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr($billing_address_1); ?>" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="billing_address_2"><?php _e('Address Line 2', 'common-elements-platform'); ?></label>
                        <input type="text" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr($billing_address_2); ?>" />
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="billing_city"><?php _e('City', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_city" id="billing_city" value="<?php echo esc_attr($billing_city); ?>" required />
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="billing_state"><?php _e('State/Province', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_state" id="billing_state" value="<?php echo esc_attr($billing_state); ?>" required />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="billing_postcode"><?php _e('Postal Code', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_postcode" id="billing_postcode" value="<?php echo esc_attr($billing_postcode); ?>" required />
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="billing_country"><?php _e('Country', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="text" name="billing_country" id="billing_country" value="<?php echo esc_attr($billing_country); ?>" required />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="billing_phone"><?php _e('Phone', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="tel" name="billing_phone" id="billing_phone" value="<?php echo esc_attr($billing_phone); ?>" required />
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="billing_email"><?php _e('Email', 'common-elements-platform'); ?> <span class="required">*</span></label>
                            <input type="email" name="billing_email" id="billing_email" value="<?php echo esc_attr($billing_email); ?>" required />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" name="action" value="ce_update_billing" />
                        <?php wp_nonce_field('ce_update_billing_nonce', 'ce_billing_nonce'); ?>
                        <button type="submit" class="ce-button ce-button-primary"><?php _e('Update Billing Information', 'common-elements-platform'); ?></button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="ce-membership-login-required">
                <p><?php _e('Please log in to view your billing information.', 'common-elements-platform'); ?></p>
                <?php wp_login_form(array('redirect' => get_permalink())); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
