<?php
/**
 * Plugin integrations for Common Elements Platform
 *
 * @package Common_Elements_Platform
 */

/**
 * Class to handle integrations with third-party plugins
 */
class Common_Elements_Platform_Integrations {

    /**
     * Initialize the integrations
     */
    public function __construct() {
        // Initialize integrations based on active plugins
        add_action('plugins_loaded', array($this, 'initialize_integrations'));
        add_action('activated_plugin', array($this, 'handle_plugin_activation'), 10, 1); // Moved inside constructor
        add_action('deactivated_plugin', array($this, 'handle_plugin_deactivation'), 10, 1); // Moved inside constructor
    }

    /**
     * Initialize integrations with third-party plugins
     */
    public function initialize_integrations() {
        // BuddyPress integration
        if ($this->is_plugin_active('buddypress/bp-loader.php')) {
            $this->initialize_buddypress_integration();
        }

        // bbPress integration
        if ($this->is_plugin_active('bbpress/bbpress.php')) {
            $this->initialize_bbpress_integration();
        }

        // MemberPress integration
        if ($this->is_plugin_active('memberpress/memberpress.php')) {
            $this->initialize_memberpress_integration();
        }

        // MemberPress Courses integration
        if ($this->is_plugin_active('memberpress-courses/main.php')) {
            $this->initialize_memberpress_courses_integration();
        }

        // GravityForms integration
        if ($this->is_plugin_active('gravityforms/gravityforms.php')) {
            $this->initialize_gravityforms_integration();
        }

        // GravityView integration
        if ($this->is_plugin_active('gravityview/gravityview.php')) {
            $this->initialize_gravityview_integration();
        }
    }

    /**
     * Check if a plugin is active
     *
     * @param string $plugin Plugin path relative to plugins directory
     * @return bool Whether the plugin is active
     */
    private function is_plugin_active($plugin) {
        return in_array($plugin, (array) get_option('active_plugins', array())) || $this->is_plugin_active_for_network($plugin);
    }

    /**
     * Check if a plugin is network active
     *
     * @param string $plugin Plugin path relative to plugins directory
     * @return bool Whether the plugin is network active
     */
    private function is_plugin_active_for_network($plugin) {
        if (!is_multisite()) {
            return false;
        }

        $plugins = get_site_option('active_sitewide_plugins');
        if (isset($plugins[$plugin])) {
            return true;
        }

        return false;
    }


    /**
     * Handle activation of a specific plugin to potentially initialize integration.
     *
     * @param string $plugin Plugin path relative to plugins directory.
     */
    public function handle_plugin_activation($plugin) {
        switch ($plugin) {
            case 'buddypress/bp-loader.php':
                $this->initialize_buddypress_integration();
                break;
            case 'bbpress/bbpress.php':
                $this->initialize_bbpress_integration();
                break;
            case 'memberpress/memberpress.php':
                $this->initialize_memberpress_integration();
                break;
            case 'memberpress-courses/main.php':
                $this->initialize_memberpress_courses_integration();
                break;
            case 'gravityforms/gravityforms.php':
                $this->initialize_gravityforms_integration();
                break;
            case 'gravityview/gravityview.php':
                $this->initialize_gravityview_integration();
                break;
        }
    }

    /**
     * Handle deactivation of a specific plugin to potentially clean up integration.
     * (Currently, no specific cleanup actions are defined, but the hook is present).
     *
     * @param string $plugin Plugin path relative to plugins directory.
     */
    public function handle_plugin_deactivation($plugin) {
        error_log('Plugin deactivated: ' . $plugin . ' - Common Elements integration check.');
    }

    /**
     * Initialize BuddyPress integration
     */
    private function initialize_buddypress_integration() {
        // Add BuddyPress profile fields for user role information
        add_action('bp_setup_nav', array($this, 'setup_buddypress_nav'));
        
        // Add custom tabs to BuddyPress profiles
        add_action('bp_setup_nav', array($this, 'add_custom_profile_tabs'));
        
        // Sync WordPress role changes with BuddyPress xprofile fields
        add_action('set_user_role', array($this, 'sync_user_role_to_xprofile'), 10, 3);
        
        // Add dashboard link to BuddyPress member navigation
        add_action('bp_setup_nav', array($this, 'add_dashboard_nav_item'));
    }

    /**
     * Setup BuddyPress navigation
     */
    public function setup_buddypress_nav() {
    }

