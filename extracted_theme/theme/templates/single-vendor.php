<?php
/**
 * Template Name: Single Vendor
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="vendor-profile-container">
    <div class="vendor-profile-header">
        <div class="container">
            <div class="vendor-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/directory/')); ?>">Directory</a> &raquo; 
                <a href="<?php echo esc_url(home_url('/directory/?category=pool-maintenance')); ?>">Pool Maintenance</a> &raquo; 
                <span class="current">Crystal Clear Pools</span>
            </div>
            
            <div class="vendor-header-content">
                <div class="vendor-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Crystal Clear Pools Logo">
                </div>
                <div class="vendor-info">
                    <h1 class="vendor-name">Crystal Clear Pools</h1>
                    <div class="vendor-meta">
                        <span class="vendor-category">Pool Maintenance</span>
                        <span class="vendor-location">Atlanta, GA</span>
                        <span class="vendor-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span class="rating-value">4.5</span>
                            <span class="rating-count">(24 reviews)</span>
                        </span>
                    </div>
                    <div class="vendor-badges">
                        <span class="badge badge-featured">Featured</span>
                        <span class="badge badge-verified">Verified</span>
                        <span class="badge badge-top-rated">Top Rated</span>
                    </div>
                </div>
                <div class="vendor-actions">
                    <a href="mailto:info@crystalclearpools.com" class="btn btn-primary"><i class="fa fa-envelope"></i> Contact</a>
                    <a href="tel:+14045551234" class="btn btn-secondary"><i class="fa fa-phone"></i> Call</a>
                    <a href="#" class="btn btn-outline"><i class="fa fa-bookmark-o"></i> Save</a>
                </div>
            </div>
        </div>
    </div>

    <div class="vendor-profile-content">
        <div class="container">
            <div class="vendor-main">
                <div class="vendor-tabs">
                    <ul class="tabs-nav">
                        <li class="active"><a href="#about">About</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    
                    <div class="tabs-content">
                        <div id="about" class="tab-pane active">
                            <h2>About Crystal Clear Pools</h2>
                            <p>Crystal Clear Pools has been providing professional pool maintenance services to community associations and residential properties in the Atlanta area since 2005. Our team of certified pool operators ensures that your pool is always clean, safe, and properly maintained.</p>
                            
                            <p>We take pride in our attention to detail and commitment to customer satisfaction. Our comprehensive approach to pool maintenance has earned us a reputation for excellence in the industry.</p>
                            
                            <h3>Our Mission</h3>
                            <p>Our mission is to provide exceptional pool maintenance services that exceed our clients' expectations. We strive to maintain the highest standards of professionalism, reliability, and quality in everything we do.</p>
                            
                            <h3>Why Choose Us</h3>
                            <ul>
                                <li>Certified pool operators with extensive experience</li>
                                <li>Comprehensive maintenance programs tailored to your needs</li>
                                <li>Prompt and reliable service</li>
                                <li>Transparent pricing with no hidden fees</li>
                                <li>Environmentally friendly practices and products</li>
                                <li>24/7 emergency service available</li>
                            </ul>
                            
                            <h3>Areas Served</h3>
                            <p>We proudly serve community associations and residential properties throughout the greater Atlanta area, including:</p>
                            <ul>
                                <li>Atlanta</li>
                                <li>Marietta</li>
                                <li>Roswell</li>
                                <li>Alpharetta</li>
                                <li>Decatur</li>
                                <li>Sandy Springs</li>
                                <li>Dunwoody</li>
                            </ul>
                        </div>
                        
                        <div id="services" class="tab-pane">
                            <h2>Our Services</h2>
                            <p>Crystal Clear Pools offers a comprehensive range of pool maintenance services designed to keep your pool in optimal condition year-round. Our services include:</p>
                            
                            <div class="service-cards">
                                <div class="service-card">
                                    <div class="service-icon"><i class="fa fa-tint"></i></div>
                                    <h3>Regular Maintenance</h3>
                                    <p>Our regular maintenance program includes weekly or bi-weekly visits to clean your pool, balance chemicals, and ensure everything is operating properly.</p>
                                    <ul>
                                        <li>Skimming surface debris</li>
                                        <li>Vacuuming pool floor</li>
                                        <li>Brushing walls and steps</li>
                                        <li>Cleaning skimmer and pump baskets</li>
                                        <li>Testing and adjusting water chemistry</li>
                                        <li>Checking equipment operation</li>
                                    </ul>
                                </div>
                                
                                <div class="service-card">
                                    <div class="service-icon"><i class="fa fa-flask"></i></div>
                                    <h3>Chemical Management</h3>
                                    <p>Our chemical management service ensures that your pool water is properly balanced and safe for swimmers.</p>
                                    <ul>
                                        <li>Comprehensive water testing</li>
                                        <li>pH balancing</li>
                                        <li>Chlorine management</li>
                                        <li>Alkalinity adjustment</li>
                                        <li>Calcium hardness control</li>
                                        <li>Algae prevention and treatment</li>
                                    </ul>
                                </div>
                                
                                <div class="service-card">
                                    <div class="service-icon"><i class="fa fa-wrench"></i></div>
                                    <h3>Equipment Maintenance</h3>
                                    <p>We provide regular maintenance and repairs for all pool equipment to ensure optimal performance and longevity.</p>
                                    <ul>
                                        <li>Pump and motor maintenance</li>
                                        <li>Filter cleaning and maintenance</li>
                                        <li>Heater inspection and service</li>
                                        <li>Automation system programming</li>
                                        <li>Salt chlorine generator maintenance</li>
                                        <li>Equipment troubleshooting and repair</li>
                                    </ul>
                                </div>
                                
                                <div class="service-card">
                                    <div class="service-icon"><i class="fa fa-calendar"></i></div>
                                    <h3>Seasonal Services</h3>
                                    <p>We offer specialized services for opening and closing your pool, as well as maintenance during the off-season.</p>
                                    <ul>
                                        <li>Spring opening</li>
                                        <li>Fall closing</li>
                                        <li>Winter maintenance</li>
                                        <li>Seasonal equipment adjustments</li>
                                        <li>Cover cleaning and maintenance</li>
                                        <li>Freeze protection</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <h3>Service Plans</h3>
                            <div class="service-plans">
                                <div class="plan-card">
                                    <div class="plan-header">
                                        <h4>Basic Plan</h4>
                                        <div class="plan-price">Starting at $150/month</div>
                                    </div>
                                    <div class="plan-features">
                                        <ul>
                                            <li>Weekly service visits</li>
                                            <li>Basic water testing</li>
                                            <li>Chemical balancing</li>
                                            <li>Surface cleaning</li>
                                            <li>Equipment inspection</li>
                                        </ul>
                                    </div>
                                    <div class="plan-footer">
                                        <a href="#contact" class="btn">Request Quote</a>
                                    </div>
                                </div>
                                
                                <div class="plan-card featured-plan">
                                    <div class="plan-header">
                                        <h4>Premium Plan</h4>
                                        <div class="plan-price">Starting at $250/month</div>
                                    </div>
                                    <div class="plan-features">
                                        <ul>
                                            <li>Twice-weekly service visits</li>
                                            <li>Comprehensive water testing</li>
                                            <li>Premium chemical treatment</li>
                                            <li>Complete cleaning service</li>
                                            <li>Equipment maintenance</li>
                                            <li>Monthly detailed report</li>
                                            <li>Priority scheduling</li>
                                        </ul>
                                    </div>
                                    <div class="plan-footer">
                                        <a href="#contact" class="btn btn-primary">Request Quote</a>
                                    </div>
                                </div>
                                
                                <div class="plan-card">
                                    <div class="plan-header">
                                        <h4>Community Plan</h4>
                                        <div class="plan-price">Custom Pricing</div>
                                    </div>
                                    <div class="plan-features">
                                        <ul>
                                            <li>Tailored service schedule</li>
                                            <li>Comprehensive water testing</li>
                                            <li>Chemical management</li>
                                            <li>Complete cleaning service</li>
                                            <li>Equipment maintenance</li>
                                            <li>Board meeting attendance</li>
                                            <li>Monthly detailed reports</li>
                                            <li>24/7 emergency support</li>
                                        </ul>
                                    </div>
                                    <div class="plan-footer">
                                        <a href="#contact" class="btn">Request Quote</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="gallery" class="tab-pane">
                            <h2>Project Gallery</h2>
                            <p>Browse through our gallery to see examples of our work and the communities we serve.</p>
                            
                            <div class="gallery-grid">
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-1.jpg" alt="Community Pool Maintenance">
                                    <div class="gallery-caption">Community Pool Maintenance - Roswell Heights</div>
                                </div>
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-2.jpg" alt="Equipment Upgrade">
                                    <div class="gallery-caption">Equipment Upgrade - Marietta Gardens</div>
                                </div>
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-3.jpg" alt="Water Feature Installation">
                                    <div class="gallery-caption">Water Feature Installation - Alpharetta Commons</div>
                                </div>
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-4.jpg" alt="Pool Renovation">
                                    <div class="gallery-caption">Pool Renovation - Dunwoody Village</div>
                                </div>
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-5.jpg" alt="Chemical Management">
                                    <div class="gallery-caption">Chemical Management - Sandy Springs Estates</div>
                                </div>
                                <div class="gallery-item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery-placeholder-6.jpg" alt="Seasonal Opening">
                                    <div class="gallery-caption">Seasonal Opening - Decatur Heights</div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="reviews" class="tab-pane">
                            <h2>Customer Reviews</h2>
                            <div class="reviews-summary">
                                <div class="rating-summary">
                                    <div class="overall-rating">
                                        <div class="rating-number">4.5</div>
                                        <div class="rating-stars">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>
                                        <div class="rating-count">Based on 24 reviews</div>
                                    </div>
                                    <div class="rating-breakdown">
                                        <div class="rating-row">
                                            <span class="rating-label">5 Stars</span>
                                            <div class="rating-bar">
                                                <div class="rating-fill" style="width: 75%;"></div>
                                            </div>
                                            <span class="rating-percent">75%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span class="rating-label">4 Stars</span>
                                            <div class="rating-bar">
                                                <div class="rating-fill" style="width: 15%;"></div>
                                            </div>
                                            <span class="rating-percent">15%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span class="rating-label">3 Stars</span>
                                            <div class="rating-bar">
                                                <div class="rating-fill" style="width: 5%;"></div>
                                            </div>
                                            <span class="rating-percent">5%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span class="rating-label">2 Stars</span>
                                            <div class="rating-bar">
                                                <div class="rating-fill" style="width: 3%;"></div>
                                            </div>
                                            <span class="rating-percent">3%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span class="rating-label">1 Star</span>
                                            <div class="rating-bar">
                                                <div class="rating-fill" style="width: 2%;"></div>
                                            </div>
                                            <span class="rating-percent">2%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (is_user_logged_in()): ?>
                                <div class="write-review">
                                    <h3>Write a Review</h3>
                                    <form class="review-form">
                                        <div class="form-field">
                                            <label>Your Rating</label>
                                            <div class="rating-select">
                                                <i class="fa fa-star-o" data-rating="1"></i>
                                                <i class="fa fa-star-o" data-rating="2"></i>
                                                <i class="fa fa-star-o" data-rating="3"></i>
                                                <i class="fa fa-star-o" data-rating="4"></i>
                                                <i class="fa fa-star-o" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="form-field">
                                            <label for="review-title">Review Title</label>
                                            <input type="text" id="review-title" name="review-title" placeholder="Summarize your experience">
                                        </div>
                                        <div class="form-field">
                                            <label for="review-content">Your Review</label>
                                            <textarea id="review-content" name="review-content" rows="5" placeholder="Describe your experience with this vendor"></textarea>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Submit Review</button>
                                        </div>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="reviews-list">
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Reviewer Avatar">
                                            </div>
                                            <div class="reviewer-meta">
                                                <div class="reviewer-name">John Smith</div>
                                                <div class="reviewer-role">Board Member</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="rating-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="review-date">March 15, 2025</div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <h4 class="review-title">Excellent service and reliability</h4>
                                        <p>Crystal Clear Pools has been maintaining our community pool for the past three years, and we couldn't be happier with their service. They are always punctual, thorough, and responsive to our needs. The pool water is consistently clean and properly balanced, and they've been proactive in identifying and addressing potential issues before they become problems.</p>
                                        <p>Their team is knowledgeable and professional, and they've been great about working with our board to stay within our budget while still providing top-notch service. I highly recommend them to any community association looking for reliable pool maintenance.</p>
                                    </div>
                                </div>
                                
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Reviewer Avatar">
                                            </div>
                                            <div class="reviewer-meta">
                                                <div class="reviewer-name">Sarah Johnson</div>
                                                <div class="reviewer-role">CAM Professional</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="rating-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="review-date">February 28, 2025</div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <h4 class="review-title">Professional and dependable</h4>
                                        <p>As a community association manager, I've worked with many pool maintenance companies over the years, and Crystal Clear Pools stands out as one of the best. They are extremely professional, dependable, and thorough in their work.</p>
                                        <p>What I appreciate most is their communication. They provide detailed reports after each service visit, and they're always available to answer questions or address concerns. They've also been great about attending board meetings when requested to discuss maintenance issues or upcoming projects.</p>
                                        <p>I currently have them servicing three of my communities, and all three boards are very satisfied with their work. Highly recommended!</p>
                                    </div>
                                </div>
                                
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="Reviewer Avatar">
                                            </div>
                                            <div class="reviewer-meta">
                                                <div class="reviewer-name">Michael Brown</div>
                                                <div class="reviewer-role">Board Member</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="rating-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                            <div class="review-date">January 12, 2025</div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <h4 class="review-title">Good service but room for improvement</h4>
                                        <p>Crystal Clear Pools has been maintaining our community pool for about six months now. Overall, they do a good job with the basic maintenance and chemical balancing, and the pool has been clean and safe for our residents.</p>
                                        <p>The reason for the three-star rating is that we've had some issues with communication and scheduling. There have been a few instances where service visits were missed without notice, and it sometimes takes longer than expected to get a response to emails or phone calls.</p>
                                        <p>That said, when they do respond, they're always apologetic and quick to resolve any issues. I believe they're a good company that may just be experiencing some growing pains. We're sticking with them for now and hoping to see improvement in these areas.</p>
                                    </div>
                                </div>
                                
                                <div class="review-pagination">
                                    <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                                    <span class="pagination-current">Page 1 of 8</span>
                                    <a href="#" class="pagination-next">Next &raquo;</a>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contact" class="tab-pane">
                            <h2>Contact Information</h2>
                            <div class="contact-info">
                                <div class="contact-details">
                                    <div class="contact-item">
                                        <div class="contact-icon"><i class="fa fa-map-marker"></i></div>
                                        <div class="contact-text">
                                            <h4>Address</h4>
                                            <p>1234 Pool Service Lane<br>Atlanta, GA 30328</p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon"><i class="fa fa-phone"></i></div>
                                        <div class="contact-text">
                                            <h4>Phone</h4>
                                            <p><a href="tel:+14045551234">(404) 555-1234</a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon"><i class="fa fa-envelope"></i></div>
                                        <div class="contact-text">
                                            <h4>Email</h4>
                                            <p><a href="mailto:info@crystalclearpools.com">info@crystalclearpools.com</a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon"><i class="fa fa-globe"></i></div>
                                        <div class="contact-text">
                                            <h4>Website</h4>
                                            <p><a href="https://www.crystalclearpools.com" target="_blank">www.crystalclearpools.com</a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon"><i class="fa fa-clock-o"></i></div>
                                        <div class="contact-text">
                                            <h4>Business Hours</h4>
                                            <p>Monday - Friday: 8:00 AM - 5:00 PM<br>
                                            Saturday: 9:00 AM - 2:00 PM<br>
                                            Sunday: Closed</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact-form-container">
                                    <h3>Send a Message</h3>
                                    <form class="contact-form">
                                        <div class="form-field">
                                            <label for="contact-name">Your Name</label>
                                            <input type="text" id="contact-name" name="contact-name" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="contact-email">Your Email</label>
                                            <input type="email" id="contact-email" name="contact-email" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="contact-phone">Your Phone</label>
                                            <input type="tel" id="contact-phone" name="contact-phone">
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="contact-subject">Subject</label>
                                            <input type="text" id="contact-subject" name="contact-subject" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="contact-message">Message</label>
                                            <textarea id="contact-message" name="contact-message" rows="5" required></textarea>
                                        </div>
                                        
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="vendor-map">
                                <h3>Location</h3>
                                <div class="map-container">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/map-placeholder.jpg" alt="Map Location">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="vendor-sidebar">
                <div class="sidebar-card">
                    <h3>Quick Contact</h3>
                    <div class="quick-contact">
                        <div class="contact-method">
                            <i class="fa fa-phone"></i>
                            <a href="tel:+14045551234">(404) 555-1234</a>
                        </div>
                        <div class="contact-method">
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:info@crystalclearpools.com">info@crystalclearpools.com</a>
                        </div>
                        <div class="contact-method">
                            <i class="fa fa-globe"></i>
                            <a href="https://www.crystalclearpools.com" target="_blank">www.crystalclearpools.com</a>
                        </div>
                    </div>
                    <div class="quick-actions">
                        <a href="#contact" class="btn btn-block btn-primary">Request a Quote</a>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3>Business Information</h3>
                    <div class="business-info">
                        <div class="info-item">
                            <span class="info-label">Founded</span>
                            <span class="info-value">2005</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Employees</span>
                            <span class="info-value">15-20</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Service Area</span>
                            <span class="info-value">Greater Atlanta Area</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">License #</span>
                            <span class="info-value">GA-CPO-12345</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Insurance</span>
                            <span class="info-value">$2M Liability</span>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3>Certifications</h3>
                    <div class="certifications">
                        <div class="certification-item">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/certification-placeholder.png" alt="CPO Certification">
                            <span class="certification-name">Certified Pool Operator</span>
                        </div>
                        <div class="certification-item">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/certification-placeholder.png" alt="APSP Certification">
                            <span class="certification-name">APSP Member</span>
                        </div>
                        <div class="certification-item">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/certification-placeholder.png" alt="BBB Certification">
                            <span class="certification-name">BBB Accredited A+</span>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3>Similar Vendors</h3>
                    <div class="similar-vendors">
                        <div class="similar-vendor">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h4><a href="#">Blue Water Pool Services</a></h4>
                                <div class="vendor-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span class="rating-count">(18)</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="similar-vendor">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h4><a href="#">Aqua Experts</a></h4>
                                <div class="vendor-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span class="rating-count">(31)</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="similar-vendor">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h4><a href="#">Splash Pool Services</a></h4>
                                <div class="vendor-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span class="rating-count">(7)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// PHP 8.4 compatible JavaScript for tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabLinks = document.querySelectorAll('.tabs-nav a');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            tabLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
            });
            
            // Hide all tab panes
            tabPanes.forEach(function(pane) {
                pane.classList.remove('active');
            });
            
            // Add active class to clicked tab
            this.parentElement.classList.add('active');
            
            // Show corresponding tab pane
            const targetId = this.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('active');
        });
    });
    
    // Rating selection functionality
    const ratingStars = document.querySelectorAll('.rating-select i');
    
    ratingStars.forEach(function(star) {
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            
            ratingStars.forEach(function(s, index) {
                if (index < rating) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                } else {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                }
            });
        });
        
        star.addEventListener('mouseout', function() {
            const selectedRating = document.querySelector('.rating-select').getAttribute('data-selected-rating');
            
            if (!selectedRating) {
                ratingStars.forEach(function(s) {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                });
            } else {
                ratingStars.forEach(function(s, index) {
                    if (index < parseInt(selectedRating)) {
                        s.classList.remove('fa-star-o');
                        s.classList.add('fa-star');
                    } else {
                        s.classList.remove('fa-star');
                        s.classList.add('fa-star-o');
                    }
                });
            }
        });
        
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            document.querySelector('.rating-select').setAttribute('data-selected-rating', rating);
            
            ratingStars.forEach(function(s, index) {
                if (index < rating) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                } else {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                }
            });
        });
    });
});
</script>

<?php
get_footer();
