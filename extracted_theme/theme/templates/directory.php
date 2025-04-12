<?php
/**
 * Template Name: Vendor Directory
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="directory-container">
    <div class="directory-header">
        <div class="container">
            <h1 class="directory-title">Vendor Directory</h1>
            <div class="directory-actions">
                <?php if (current_user_can('contributor')): ?>
                <a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>" class="btn btn-primary">Edit My Listing</a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-secondary">View RFPs</a>
            </div>
        </div>
    </div>

    <div class="directory-content">
        <div class="container">
            <div class="directory-search-filters">
                <div class="search-container">
                    <form class="directory-search-form" method="get">
                        <div class="search-field">
                            <input type="text" name="search" placeholder="Search vendors..." value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                
                <div class="filter-container">
                    <form class="directory-filter-form" method="get">
                        <div class="filter-group">
                            <label for="category">Category</label>
                            <select id="category" name="category">
                                <option value="">All Categories</option>
                                <option value="maintenance" <?php selected(isset($_GET['category']) && $_GET['category'] === 'maintenance'); ?>>Maintenance</option>
                                <option value="landscaping" <?php selected(isset($_GET['category']) && $_GET['category'] === 'landscaping'); ?>>Landscaping</option>
                                <option value="security" <?php selected(isset($_GET['category']) && $_GET['category'] === 'security'); ?>>Security</option>
                                <option value="renovation" <?php selected(isset($_GET['category']) && $_GET['category'] === 'renovation'); ?>>Renovation</option>
                                <option value="management" <?php selected(isset($_GET['category']) && $_GET['category'] === 'management'); ?>>Management</option>
                                <option value="legal" <?php selected(isset($_GET['category']) && $_GET['category'] === 'legal'); ?>>Legal</option>
                                <option value="financial" <?php selected(isset($_GET['category']) && $_GET['category'] === 'financial'); ?>>Financial</option>
                                <option value="other" <?php selected(isset($_GET['category']) && $_GET['category'] === 'other'); ?>>Other</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <select id="location" name="location">
                                <option value="">All Locations</option>
                                <option value="atlanta" <?php selected(isset($_GET['location']) && $_GET['location'] === 'atlanta'); ?>>Atlanta, GA</option>
                                <option value="marietta" <?php selected(isset($_GET['location']) && $_GET['location'] === 'marietta'); ?>>Marietta, GA</option>
                                <option value="roswell" <?php selected(isset($_GET['location']) && $_GET['location'] === 'roswell'); ?>>Roswell, GA</option>
                                <option value="alpharetta" <?php selected(isset($_GET['location']) && $_GET['location'] === 'alpharetta'); ?>>Alpharetta, GA</option>
                                <option value="decatur" <?php selected(isset($_GET['location']) && $_GET['location'] === 'decatur'); ?>>Decatur, GA</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="rating">Minimum Rating</label>
                            <select id="rating" name="rating">
                                <option value="">Any Rating</option>
                                <option value="5" <?php selected(isset($_GET['rating']) && $_GET['rating'] === '5'); ?>>5 Stars</option>
                                <option value="4" <?php selected(isset($_GET['rating']) && $_GET['rating'] === '4'); ?>>4+ Stars</option>
                                <option value="3" <?php selected(isset($_GET['rating']) && $_GET['rating'] === '3'); ?>>3+ Stars</option>
                                <option value="2" <?php selected(isset($_GET['rating']) && $_GET['rating'] === '2'); ?>>2+ Stars</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-filter">Apply Filters</button>
                            <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-text">Clear Filters</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="directory-featured">
                <h2 class="section-title">Featured Vendors</h2>
                <div class="featured-vendors">
                    <div class="vendor-card featured">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="<?php echo esc_url(home_url('/directory/crystal-clear-pools/')); ?>">Crystal Clear Pools</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Pool Maintenance</span>
                                    <span class="vendor-location">Atlanta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <span class="rating-count">(24 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Crystal Clear Pools provides professional pool maintenance services for community associations and residential properties. Our services include regular cleaning, chemical balancing, equipment maintenance, and repairs.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="<?php echo esc_url(home_url('/directory/crystal-clear-pools/')); ?>" class="btn">View Profile</a>
                            <a href="mailto:info@crystalclearpools.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card featured">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Green Thumb Landscaping</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Landscaping</span>
                                    <span class="vendor-location">Marietta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span class="rating-count">(31 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Green Thumb Landscaping offers comprehensive landscaping services for community associations. Our team of experts provides lawn maintenance, seasonal plantings, irrigation system maintenance, and landscape design.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@greenthumblandscaping.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card featured">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Secure Solutions</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Security</span>
                                    <span class="vendor-location">Atlanta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span class="rating-count">(18 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Secure Solutions provides comprehensive security services for community associations, including access control systems, surveillance cameras, security personnel, and security assessments.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@securesolutions.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="directory-listings">
                <h2 class="section-title">All Vendors</h2>
                <div class="vendor-list">
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Blue Water Pool Services</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Pool Maintenance</span>
                                    <span class="vendor-location">Marietta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span class="rating-count">(18 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Blue Water Pool Services offers complete pool maintenance solutions for community associations. Our team provides weekly service visits, comprehensive water testing, and equipment maintenance.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@bluewaterpools.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Aqua Experts</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Pool Maintenance</span>
                                    <span class="vendor-location">Roswell, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span class="rating-count">(31 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Aqua Experts provides premium pool maintenance services for community associations. Our comprehensive service includes twice-weekly visits during peak season, advanced water chemistry management, and equipment optimization.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@aquaexperts.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Splash Pool Services</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Pool Maintenance</span>
                                    <span class="vendor-location">Alpharetta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span class="rating-count">(7 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Splash Pool Services offers cost-effective pool maintenance solutions for community associations. Our services include weekly cleaning, basic water testing, and routine maintenance.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@splashpools.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Evergreen Landscaping</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Landscaping</span>
                                    <span class="vendor-location">Atlanta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <span class="rating-count">(22 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Evergreen Landscaping provides professional landscaping services for community associations. Our team specializes in lawn maintenance, seasonal plantings, tree care, and landscape design.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@evergreenlandscaping.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Guardian Security</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Security</span>
                                    <span class="vendor-location">Decatur, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span class="rating-count">(15 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Guardian Security offers comprehensive security solutions for community associations. Our services include access control systems, surveillance cameras, security personnel, and security assessments.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@guardiansecurity.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                    
                    <div class="vendor-card">
                        <div class="vendor-header">
                            <div class="vendor-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="vendor-info">
                                <h3 class="vendor-name"><a href="#">Community Management Solutions</a></h3>
                                <div class="vendor-meta">
                                    <span class="vendor-category">Management</span>
                                    <span class="vendor-location">Atlanta, GA</span>
                                    <span class="vendor-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span class="rating-count">(29 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="vendor-content">
                            <p>Community Management Solutions provides professional management services for community associations. Our team offers financial management, vendor coordination, board support, and resident services.</p>
                        </div>
                        <div class="vendor-footer">
                            <a href="#" class="btn">View Profile</a>
                            <a href="mailto:info@communitymanagementsolutions.com" class="btn btn-secondary">Contact</a>
                        </div>
                    </div>
                </div>
                
                <div class="directory-pagination">
                    <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                    <span class="pagination-current">Page 1 of 3</span>
                    <a href="#" class="pagination-next">Next &raquo;</a>
                </div>
            </div>
            
            <div class="directory-categories">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <a href="<?php echo esc_url(home_url('/directory/?category=maintenance')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-wrench"></i></div>
                        <h3 class="category-name">Maintenance</h3>
                        <span class="category-count">15 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=landscaping')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-leaf"></i></div>
                        <h3 class="category-name">Landscaping</h3>
                        <span class="category-count">12 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=security')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-shield"></i></div>
                        <h3 class="category-name">Security</h3>
                        <span class="category-count">8 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=renovation')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-home"></i></div>
                        <h3 class="category-name">Renovation</h3>
                        <span class="category-count">10 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=management')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-users"></i></div>
                        <h3 class="category-name">Management</h3>
                        <span class="category-count">7 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=legal')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-gavel"></i></div>
                        <h3 class="category-name">Legal</h3>
                        <span class="category-count">5 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=financial')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-money"></i></div>
                        <h3 class="category-name">Financial</h3>
                        <span class="category-count">6 vendors</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/directory/?category=other')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-plus-circle"></i></div>
                        <h3 class="category-name">Other</h3>
                        <span class="category-count">9 vendors</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
