<?php
/**
 * Membership Login Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-login-container">
    <div class="ce-membership-login-wrapper">
        <h1 class="ce-membership-login-title"><?php _e('Login to Your Account', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : ?>
            <div class="ce-membership-already-logged-in">
                <p><?php _e('You are already logged in.', 'common-elements-platform'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/membership-account/')); ?>"><?php _e('Go to your account', 'common-elements-platform'); ?></a></p>
            </div>
        <?php else : ?>
            <div class="ce-membership-login-form">
                <?php wp_login_form(array('redirect' => home_url('/membership-account/'))); ?>
                
                <p class="ce-membership-register-link">
                    <?php _e('Don\'t have an account?', 'common-elements-platform'); ?> 
                    <a href="<?php echo esc_url(home_url('/membership-register/')); ?>"><?php _e('Register here', 'common-elements-platform'); ?></a>
                </p>
                
                <p class="ce-membership-lost-password">
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Lost your password?', 'common-elements-platform'); ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
