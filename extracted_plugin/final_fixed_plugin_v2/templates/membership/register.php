<?php
/**
 * Membership Register Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-register-container">
    <div class="ce-membership-register-wrapper">
        <h1 class="ce-membership-register-title"><?php _e('Register for Membership', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : ?>
            <div class="ce-membership-already-registered">
                <p><?php _e('You are already registered and logged in.', 'common-elements-platform'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/membership-account/')); ?>"><?php _e('Go to your account', 'common-elements-platform'); ?></a></p>
            </div>
        <?php else : ?>
            <div class="ce-membership-register-form">
                <form id="ce-membership-register" method="post">
                    <div class="form-group">
                        <label for="username"><?php _e('Username', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="text" name="username" id="username" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><?php _e('Email', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="email" name="email" id="email" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><?php _e('Password', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="password" name="password" id="password" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm"><?php _e('Confirm Password', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" required />
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" name="action" value="ce_register_member" />
                        <?php wp_nonce_field('ce_register_member_nonce', 'ce_register_nonce'); ?>
                        <button type="submit" class="ce-button ce-button-primary"><?php _e('Register', 'common-elements-platform'); ?></button>
                    </div>
                </form>
                
                <p class="ce-membership-login-link">
                    <?php _e('Already have an account?', 'common-elements-platform'); ?> 
                    <a href="<?php echo esc_url(home_url('/membership-login/')); ?>"><?php _e('Login here', 'common-elements-platform'); ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
