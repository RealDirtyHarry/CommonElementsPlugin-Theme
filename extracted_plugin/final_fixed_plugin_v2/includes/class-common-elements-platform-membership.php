<?php
/**
 * Class Common_Elements_Platform_Membership
 *
 * Handles membership functionality for the Common Elements Platform
 *
 * @package Common_Elements_Platform
 */

class Common_Elements_Platform_Membership {
    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        $this->setup_hooks();
    }

    /**
     * Setup hooks for the membership functionality
     */
    private function setup_hooks() {
        // Register membership post type
        add_action('init', array($this, 'register_membership_post_type'));
        
        // Add membership capabilities to user roles
        add_action('admin_init', array($this, 'add_membership_capabilities'));
        
        // Register membership shortcodes
        add_shortcode('ce_membership_plans', array($this, 'membership_plans_shortcode'));
        add_shortcode('ce_membership_account', array($this, 'membership_account_shortcode'));
        
        // Handle membership registration and login
        add_action('wp_ajax_nopriv_ce_register_member', array($this, 'register_member'));
        add_action('wp_ajax_nopriv_ce_login_member', array($this, 'login_member'));
        
        // Handle membership management
        add_action('wp_ajax_ce_update_membership', array($this, 'update_membership'));
        add_action('wp_ajax_ce_cancel_membership', array($this, 'cancel_membership'));
        
        // Add membership metaboxes
        add_action('add_meta_boxes', array($this, 'add_membership_metaboxes'));
        add_action('save_post', array($this, 'save_membership_metabox_data'));
        
        // Filter content based on membership level
        add_filter('the_content', array($this, 'filter_content_by_membership'));
        
        // Add membership integration with Learning Hub
        add_filter('ce_course_access', array($this, 'check_course_access'), 10, 2);
    }
    
    /**
     * Register membership endpoints for the plugin
     * 
     * This method registers the necessary rewrite rules and endpoints
     * for membership functionality.
     */
    public function register_membership_endpoints() {
        // Register membership account endpoint
        add_rewrite_endpoint('membership-account', EP_ROOT | EP_PAGES);
        
        // Register membership plans endpoint
        add_rewrite_endpoint('membership-plans', EP_ROOT | EP_PAGES);
        
        // Register membership registration endpoint
        add_rewrite_endpoint('membership-register', EP_ROOT | EP_PAGES);
        
        // Register membership login endpoint
        add_rewrite_endpoint('membership-login', EP_ROOT | EP_PAGES);
        
        // Register membership profile endpoint
        add_rewrite_endpoint('membership-profile', EP_ROOT | EP_PAGES);
        
        // Register membership billing endpoint
        add_rewrite_endpoint('membership-billing', EP_ROOT | EP_PAGES);
        
        // Register membership subscriptions endpoint
        add_rewrite_endpoint('membership-subscriptions', EP_ROOT | EP_PAGES);
        
        // Flush rewrite rules only when needed
        if (get_option('ce_membership_flush_rewrite_rules', false)) {
            flush_rewrite_rules();
            delete_option('ce_membership_flush_rewrite_rules');
        }
    }
    
    /**
     * Register the membership post type
     */
    public function register_membership_post_type() {
        $labels = array(
            'name'               => _x('Membership Plans', 'post type general name', 'common-elements'),
            'singular_name'      => _x('Membership Plan', 'post type singular name', 'common-elements'),
            'menu_name'          => _x('Membership Plans', 'admin menu', 'common-elements'),
            'name_admin_bar'     => _x('Membership Plan', 'add new on admin bar', 'common-elements'),
            'add_new'            => _x('Add New', 'membership plan', 'common-elements'),
            'add_new_item'       => __('Add New Membership Plan', 'common-elements'),
            'new_item'           => __('New Membership Plan', 'common-elements'),
            'edit_item'          => __('Edit Membership Plan', 'common-elements'),
            'view_item'          => __('View Membership Plan', 'common-elements'),
            'all_items'          => __('All Membership Plans', 'common-elements'),
            'search_items'       => __('Search Membership Plans', 'common-elements'),
            'parent_item_colon'  => __('Parent Membership Plans:', 'common-elements'),
            'not_found'          => __('No membership plans found.', 'common-elements'),
            'not_found_in_trash' => __('No membership plans found in Trash.', 'common-elements')
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __('Membership plans for Common Elements', 'common-elements'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'membership-plan'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon'          => 'dashicons-groups'
        );

        register_post_type('ce_membership', $args);
    }

    /**
     * Add membership capabilities to user roles
     */
    public function add_membership_capabilities() {
        // Get the administrator role
        $admin = get_role('administrator');
        
        // Add membership capabilities
        $admin->add_cap('edit_ce_membership');
        $admin->add_cap('read_ce_membership');
        $admin->add_cap('delete_ce_membership');
        $admin->add_cap('edit_ce_memberships');
        $admin->add_cap('edit_others_ce_memberships');
        $admin->add_cap('publish_ce_memberships');
        $admin->add_cap('read_private_ce_memberships');
        
        // Create custom roles for membership levels
        add_role(
            'ce_basic_member',
            __('Basic Member', 'common-elements'),
            array(
                'read' => true,
                'ce_basic_access' => true
            )
        );
        
        add_role(
            'ce_professional_member',
            __('Professional Member', 'common-elements'),
            array(
                'read' => true,
                'ce_basic_access' => true,
                'ce_professional_access' => true
            )
        );
        
        add_role(
            'ce_enterprise_member',
            __('Enterprise Member', 'common-elements'),
            array(
                'read' => true,
                'ce_basic_access' => true,
                'ce_professional_access' => true,
                'ce_enterprise_access' => true
            )
        );
    }

    /**
     * Add metaboxes for membership plans
     */
    public function add_membership_metaboxes() {
        add_meta_box(
            'ce_membership_details',
            __('Membership Plan Details', 'common-elements'),
            array($this, 'render_membership_metabox'),
            'ce_membership',
            'normal',
            'high'
        );
    }

    /**
     * Render the membership metabox
     * 
     * @param WP_Post $post The post object
     */
    public function render_membership_metabox($post) {
        // Add nonce for security
        wp_nonce_field('ce_membership_metabox', 'ce_membership_metabox_nonce');
        
        // Get the saved values
        $price_monthly = get_post_meta($post->ID, '_ce_price_monthly', true);
        $price_annual = get_post_meta($post->ID, '_ce_price_annual', true);
        $features = get_post_meta($post->ID, '_ce_features', true);
        $level = get_post_meta($post->ID, '_ce_membership_level', true);
        
        // Output the fields
        ?>
        <div class="ce-metabox-field">
            <label for="ce_price_monthly"><?php _e('Monthly Price', 'common-elements'); ?></label>
            <input type="text" id="ce_price_monthly" name="ce_price_monthly" value="<?php echo esc_attr($price_monthly); ?>" />
        </div>
        
        <div class="ce-metabox-field">
            <label for="ce_price_annual"><?php _e('Annual Price', 'common-elements'); ?></label>
            <input type="text" id="ce_price_annual" name="ce_price_annual" value="<?php echo esc_attr($price_annual); ?>" />
        </div>
        
        <div class="ce-metabox-field">
            <label for="ce_membership_level"><?php _e('Membership Level', 'common-elements'); ?></label>
            <select id="ce_membership_level" name="ce_membership_level">
                <option value="basic" <?php selected($level, 'basic'); ?>><?php _e('Basic', 'common-elements'); ?></option>
                <option value="professional" <?php selected($level, 'professional'); ?>><?php _e('Professional', 'common-elements'); ?></option>
                <option value="enterprise" <?php selected($level, 'enterprise'); ?>><?php _e('Enterprise', 'common-elements'); ?></option>
            </select>
        </div>
        
        <div class="ce-metabox-field">
            <label for="ce_features"><?php _e('Features (one per line)', 'common-elements'); ?></label>
            <textarea id="ce_features" name="ce_features" rows="10"><?php echo esc_textarea($features); ?></textarea>
            <p class="description"><?php _e('Enter one feature per line. Prefix with + for included features or - for excluded features.', 'common-elements'); ?></p>
        </div>
        <?php
    }

    /**
     * Save the membership metabox data
     * 
     * @param int $post_id The post ID
     */
    public function save_membership_metabox_data($post_id) {
        // Check if our nonce is set
        if (!isset($_POST['ce_membership_metabox_nonce'])) {
            return;
        }
        
        // Verify the nonce
        if (!wp_verify_nonce($_POST['ce_membership_metabox_nonce'], 'ce_membership_metabox')) {
            return;
        }
        
        // If this is an autosave, we don't want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check the user's permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save the data
        if (isset($_POST['ce_price_monthly'])) {
            update_post_meta($post_id, '_ce_price_monthly', sanitize_text_field($_POST['ce_price_monthly']));
        }
        
        if (isset($_POST['ce_price_annual'])) {
            update_post_meta($post_id, '_ce_price_annual', sanitize_text_field($_POST['ce_price_annual']));
        }
        
        if (isset($_POST['ce_membership_level'])) {
            update_post_meta($post_id, '_ce_membership_level', sanitize_text_field($_POST['ce_membership_level']));
        }
        
        if (isset($_POST['ce_features'])) {
            update_post_meta($post_id, '_ce_features', sanitize_textarea_field($_POST['ce_features']));
        }
    }

    /**
     * Membership plans shortcode
     * 
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function membership_plans_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => -1,
            'featured' => ''
        ), $atts, 'ce_membership_plans');
        
        $args = array(
            'post_type' => 'ce_membership',
            'posts_per_page' => $atts['count'],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        
        if (!empty($atts['featured'])) {
            $args['meta_query'] = array(
                array(
                    'key' => '_ce_featured',
                    'value' => '1',
                    'compare' => '='
                )
            );
        }
        
        $query = new WP_Query($args);
        
        ob_start();
        
        if ($query->have_posts()) {
            ?>
            <div class="ce-membership-plans">
                <div class="plans-toggle">
                    <span class="toggle-label">Monthly</span>
                    <label class="switch">
                        <input type="checkbox" id="billing-toggle">
                        <span class="slider round"></span>
                    </label>
                    <span class="toggle-label">Annual <span class="save-badge">Save 20%</span></span>
                </div>
                
                <div class="plans-grid">
                    <?php while ($query->have_posts()) : $query->the_post(); 
                        $price_monthly = get_post_meta(get_the_ID(), '_ce_price_monthly', true);
                        $price_annual = get_post_meta(get_the_ID(), '_ce_price_annual', true);
                        $features = get_post_meta(get_the_ID(), '_ce_features', true);
                        $level = get_post_meta(get_the_ID(), '_ce_membership_level', true);
                        $featured = get_post_meta(get_the_ID(), '_ce_featured', true);
                        
                        $features_array = explode("\n", $features);
                    ?>
                    <div class="plan-card <?php echo ($featured == '1') ? 'featured' : ''; ?>">
                        <?php if ($featured == '1') : ?>
                        <div class="plan-badge">Most Popular</div>
                        <?php endif; ?>
                        
                        <div class="plan-header">
                            <h3 class="plan-name"><?php the_title(); ?></h3>
                            <div class="plan-price">
                                <div class="price monthly"><?php echo esc_html($price_monthly); ?><span class="period">/month</span></div>
                                <div class="price annual"><?php echo esc_html($price_annual); ?><span class="period">/year</span></div>
                            </div>
                            <div class="plan-description">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        
                        <div class="plan-features">
                            <ul>
                                <?php foreach ($features_array as $feature) : 
                                    $feature = trim($feature);
                                    if (empty($feature)) continue;
                                    
                                    $included = true;
                                    if (substr($feature, 0, 1) == '-') {
                                        $included = false;
                                        $feature = substr($feature, 1);
                                    } elseif (substr($feature, 0, 1) == '+') {
                                        $feature = substr($feature, 1);
                                    }
                                ?>
                                <li><i class="fa fa-<?php echo $included ? 'check' : 'times'; ?>"></i> <?php echo esc_html(trim($feature)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <div class="plan-footer">
                            <a href="<?php echo esc_url(home_url('/register/?plan=' . $level)); ?>" class="btn <?php echo ($featured == '1') ? 'btn-primary' : 'btn-outline'; ?> btn-block">Select Plan</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
        }
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    /**
     * Membership account shortcode
     * 
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function membership_account_shortcode($atts) {
        $atts = shortcode_atts(array(), $atts, 'ce_membership_account');
        
        ob_start();
        
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $membership_level = $this->get_user_membership_level($user->ID);
            $membership_expiry = get_user_meta($user->ID, '_ce_membership_expiry', true);
            $membership_status = get_user_meta($user->ID, '_ce_membership_status', true);
            
            ?>
            <div class="ce-membership-account">
                <div class="account-header">
                    <h2><?php _e('Your Membership', 'common-elements'); ?></h2>
                </div>
                
                <div class="account-details">
                    <div class="detail-row">
                        <div class="detail-label"><?php _e('Current Plan:', 'common-elements'); ?></div>
                        <div class="detail-value"><?php echo esc_html(ucfirst($membership_level)); ?></div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label"><?php _e('Status:', 'common-elements'); ?></div>
                        <div class="detail-value status-<?php echo esc_attr($membership_status); ?>"><?php echo esc_html(ucfirst($membership_status)); ?></div>
                    </div>
                    
                    <?php if ($membership_expiry) : ?>
                    <div class="detail-row">
                        <div class="detail-label"><?php _e('Renewal Date:', 'common-elements'); ?></div>
                        <div class="detail-value"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($membership_expiry))); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="account-actions">
                    <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn btn-outline"><?php _e('Change Plan', 'common-elements'); ?></a>
                    <a href="#" class="btn btn-text cancel-membership"><?php _e('Cancel Membership', 'common-elements'); ?></a>
                </div>
                
                <div class="account-benefits">
                    <h3><?php _e('Your Benefits', 'common-elements'); ?></h3>
                    <ul class="benefits-list">
                        <?php
                        switch ($membership_level) {
                            case 'enterprise':
                                echo '<li><i class="fa fa-check"></i> ' . __('Priority support', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Custom training sessions', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Multi-user accounts (up to 5)', 'common-elements') . '</li>';
                                // Fall through to include professional benefits
                                
                            case 'professional':
                                echo '<li><i class="fa fa-check"></i> ' . __('Certification programs', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Monthly webinars', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Unlimited document downloads', 'common-elements') . '</li>';
                                // Fall through to include basic benefits
                                
                            case 'basic':
                                echo '<li><i class="fa fa-check"></i> ' . __('Access to basic courses', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Community forum access', 'common-elements') . '</li>';
                                echo '<li><i class="fa fa-check"></i> ' . __('Email support', 'common-elements') . '</li>';
                                break;
                                
                            default:
                                echo '<li>' . __('No active membership', 'common-elements') . '</li>';
                                break;
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="ce-membership-login-required">
                <p><?php _e('Please log in to view your membership details.', 'common-elements'); ?></p>
                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="btn btn-primary"><?php _e('Log In', 'common-elements'); ?></a>
                <p><?php _e('Don\'t have an account?', 'common-elements'); ?> <a href="<?php echo esc_url(home_url('/register/')); ?>"><?php _e('Register', 'common-elements'); ?></a></p>
            </div>
            <?php
        }
        
        return ob_get_clean();
    }

    /**
     * Register a new member
     */
    public function register_member() {
        // Check nonce for security
        check_ajax_referer('ce_register_nonce', 'security');
        
        // Get the form data
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $plan = isset($_POST['plan']) ? sanitize_text_field($_POST['plan']) : 'basic';
        $payment_period = isset($_POST['payment_period']) ? sanitize_text_field($_POST['payment_period']) : 'monthly';
        
        // Validate the data
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            wp_send_json_error(array('message' => __('Please fill in all required fields.', 'common-elements')));
        }
        
        // Check if user already exists
        if (email_exists($email)) {
            wp_send_json_error(array('message' => __('This email address is already registered. Please log in.', 'common-elements')));
        }
        
        // Create the user
        $user_id = wp_create_user($email, $password, $email);
        
        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }
        
        // Update user data
        wp_update_user(array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name
        ));
        
        // Set user role based on membership level
        $user = new WP_User($user_id);
        
        switch ($plan) {
            case 'enterprise':
                $user->set_role('ce_enterprise_member');
                break;
                
            case 'professional':
                $user->set_role('ce_professional_member');
                break;
                
            case 'basic':
            default:
                $user->set_role('ce_basic_member');
                break;
        }
        
        // Save membership data
        update_user_meta($user_id, '_ce_membership_level', $plan);
        update_user_meta($user_id, '_ce_membership_period', $payment_period);
        update_user_meta($user_id, '_ce_membership_status', 'active');
        
        // Set membership expiry date
        $expiry_date = new DateTime();
        if ($payment_period === 'annual') {
            $expiry_date->add(new DateInterval('P1Y'));
        } else {
            $expiry_date->add(new DateInterval('P1M'));
        }
        update_user_meta($user_id, '_ce_membership_expiry', $expiry_date->format('Y-m-d H:i:s'));
        
        // Process payment (in a real implementation, this would integrate with a payment gateway)
        // For now, we'll just simulate a successful payment
        update_user_meta($user_id, '_ce_payment_status', 'completed');
        
        // Log the user in
        wp_set_auth_cookie($user_id, true);
        
        // Send success response
        wp_send_json_success(array(
            'message' => __('Registration successful! Redirecting to your account...', 'common-elements'),
            'redirect' => home_url('/dashboard/')
        ));
    }

    /**
     * Log in a member
     */
    public function login_member() {
        // Check nonce for security
        check_ajax_referer('ce_login_nonce', 'security');
        
        // Get the form data
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $remember = isset($_POST['remember']) ? (bool) $_POST['remember'] : false;
        
        // Validate the data
        if (empty($email) || empty($password)) {
            wp_send_json_error(array('message' => __('Please enter your email and password.', 'common-elements')));
        }
        
        // Get user by email
        $user = get_user_by('email', $email);
        
        if (!$user) {
            wp_send_json_error(array('message' => __('Invalid email or password.', 'common-elements')));
        }
        
        // Check the password
        $check = wp_check_password($password, $user->user_pass, $user->ID);
        
        if (!$check) {
            wp_send_json_error(array('message' => __('Invalid email or password.', 'common-elements')));
        }
        
        // Log the user in
        wp_set_auth_cookie($user->ID, $remember);
        
        // Send success response
        wp_send_json_success(array(
            'message' => __('Login successful! Redirecting...', 'common-elements'),
            'redirect' => home_url('/dashboard/')
        ));
    }

    /**
     * Update a user's membership
     */
    public function update_membership() {
        // Check nonce for security
        check_ajax_referer('ce_membership_nonce', 'security');
        
        // Check if user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => __('You must be logged in to update your membership.', 'common-elements')));
        }
        
        // Get the form data
        $plan = isset($_POST['plan']) ? sanitize_text_field($_POST['plan']) : '';
        $payment_period = isset($_POST['payment_period']) ? sanitize_text_field($_POST['payment_period']) : 'monthly';
        
        // Validate the data
        if (empty($plan)) {
            wp_send_json_error(array('message' => __('Please select a membership plan.', 'common-elements')));
        }
        
        // Get current user
        $user_id = get_current_user_id();
        $user = new WP_User($user_id);
        
        // Update user role based on membership level
        switch ($plan) {
            case 'enterprise':
                $user->set_role('ce_enterprise_member');
                break;
                
            case 'professional':
                $user->set_role('ce_professional_member');
                break;
                
            case 'basic':
            default:
                $user->set_role('ce_basic_member');
                break;
        }
        
        // Save membership data
        update_user_meta($user_id, '_ce_membership_level', $plan);
        update_user_meta($user_id, '_ce_membership_period', $payment_period);
        update_user_meta($user_id, '_ce_membership_status', 'active');
        
        // Set membership expiry date
        $expiry_date = new DateTime();
        if ($payment_period === 'annual') {
            $expiry_date->add(new DateInterval('P1Y'));
        } else {
            $expiry_date->add(new DateInterval('P1M'));
        }
        update_user_meta($user_id, '_ce_membership_expiry', $expiry_date->format('Y-m-d H:i:s'));
        
        // Process payment (in a real implementation, this would integrate with a payment gateway)
        // For now, we'll just simulate a successful payment
        update_user_meta($user_id, '_ce_payment_status', 'completed');
        
        // Send success response
        wp_send_json_success(array(
            'message' => __('Membership updated successfully!', 'common-elements'),
            'redirect' => home_url('/dashboard/')
        ));
    }

    /**
     * Cancel a user's membership
     */
    public function cancel_membership() {
        // Check nonce for security
        check_ajax_referer('ce_membership_nonce', 'security');
        
        // Check if user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => __('You must be logged in to cancel your membership.', 'common-elements')));
        }
        
        // Get current user
        $user_id = get_current_user_id();
        
        // Update membership status
        update_user_meta($user_id, '_ce_membership_status', 'cancelled');
        
        // Send success response
        wp_send_json_success(array(
            'message' => __('Your membership has been cancelled. You will continue to have access until the end of your current billing period.', 'common-elements'),
            'redirect' => home_url('/dashboard/')
        ));
    }

    /**
     * Filter content based on membership level
     * 
     * @param string $content The content
     * @return string The filtered content
     */
    public function filter_content_by_membership($content) {
        // Check for membership shortcodes
        if (has_shortcode($content, 'ce_membership_content')) {
            $pattern = get_shortcode_regex(array('ce_membership_content'));
            preg_match_all('/' . $pattern . '/s', $content, $matches);
            
            if (!empty($matches[0])) {
                foreach ($matches[0] as $key => $shortcode) {
                    $atts = shortcode_parse_atts($matches[3][$key]);
                    $level = isset($atts['level']) ? $atts['level'] : 'basic';
                    
                    if (!$this->user_has_access($level)) {
                        // Replace the shortcode with a message
                        $replacement = '<div class="ce-restricted-content">';
                        $replacement .= '<p>' . __('This content is available to ' . ucfirst($level) . ' members and above.', 'common-elements') . '</p>';
                        $replacement .= '<a href="' . esc_url(home_url('/membership/')) . '" class="btn btn-primary">' . __('Upgrade Membership', 'common-elements') . '</a>';
                        $replacement .= '</div>';
                        
                        $content = str_replace($shortcode, $replacement, $content);
                    } else {
                        // Remove the shortcode tags but keep the content
                        $content = str_replace($matches[0][$key], $matches[5][$key], $content);
                    }
                }
            }
        }
        
        return $content;
    }

    /**
     * Check if a user has access to a course
     * 
     * @param bool $access Current access status
     * @param int $course_id The course ID
     * @return bool Updated access status
     */
    public function check_course_access($access, $course_id) {
        // If access is already granted, don't restrict it
        if ($access) {
            return $access;
        }
        
        // Get the course membership level requirement
        $required_level = get_post_meta($course_id, '_ce_required_membership', true);
        
        if (empty($required_level)) {
            // No membership requirement, grant access
            return true;
        }
        
        // Check if user has the required membership level
        return $this->user_has_access($required_level);
    }

    /**
     * Check if the current user has access to a specific membership level
     * 
     * @param string $required_level The required membership level
     * @return bool Whether the user has access
     */
    private function user_has_access($required_level) {
        if (!is_user_logged_in()) {
            return false;
        }
        
        $user_id = get_current_user_id();
        $user_level = $this->get_user_membership_level($user_id);
        $membership_status = get_user_meta($user_id, '_ce_membership_status', true);
        
        // Check if membership is active
        if ($membership_status !== 'active') {
            return false;
        }
        
        // Check if membership has expired
        $expiry_date = get_user_meta($user_id, '_ce_membership_expiry', true);
        if (!empty($expiry_date) && strtotime($expiry_date) < time()) {
            return false;
        }
        
        // Check if user has the required level
        switch ($required_level) {
            case 'basic':
                return in_array($user_level, array('basic', 'professional', 'enterprise'));
                
            case 'professional':
                return in_array($user_level, array('professional', 'enterprise'));
                
            case 'enterprise':
                return $user_level === 'enterprise';
                
            default:
                return false;
        }
    }

    /**
     * Get a user's membership level
     * 
     * @param int $user_id The user ID
     * @return string The membership level
     */
    private function get_user_membership_level($user_id) {
        $user = new WP_User($user_id);
        
        if ($user->has_cap('ce_enterprise_access')) {
            return 'enterprise';
        } elseif ($user->has_cap('ce_professional_access')) {
            return 'professional';
        } elseif ($user->has_cap('ce_basic_access')) {
            return 'basic';
        }
        
        return '';
    }
}
