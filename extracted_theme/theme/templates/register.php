<?php
/**
 * Template Name: Register
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="register-container">
    <div class="register-header">
        <div class="container">
            <h1 class="register-title">Create Your Account</h1>
            <div class="register-description">
                <p>Join the Common Elements community to access exclusive resources, courses, and networking opportunities.</p>
            </div>
        </div>
    </div>

    <div class="register-content">
        <div class="container">
            <div class="register-main">
                <?php
                // Get the selected plan from URL parameter
                $selected_plan = isset($_GET['plan']) ? sanitize_text_field($_GET['plan']) : '';
                $plan_name = '';
                $plan_price = '';
                $plan_period = 'monthly';
                
                // Set plan details based on selection
                if ($selected_plan === 'basic') {
                    $plan_name = 'Basic';
                    $plan_price = '$19/month';
                } elseif ($selected_plan === 'professional') {
                    $plan_name = 'Professional';
                    $plan_price = '$39/month';
                } elseif ($selected_plan === 'enterprise') {
                    $plan_name = 'Enterprise';
                    $plan_price = '$99/month';
                }
                ?>
                
                <?php if (!empty($selected_plan)): ?>
                <div class="selected-plan">
                    <h2>Selected Plan: <?php echo esc_html($plan_name); ?></h2>
                    <div class="plan-details">
                        <div class="plan-price"><?php echo esc_html($plan_price); ?></div>
                        <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="change-plan-link">Change Plan</a>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="register-form-container">
                    <div class="form-tabs">
                        <div class="tab active" data-tab="register">Register</div>
                        <div class="tab" data-tab="login">Login</div>
                    </div>
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="register-tab">
                            <form id="register-form" class="register-form">
                                <div class="form-section">
                                    <h3>Account Information</h3>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="first-name">First Name *</label>
                                            <input type="text" id="first-name" name="first_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last-name">Last Name *</label>
                                            <input type="text" id="last-name" name="last_name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input type="password" id="password" name="password" required>
                                            <div class="password-requirements">
                                                <p>Password must contain:</p>
                                                <ul>
                                                    <li>At least 8 characters</li>
                                                    <li>At least one uppercase letter</li>
                                                    <li>At least one number</li>
                                                    <li>At least one special character</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password *</label>
                                            <input type="password" id="confirm-password" name="confirm_password" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h3>Profile Information</h3>
                                    
                                    <div class="form-group">
                                        <label for="role">Your Role *</label>
                                        <select id="role" name="role" required>
                                            <option value="">Select your role</option>
                                            <option value="board_member">Board Member</option>
                                            <option value="cam_professional">CAM Professional</option>
                                            <option value="vendor">Vendor/Service Provider</option>
                                            <option value="homeowner">Homeowner</option>
                                            <option value="property_manager">Property Manager</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="organization">Organization Name</label>
                                        <input type="text" id="organization" name="organization">
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" id="city" name="city">
                                        </div>
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <select id="state" name="state">
                                                <option value="">Select state</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <!-- Add all states here -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($selected_plan)): ?>
                                <div class="form-section">
                                    <h3>Payment Information</h3>
                                    
                                    <div class="payment-options">
                                        <div class="payment-toggle">
                                            <span class="toggle-label">Monthly</span>
                                            <label class="switch">
                                                <input type="checkbox" id="payment-period-toggle" name="payment_period" value="annual">
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="toggle-label">Annual <span class="save-badge">Save 20%</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="card-name">Name on Card *</label>
                                        <input type="text" id="card-name" name="card_name" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="card-number">Card Number *</label>
                                        <input type="text" id="card-number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="card-expiry">Expiration Date *</label>
                                            <input type="text" id="card-expiry" name="card_expiry" placeholder="MM/YY" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="card-cvc">CVC *</label>
                                            <input type="text" id="card-cvc" name="card_cvc" placeholder="CVC" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="billing-zip">Billing Zip Code *</label>
                                        <input type="text" id="billing-zip" name="billing_zip" required>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="form-section">
                                    <div class="form-group checkbox-group">
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="terms" name="terms" required>
                                            <span class="checkmark"></span>
                                            I agree to the <a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>" target="_blank">Terms of Service</a> and <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank">Privacy Policy</a>
                                        </label>
                                    </div>
                                    
                                    <div class="form-group checkbox-group">
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="newsletter" name="newsletter" checked>
                                            <span class="checkmark"></span>
                                            Subscribe to our newsletter for updates and special offers
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-large">Create Account</button>
                                </div>
                                
                                <div class="form-footer">
                                    <p>Already have an account? <a href="#" class="switch-tab" data-tab="login">Log in</a></p>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane" id="login-tab">
                            <form id="login-form" class="login-form">
                                <div class="form-group">
                                    <label for="login-email">Email Address *</label>
                                    <input type="email" id="login-email" name="login_email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="login-password">Password *</label>
                                    <input type="password" id="login-password" name="login_password" required>
                                </div>
                                
                                <div class="form-group checkbox-group">
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="remember-me" name="remember_me">
                                        <span class="checkmark"></span>
                                        Remember me
                                    </label>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-large">Log In</button>
                                </div>
                                
                                <div class="form-footer">
                                    <p><a href="<?php echo esc_url(home_url('/forgot-password/')); ?>">Forgot password?</a></p>
                                    <p>Don't have an account? <a href="#" class="switch-tab" data-tab="register">Register</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="register-sidebar">
                <div class="sidebar-card">
                    <h3>Why Join Common Elements?</h3>
                    <ul class="benefits-list">
                        <li><i class="fa fa-check"></i> Access to exclusive educational resources</li>
                        <li><i class="fa fa-check"></i> Connect with industry professionals</li>
                        <li><i class="fa fa-check"></i> Stay updated on best practices</li>
                        <li><i class="fa fa-check"></i> Downloadable templates and documents</li>
                        <li><i class="fa fa-check"></i> Professional development opportunities</li>
                    </ul>
                </div>
                
                <div class="sidebar-card testimonial">
                    <div class="testimonial-content">
                        <p>"Joining Common Elements was one of the best decisions our board made. The resources and community have been invaluable for improving our association."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Testimonial Author">
                        </div>
                        <div class="author-info">
                            <div class="author-name">Robert Chen</div>
                            <div class="author-title">Board President</div>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card help">
                    <h3>Need Help?</h3>
                    <p>Our support team is available to assist you with the registration process or answer any questions you may have.</p>
                    <div class="help-options">
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-block">Contact Support</a>
                        <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="btn btn-text btn-block">View FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// PHP 8.4 compatible JavaScript for registration page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.form-tabs .tab');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const switchTabLinks = document.querySelectorAll('.switch-tab');
    
    function switchTab(tabId) {
        // Hide all tab panes
        tabPanes.forEach(function(pane) {
            pane.classList.remove('active');
        });
        
        // Remove active class from all tabs
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
        
        // Show the selected tab pane
        document.getElementById(tabId + '-tab').classList.add('active');
        
        // Add active class to the selected tab
        tabs.forEach(function(tab) {
            if (tab.getAttribute('data-tab') === tabId) {
                tab.classList.add('active');
            }
        });
    }
    
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
    
    switchTabLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
    
    // Payment period toggle functionality
    const paymentToggle = document.getElementById('payment-period-toggle');
    
    if (paymentToggle) {
        paymentToggle.addEventListener('change', function() {
            const planPriceElement = document.querySelector('.selected-plan .plan-price');
            const selectedPlan = '<?php echo esc_js($selected_plan); ?>';
            
            if (this.checked) {
                // Annual pricing
                if (selectedPlan === 'basic') {
                    planPriceElement.textContent = '$182/year';
                } else if (selectedPlan === 'professional') {
                    planPriceElement.textContent = '$374/year';
                } else if (selectedPlan === 'enterprise') {
                    planPriceElement.textContent = '$950/year';
                }
            } else {
                // Monthly pricing
                if (selectedPlan === 'basic') {
                    planPriceElement.textContent = '$19/month';
                } else if (selectedPlan === 'professional') {
                    planPriceElement.textContent = '$39/month';
                } else if (selectedPlan === 'enterprise') {
                    planPriceElement.textContent = '$99/month';
                }
            }
        });
    }
    
    // Form validation
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
            
            // Password strength validation
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert('Password does not meet the requirements');
                return;
            }
            
            // In production, this would submit the form to the server
            alert('Registration successful! In a production environment, you would be redirected to your account dashboard.');
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In production, this would submit the form to the server
            alert('Login successful! In a production environment, you would be redirected to your account dashboard.');
        });
    }
    
    // Credit card input formatting
    const cardNumberInput = document.getElementById('card-number');
    const cardExpiryInput = document.getElementById('card-expiry');
    
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            
            // Format with spaces every 4 digits
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            this.value = formattedValue;
        });
    }
    
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4);
            }
            
            // Format as MM/YY
            if (value.length > 2) {
                this.value = value.slice(0, 2) + '/' + value.slice(2);
            } else {
                this.value = value;
            }
        });
    }
});
</script>

<?php
get_footer();
