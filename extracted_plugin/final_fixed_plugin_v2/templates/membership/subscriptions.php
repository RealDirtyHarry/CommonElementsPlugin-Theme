<?php
/**
 * Membership Subscriptions Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-subscriptions-container">
    <div class="ce-membership-subscriptions-wrapper">
        <h1 class="ce-membership-subscriptions-title"><?php _e('Your Subscriptions', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : 
            $current_user = wp_get_current_user();
            $membership_level = get_user_meta($current_user->ID, '_ce_membership_level', true);
            $membership_status = get_user_meta($current_user->ID, '_ce_membership_status', true);
            $membership_expiry = get_user_meta($current_user->ID, '_ce_membership_expiry', true);
            $membership_renewal = get_user_meta($current_user->ID, '_ce_membership_renewal', true);
            $membership_plan_id = get_user_meta($current_user->ID, '_ce_membership_plan_id', true);
            
            // Get plan details if available
            $plan_name = '';
            $plan_description = '';
            if (!empty($membership_plan_id)) {
                $plan = get_post($membership_plan_id);
                if ($plan) {
                    $plan_name = $plan->post_title;
                    $plan_description = $plan->post_excerpt;
                }
            }
        ?>
            <div class="ce-membership-subscriptions-content">
                <?php if (!empty($membership_level)) : ?>
                    <div class="ce-membership-current-subscription">
                        <h2><?php _e('Current Subscription', 'common-elements-platform'); ?></h2>
                        
                        <div class="subscription-details">
                            <div class="subscription-detail">
                                <span class="detail-label"><?php _e('Plan:', 'common-elements-platform'); ?></span>
                                <span class="detail-value"><?php echo !empty($plan_name) ? esc_html($plan_name) : esc_html(ucfirst($membership_level)); ?></span>
                            </div>
                            
                            <div class="subscription-detail">
                                <span class="detail-label"><?php _e('Status:', 'common-elements-platform'); ?></span>
                                <span class="detail-value <?php echo esc_attr($membership_status); ?>"><?php echo esc_html(ucfirst($membership_status)); ?></span>
                            </div>
                            
                            <?php if (!empty($membership_expiry)) : ?>
                                <div class="subscription-detail">
                                    <span class="detail-label"><?php _e('Expires:', 'common-elements-platform'); ?></span>
                                    <span class="detail-value"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($membership_expiry))); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($membership_renewal) && $membership_renewal == 'auto') : ?>
                                <div class="subscription-detail">
                                    <span class="detail-label"><?php _e('Renewal:', 'common-elements-platform'); ?></span>
                                    <span class="detail-value"><?php _e('Automatic', 'common-elements-platform'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($plan_description)) : ?>
                            <div class="subscription-description">
                                <?php echo wpautop(esc_html($plan_description)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="subscription-actions">
                            <?php if ($membership_status == 'active') : ?>
                                <form method="post" class="cancel-subscription-form">
                                    <input type="hidden" name="action" value="ce_cancel_subscription" />
                                    <?php wp_nonce_field('ce_cancel_subscription_nonce', 'ce_subscription_nonce'); ?>
                                    <button type="submit" class="ce-button ce-button-danger" onclick="return confirm('<?php esc_attr_e('Are you sure you want to cancel your subscription?', 'common-elements-platform'); ?>');"><?php _e('Cancel Subscription', 'common-elements-platform'); ?></button>
                                </form>
                            <?php elseif ($membership_status == 'cancelled' || $membership_status == 'expired') : ?>
                                <a href="<?php echo esc_url(home_url('/membership-plans/')); ?>" class="ce-button ce-button-primary"><?php _e('Renew Subscription', 'common-elements-platform'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="ce-membership-no-subscription">
                        <p><?php _e('You don\'t have any active subscriptions.', 'common-elements-platform'); ?></p>
                        <p><a href="<?php echo esc_url(home_url('/membership-plans/')); ?>" class="ce-button ce-button-primary"><?php _e('View Membership Plans', 'common-elements-platform'); ?></a></p>
                    </div>
                <?php endif; ?>
                
                <div class="ce-membership-subscription-history">
                    <h2><?php _e('Subscription History', 'common-elements-platform'); ?></h2>
                    
                    <?php
                    // This would typically query a custom table or post type for subscription history
                    // For this template, we'll just show a placeholder message
                    ?>
                    
                    <p class="no-subscription-history"><?php _e('No subscription history available.', 'common-elements-platform'); ?></p>
                </div>
            </div>
        <?php else : ?>
            <div class="ce-membership-login-required">
                <p><?php _e('Please log in to view your subscriptions.', 'common-elements-platform'); ?></p>
                <?php wp_login_form(array('redirect' => get_permalink())); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