    /**
     * Add custom tabs to BuddyPress profiles
     */
    public function add_custom_profile_tabs() {
        // Only add these tabs for specific user roles
        if (!is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();
        $roles = (array) $user->roles;

        // Add RFP tab for vendors
        if (in_array('contributor', $roles)) {
            bp_core_new_nav_item(array(
                'name' => __('My Proposals', 'common-elements-platform'),
                'slug' => 'proposals',
                'position' => 80,
                'screen_function' => array($this, 'proposals_screen'),
                'default_subnav_slug' => 'active',
                'item_css_id' => 'proposals'
            ));
        }

        // Add Communities tab for CAM professionals
        if (in_array('author', $roles)) {
            bp_core_new_nav_item(array(
                'name' => __('Communities', 'common-elements-platform'),
                'slug' => 'communities',
                'position' => 80,
                'screen_function' => array($this, 'communities_screen'),
                'default_subnav_slug' => 'active',
                'item_css_id' => 'communities'
            ));
        }
    }

    /**
     * Sync WordPress role changes with BuddyPress xprofile fields
     */
    public function sync_user_role_to_xprofile($user_id, $role, $old_roles) {
    }

    /**
     * Add dashboard link to BuddyPress member navigation
     */
    public function add_dashboard_nav_item() {
        if (!is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();
        $roles = (array) $user->roles;
        $dashboard_url = '';

        // Determine which dashboard to link to based on user role
        if (in_array('administrator', $roles) || in_array('editor', $roles)) {
            $dashboard_url = home_url('/dashboard-board/');
        } elseif (in_array('author', $roles)) {
            $dashboard_url = home_url('/dashboard-cam/');
        } elseif (in_array('contributor', $roles)) {
            $dashboard_url = home_url('/dashboard-vendor/');
        } else {
            $dashboard_url = home_url('/dashboard/');
        }

        if (!empty($dashboard_url)) {
            bp_core_new_nav_item(array(
                'name' => __('Dashboard', 'common-elements-platform'),
                'slug' => 'dashboard',
                'position' => 15,
                'screen_function' => array($this, 'dashboard_redirect'),
                'default_subnav_slug' => 'view',
                'item_css_id' => 'dashboard'
            ));
        }
    }

    /**
     * Redirect to the appropriate dashboard
     */
    public function dashboard_redirect() {
        $user = wp_get_current_user();
        $roles = (array) $user->roles;
        
        if (in_array('administrator', $roles) || in_array('editor', $roles)) {
            wp_redirect(home_url('/dashboard-board/'));
        } elseif (in_array('author', $roles)) {
            wp_redirect(home_url('/dashboard-cam/'));
        } elseif (in_array('contributor', $roles)) {
            wp_redirect(home_url('/dashboard-vendor/'));
        } else {
            wp_redirect(home_url('/dashboard/'));
        }
        
        exit;
    }

    /**
     * Initialize bbPress integration
     */
    private function initialize_bbpress_integration() {
        // Add custom forum categories for different user roles
        add_action('bbp_init', array($this, 'register_custom_forum_categories'));
        
        // Add role-based access control to forums
        add_filter('bbp_has_topics', array($this, 'filter_topics_by_role'));
        
        // Add custom fields to forum topics
        add_action('bbp_theme_after_topic_form_content', array($this, 'add_custom_topic_fields'));
        
        // Save custom fields when topic is created
        add_action('bbp_new_topic', array($this, 'save_custom_topic_fields'));
        
        // Display custom fields on single topic view
        add_action('bbp_template_before_single_topic', array($this, 'display_custom_topic_fields'));
    }

    /**
     * Register custom forum categories
     */
    public function register_custom_forum_categories() {
    }

    /**
     * Filter topics by user role
     */
    public function filter_topics_by_role($has_topics) {
        return $has_topics;
    }

    /**
     * Add custom fields to forum topics
     */
    public function add_custom_topic_fields() {
    }

    /**
     * Save custom fields when topic is created
     */
    public function save_custom_topic_fields($topic_id) {
    }

    /**
     * Display custom fields on single topic view
     */
    public function display_custom_topic_fields() {
    }

    /**
     * Initialize MemberPress integration
     */
    private function initialize_memberpress_integration() {
        // Add custom membership levels
        add_action('mepr-init', array($this, 'register_custom_membership_levels'));
        
        // Add custom user fields
        add_filter('mepr-custom-fields', array($this, 'add_custom_user_fields'));
        
        // Add role-based content access
        add_filter('mepr-rule-access', array($this, 'filter_content_access_by_role'), 10, 3);
        
        // Customize MemberPress account page
        add_filter('mepr_account_page_template_vars', array($this, 'customize_account_page'));
    }

    /**
     * Register custom membership levels
     */
    public function register_custom_membership_levels() {
    }

    /**
     * Add custom user fields
     */
    public function add_custom_user_fields($fields) {
        return $fields;
    }

    /**
     * Filter content access by role
     */
    public function filter_content_access_by_role($has_access, $current_post, $user) {
        return $has_access;
    }

    /**
     * Customize MemberPress account page
     */
    public function customize_account_page($vars) {
        return $vars;
    }

    /**
     * Initialize MemberPress Courses integration
     */
    private function initialize_memberpress_courses_integration() {
        // Add custom course categories
        add_action('mpcs_init', array($this, 'register_custom_course_categories'));
        
        // Add custom fields to courses
        add_filter('mpcs_course_meta_boxes', array($this, 'add_custom_course_fields'));
        
        // Add custom fields to lessons
        add_filter('mpcs_lesson_meta_boxes', array($this, 'add_custom_lesson_fields'));
        
        // Customize course completion certificate
        add_filter('mpcs_certificate_content', array($this, 'customize_certificate'), 10, 2);
    }

    /**
     * Register custom course categories
     */
    public function register_custom_course_categories() {
    }

    /**
     * Add custom fields to courses
     */
    public function add_custom_course_fields($meta_boxes) {
        return $meta_boxes;
    }

    /**
     * Add custom fields to lessons
     */
    public function add_custom_lesson_fields($meta_boxes) {
        return $meta_boxes;
    }

    /**
     * Customize course completion certificate
     */
    public function customize_certificate($content, $course_id) {
        return $content;
    }

    /**
     * Initialize GravityForms integration
     */
    private function initialize_gravityforms_integration() {
        // Register custom notification events
        add_filter('gform_notification_events', array($this, 'register_custom_notification_events'));
        
        // Add custom merge tags
        add_filter('gform_custom_merge_tags', array($this, 'add_custom_merge_tags'));
        
        // Process form submissions for RFPs
        add_action('gform_after_submission', array($this, 'process_rfp_submission'), 10, 2);
        
        // Process form submissions for proposals
        add_action('gform_after_submission', array($this, 'process_proposal_submission'), 10, 2);
    }

    /**
     * Register custom notification events
     */
    public function register_custom_notification_events($events) {
        return $events;
    }

    /**
     * Add custom merge tags
     */
    public function add_custom_merge_tags($merge_tags) {
        return $merge_tags;
    }

    /**
     * Process RFP form submissions
     */
    public function process_rfp_submission($entry, $form) {
        // Check if this is the RFP form
        if ($form['id'] != $this->get_rfp_form_id()) {
            return;
        }

		if ( ! current_user_can( 'publish_posts' ) ) {
			error_log('Security Warning: process_rfp_submission called without sufficient capability.');
			return; // Stop processing if capability check fails
		}


        // Get form data
        $title = rgar($entry, $this->get_field_id($form, 'title'));
        $description = rgar($entry, $this->get_field_id($form, 'description'));
        $deadline = rgar($entry, $this->get_field_id($form, 'deadline'));
        $community = rgar($entry, $this->get_field_id($form, 'community'));
        $category = rgar($entry, $this->get_field_id($form, 'category'));
        
        // Create RFP post
        $rfp_data = array(
            'post_title'    => $title,
            'post_content'  => $description,
            'post_status'   => 'publish',
            'post_type'     => 'rfp',
            'post_author'   => get_current_user_id(),
        );
        
        $rfp_id = wp_insert_post($rfp_data);
        
        if (!is_wp_error($rfp_id)) {
            // Add RFP metadata
            update_post_meta($rfp_id, 'rfp_deadline', $deadline);
            update_post_meta($rfp_id, 'rfp_community', $community);
            update_post_meta($rfp_id, 'rfp_status', 'open');
            
            // Set RFP category if provided
            if (!empty($category)) {
                wp_set_object_terms($rfp_id, $category, 'rfp_category');
            }
            
            // Handle file uploads if any
            $file_field_id = $this->get_field_id($form, 'file');
            if (!empty($file_field_id)) {
                $file_url = rgar($entry, $file_field_id);
                if (!empty($file_url)) {
                    $attachment_id = $this->save_gravity_form_file($file_url, $rfp_id);
                    if ($attachment_id) {
                        add_post_meta($rfp_id, 'rfp_attachment', $attachment_id);
                    }
                }
            }
            
            // Update the entry with the RFP ID
            gform_update_meta($entry['id'], 'rfp_id', $rfp_id);
            
            // Notify vendors of new RFP
            $this->notify_vendors_of_new_rfp($rfp_id);
        }
    }

    /**
     * Process proposal form submissions
     */
    public function process_proposal_submission($entry, $form) {
        // Check if this is the proposal form
        if ($form['id'] != $this->get_proposal_form_id()) {
            return;
        }

        // Get form data
        $rfp_id = rgar($entry, $this->get_field_id($form, 'rfp_id'));
        $title = rgar($entry, $this->get_field_id($form, 'title'));
        $description = rgar($entry, $this->get_field_id($form, 'description'));
        $price = rgar($entry, $this->get_field_id($form, 'price'));
        $timeline = rgar($entry, $this->get_field_id($form, 'timeline'));
        
        // Verify RFP exists and is open
        $rfp = get_post($rfp_id);
        if (!$rfp || $rfp->post_type !== 'rfp') {
            return;
        }
        
        $rfp_status = get_post_meta($rfp_id, 'rfp_status', true);
        if ($rfp_status !== 'open') {
            return;
        }
        
		if ( ! current_user_can( 'edit_posts' ) ) {
			error_log('Security Warning: process_proposal_submission called without sufficient capability.');
			return; // Stop processing if capability check fails
		}


        // Create proposal post
        $proposal_data = array(
            'post_title'    => $title,
            'post_content'  => $description,
            'post_status'   => 'publish',
            'post_type'     => 'proposal',
            'post_author'   => get_current_user_id(),
        );
        
        $proposal_id = wp_insert_post($proposal_data);
        
        if (!is_wp_error($proposal_id)) {
            // Add proposal metadata
            update_post_meta($proposal_id, 'related_rfp', $rfp_id);
            update_post_meta($proposal_id, 'proposal_price', $price);
            update_post_meta($proposal_id, 'proposal_timeline', $timeline);
            update_post_meta($proposal_id, 'proposal_status', 'submitted');
            
            // Handle file uploads if any
            $file_field_id = $this->get_field_id($form, 'file');
            if (!empty($file_field_id)) {
                $file_url = rgar($entry, $file_field_id);
                if (!empty($file_url)) {
                    $attachment_id = $this->save_gravity_form_file($file_url, $proposal_id);
                    if ($attachment_id) {
                        add_post_meta($proposal_id, 'proposal_attachment', $attachment_id);
                    }
                }
            }
            
            // Update the entry with the proposal ID
            gform_update_meta($entry['id'], 'proposal_id', $proposal_id);
            
            // Notify RFP author of new proposal
            $this->notify_rfp_author_of_new_proposal($rfp_id, $proposal_id);
        }
    }

    /**
     * Get RFP form ID
     */
    private function get_rfp_form_id() {
        // This would be set in the plugin settings
        return get_option('common_elements_rfp_form_id', 0);
    }

    /**
     * Get proposal form ID
     */
    private function get_proposal_form_id() {
        // This would be set in the plugin settings
        return get_option('common_elements_proposal_form_id', 0);
    }

    /**
     * Get field ID by field name
     */
    private function get_field_id($form, $field_name) {
        foreach ($form['fields'] as $field) {
            if ($field->adminLabel == $field_name) {
                return $field->id;
            }
        }
        return 0;
    }

    /**
     * Save file from Gravity Forms to media library
     */
    private function save_gravity_form_file($file_url, $post_id) {
        error_log('Placeholder function called: ' . __METHOD__ . ' - File saving not implemented for URL: ' . $file_url);
        return 0; // Return 0 to indicate failure until implemented.
    }

    /**
     * Notify vendors of a new RFP
     */
    private function notify_vendors_of_new_rfp($rfp_id) {
        error_log('Placeholder function called: ' . __METHOD__ . ' - Vendor notification not implemented for RFP ID: ' . $rfp_id);
    }

    /**
     * Notify RFP author of a new proposal
     */
    private function notify_rfp_author_of_new_proposal($rfp_id, $proposal_id) {
        error_log('Placeholder function called: ' . __METHOD__ . ' - RFP author notification not implemented for RFP ID: ' . $rfp_id . ', Proposal ID: ' . $proposal_id);
    }

    /**
     * Initialize GravityView integration
     */
    private function initialize_gravityview_integration() {
        // Add custom field types
        add_filter('gravityview/fields/custom', array($this, 'register_custom_field_types'));
        
        // Add custom view templates
        add_filter('gravityview_register_templates', array($this, 'register_custom_templates'));
        
        // Modify view settings
        add_filter('gravityview/view/settings/defaults', array($this, 'modify_view_settings'));
    }

    /**
     * Register custom field types
     */
    public function register_custom_field_types($field_types) {
        return $field_types;
    }

    /**
     * Register custom templates
     */
    public function register_custom_templates($templates) {
        return $templates;
    }

    /**
     * Modify view settings
     */
    public function modify_view_settings($settings) {
        return $settings;
    }
}

// Initialize the integrations
new Common_Elements_Platform_Integrations();
