<?php
/**
 * Membership Plans Template
 *
 * @package Common_Elements_Platform
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="ce-membership-plans-container">
    <div class="ce-membership-plans-wrapper">
        <h1 class="ce-membership-plans-title"><?php _e('Membership Plans', 'common-elements-platform'); ?></h1>
        
        <?php echo do_shortcode('[ce_membership_plans]'); ?>
    </div>
</div>

<?php
get_footer();
