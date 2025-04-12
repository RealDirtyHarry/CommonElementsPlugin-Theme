<?php
/**
 * Membership Account Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-account-container">
    <div class="ce-membership-account-wrapper">
        <h1 class="ce-membership-account-title"><?php _e('My Account', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : ?>
            <?php echo do_shortcode('[ce_membership_account]'); ?>
        <?php else : ?>
            <div class="ce-membership-login-required">
                <p><?php _e('Please log in to view your account details.', 'common-elements-platform'); ?></p>
                <?php wp_login_form(array('redirect' => get_permalink())); ?>
                <p class="ce-membership-register-link">
                    <?php _e('Don\'t have an account?', 'common-elements-platform'); ?> 
                    <a href="<?php echo esc_url(home_url('/membership-register/')); ?>"><?php _e('Register here', 'common-elements-platform'); ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
