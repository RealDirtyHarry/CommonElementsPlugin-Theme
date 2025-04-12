<?php
/**
 * Template Name: Membership
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="membership-container">
    <div class="membership-header">
        <div class="container">
            <h1 class="membership-title">Membership Plans</h1>
            <div class="membership-description">
                <p>Join the Common Elements community and gain access to exclusive resources, learning materials, and networking opportunities.</p>
            </div>
        </div>
    </div>

    <div class="membership-content">
        <div class="container">
            <div class="membership-benefits">
                <h2 class="section-title">Membership Benefits</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-graduation-cap"></i></div>
                        <div class="benefit-content">
                            <h3>Learning Hub Access</h3>
                            <p>Unlimited access to our comprehensive library of courses, webinars, and educational resources.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-comments"></i></div>
                        <div class="benefit-content">
                            <h3>Community Forums</h3>
                            <p>Connect with peers, share experiences, and get advice from industry experts in our private forums.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-file-text"></i></div>
                        <div class="benefit-content">
                            <h3>Document Templates</h3>
                            <p>Access our library of professionally crafted templates, forms, and documents for community management.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-calendar"></i></div>
                        <div class="benefit-content">
                            <h3>Exclusive Events</h3>
                            <p>Participate in member-only webinars, workshops, and networking events throughout the year.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-users"></i></div>
                        <div class="benefit-content">
                            <h3>Networking Opportunities</h3>
                            <p>Connect with other community association professionals, board members, and service providers.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fa fa-certificate"></i></div>
                        <div class="benefit-content">
                            <h3>Certification Programs</h3>
                            <p>Earn professional certifications to enhance your credentials and advance your career.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="membership-plans">
                <h2 class="section-title">Choose Your Membership Plan</h2>
                <div class="plans-toggle">
                    <span class="toggle-label">Monthly</span>
                    <label class="switch">
                        <input type="checkbox" id="billing-toggle">
                        <span class="slider round"></span>
                    </label>
                    <span class="toggle-label">Annual <span class="save-badge">Save 20%</span></span>
                </div>
                
                <div class="plans-grid">
                    <div class="plan-card">
                        <div class="plan-header">
                            <h3 class="plan-name">Basic</h3>
                            <div class="plan-price">
                                <div class="price monthly">$19<span class="period">/month</span></div>
                                <div class="price annual">$182<span class="period">/year</span></div>
                            </div>
                            <div class="plan-description">
                                <p>Perfect for individual board members or homeowners looking to enhance their knowledge.</p>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><i class="fa fa-check"></i> Access to basic courses</li>
                                <li><i class="fa fa-check"></i> Community forum access</li>
                                <li><i class="fa fa-check"></i> 10 document downloads per month</li>
                                <li><i class="fa fa-check"></i> Email support</li>
                                <li><i class="fa fa-times"></i> Advanced courses</li>
                                <li><i class="fa fa-times"></i> Certification programs</li>
                                <li><i class="fa fa-times"></i> Exclusive webinars</li>
                                <li><i class="fa fa-times"></i> Priority support</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="<?php echo esc_url(home_url('/register/?plan=basic')); ?>" class="btn btn-outline btn-block">Select Plan</a>
                        </div>
                    </div>
                    
                    <div class="plan-card featured">
                        <div class="plan-badge">Most Popular</div>
                        <div class="plan-header">
                            <h3 class="plan-name">Professional</h3>
                            <div class="plan-price">
                                <div class="price monthly">$39<span class="period">/month</span></div>
                                <div class="price annual">$374<span class="period">/year</span></div>
                            </div>
                            <div class="plan-description">
                                <p>Ideal for CAM professionals, board members, and active community leaders.</p>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><i class="fa fa-check"></i> Access to all courses</li>
                                <li><i class="fa fa-check"></i> Community forum access</li>
                                <li><i class="fa fa-check"></i> Unlimited document downloads</li>
                                <li><i class="fa fa-check"></i> Email support</li>
                                <li><i class="fa fa-check"></i> Certification programs</li>
                                <li><i class="fa fa-check"></i> Monthly webinars</li>
                                <li><i class="fa fa-times"></i> Priority support</li>
                                <li><i class="fa fa-times"></i> Custom training sessions</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="<?php echo esc_url(home_url('/register/?plan=professional')); ?>" class="btn btn-primary btn-block">Select Plan</a>
                        </div>
                    </div>
                    
                    <div class="plan-card">
                        <div class="plan-header">
                            <h3 class="plan-name">Enterprise</h3>
                            <div class="plan-price">
                                <div class="price monthly">$99<span class="period">/month</span></div>
                                <div class="price annual">$950<span class="period">/year</span></div>
                            </div>
                            <div class="plan-description">
                                <p>Comprehensive solution for management companies and large associations.</p>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><i class="fa fa-check"></i> Access to all courses</li>
                                <li><i class="fa fa-check"></i> Community forum access</li>
                                <li><i class="fa fa-check"></i> Unlimited document downloads</li>
                                <li><i class="fa fa-check"></i> Priority support</li>
                                <li><i class="fa fa-check"></i> Certification programs</li>
                                <li><i class="fa fa-check"></i> All webinars and events</li>
                                <li><i class="fa fa-check"></i> Custom training sessions</li>
                                <li><i class="fa fa-check"></i> Multi-user accounts (up to 5)</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="<?php echo esc_url(home_url('/register/?plan=enterprise')); ?>" class="btn btn-outline btn-block">Select Plan</a>
                        </div>
                    </div>
                </div>
                
                <div class="custom-plan">
                    <div class="custom-plan-content">
                        <h3>Need a Custom Solution?</h3>
                        <p>We offer tailored membership plans for large organizations, management companies with multiple communities, and special use cases.</p>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline">Contact Us</a>
                    </div>
                </div>
            </div>
            
            <div class="membership-faq">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How do I upgrade or downgrade my membership?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>You can change your membership plan at any time by logging into your account and visiting the "Membership" section of your profile. Changes to a higher tier take effect immediately, while downgrades will take effect at the end of your current billing cycle.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Can I cancel my membership at any time?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, you can cancel your membership at any time. Simply log into your account, go to the "Membership" section, and click on "Cancel Membership." Your membership benefits will continue until the end of your current billing period.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Do you offer discounts for non-profit organizations?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we offer special pricing for non-profit organizations and educational institutions. Please contact our support team at <a href="mailto:support@commonelements.com">support@commonelements.com</a> with documentation of your non-profit status to learn more about our discount program.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Can I share my membership with others?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Individual memberships (Basic and Professional) are for single users only and should not be shared. The Enterprise plan includes multi-user functionality for up to 5 users. If you need access for more users, please contact us about our custom solutions.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>What payment methods do you accept?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>We accept all major credit cards (Visa, MasterCard, American Express, Discover) and PayPal. For Enterprise and custom plans, we also accept checks and bank transfers.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Is there a free trial available?</h3>
                            <div class="faq-toggle"><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we offer a 7-day free trial for new members. You can sign up for any plan and explore all its features without being charged. If you decide not to continue, simply cancel before the trial period ends, and you won't be billed.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="membership-testimonials">
                <h2 class="section-title">What Our Members Say</h2>
                <div class="testimonials-slider">
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"The resources and courses available through Common Elements have been invaluable for our board. We've improved our operations and governance significantly since joining."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Testimonial Author">
                            </div>
                            <div class="author-info">
                                <div class="author-name">Robert Chen</div>
                                <div class="author-title">Board President, Oakridge HOA</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"As a CAM professional managing multiple communities, the Professional membership has been a game-changer. The document templates alone have saved me countless hours of work."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Testimonial Author">
                            </div>
                            <div class="author-info">
                                <div class="author-name">Sarah Johnson</div>
                                <div class="author-title">Community Association Manager</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"The Enterprise membership has been perfect for our management company. Being able to provide training and resources to our entire team has improved our service quality and client satisfaction."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Testimonial Author">
                            </div>
                            <div class="author-info">
                                <div class="author-name">Michael Brown</div>
                                <div class="author-title">CEO, Premier Property Management</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="membership-cta">
                <div class="cta-content">
                    <h2>Ready to Join Our Community?</h2>
                    <p>Start your journey with Common Elements today and gain access to the resources, knowledge, and community that will help you excel in community association management.</p>
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-primary btn-large">Join Now</a>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-large">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// PHP 8.4 compatible JavaScript for membership page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality
    const billingToggle = document.getElementById('billing-toggle');
    const plansGrid = document.querySelector('.plans-grid');
    
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            if (this.checked) {
                plansGrid.classList.add('annual');
                plansGrid.classList.remove('monthly');
            } else {
                plansGrid.classList.add('monthly');
                plansGrid.classList.remove('annual');
            }
        });
        
        // Initialize to monthly by default
        plansGrid.classList.add('monthly');
    }
    
    // FAQ toggle functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const faqAnswer = this.nextElementSibling;
            const faqToggle = this.querySelector('.faq-toggle i');
            
            // Toggle answer visibility
            if (faqAnswer.style.display === 'block') {
                faqAnswer.style.display = 'none';
                faqToggle.classList.remove('fa-minus');
                faqToggle.classList.add('fa-plus');
            } else {
                faqAnswer.style.display = 'block';
                faqToggle.classList.remove('fa-plus');
                faqToggle.classList.add('fa-minus');
            }
        });
    });
    
    // Simple testimonial slider functionality
    let currentSlide = 0;
    const testimonials = document.querySelectorAll('.testimonial-item');
    
    if (testimonials.length > 1) {
        // Hide all testimonials except the first one
        testimonials.forEach(function(testimonial, index) {
            if (index !== 0) {
                testimonial.style.display = 'none';
            }
        });
        
        // Create navigation dots
        const sliderNav = document.createElement('div');
        sliderNav.className = 'slider-nav';
        
        testimonials.forEach(function(_, index) {
            const dot = document.createElement('span');
            dot.className = index === 0 ? 'dot active' : 'dot';
            dot.addEventListener('click', function() {
                showSlide(index);
            });
            sliderNav.appendChild(dot);
        });
        
        document.querySelector('.testimonials-slider').appendChild(sliderNav);
        
        // Auto-rotate testimonials every 5 seconds
        setInterval(function() {
            currentSlide = (currentSlide + 1) % testimonials.length;
            showSlide(currentSlide);
        }, 5000);
        
        function showSlide(index) {
            testimonials.forEach(function(testimonial) {
                testimonial.style.display = 'none';
            });
            
            const dots = document.querySelectorAll('.slider-nav .dot');
            dots.forEach(function(dot) {
                dot.classList.remove('active');
            });
            
            testimonials[index].style.display = 'block';
            dots[index].classList.add('active');
            currentSlide = index;
        }
    }
});
</script>

<?php
get_footer();
