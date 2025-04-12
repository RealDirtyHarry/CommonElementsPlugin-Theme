<?php
/**
 * Membership Profile Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-profile-container">
    <div class="ce-membership-profile-wrapper">
        <h1 class="ce-membership-profile-title"><?php _e('Your Profile', 'common-elements-platform'); ?></h1>
        
        <?php if (is_user_logged_in()) : 
            $current_user = wp_get_current_user();
        ?>
            <div class="ce-membership-profile-form">
                <form id="ce-membership-profile" method="post">
                    <div class="form-group">
                        <label for="first_name"><?php _e('First Name', 'common-elements-platform'); ?></label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($current_user->first_name); ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name"><?php _e('Last Name', 'common-elements-platform'); ?></label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($current_user->last_name); ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><?php _e('Email', 'common-elements-platform'); ?> <span class="required">*</span></label>
                        <input type="email" name="email" id="email" value="<?php echo esc_attr($current_user->user_email); ?>" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="bio"><?php _e('Bio', 'common-elements-platform'); ?></label>
                        <textarea name="bio" id="bio" rows="5"><?php echo esc_textarea(get_user_meta($current_user->ID, 'description', true)); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <h3><?php _e('Change Password', 'common-elements-platform'); ?></h3>
                        <p class="description"><?php _e('Leave blank to keep current password', 'common-elements-platform'); ?></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="current_password"><?php _e('Current Password', 'common-elements-platform'); ?></label>
                        <input type="password" name="current_password" id="current_password" />
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password"><?php _e('New Password', 'common-elements-platform'); ?></label>
                        <input type="password" name="new_password" id="new_password" />
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password"><?php _e('Confirm New Password', 'common-elements-platform'); ?></label>
                        <input type="password" name="confirm_password" id="confirm_password" />
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" name="action" value="ce_update_profile" />
                        <?php wp_nonce_field('ce_update_profile_nonce', 'ce_profile_nonce'); ?>
                        <button type="submit" class="ce-button ce-button-primary"><?php _e('Update Profile', 'common-elements-platform'); ?></button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="ce-membership-login-required">
                <p><?php _e('Please log in to view your profile.', 'common-elements-platform'); ?></p>
                <?php wp_login_form(array('redirect' => get_permalink())); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
