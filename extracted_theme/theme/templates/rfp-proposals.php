<?php
/**
 * Template Name: RFP Proposals
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="rfp-container rfp-proposals">
    <div class="rfp-header">
        <div class="container">
            <div class="rfp-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>">RFPs</a> &raquo; 
                <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>">Pool Maintenance Services</a> &raquo; 
                Proposals
            </div>
            <div class="rfp-actions">
                <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>" class="btn btn-secondary">Back to RFP</a>
                <?php if (current_user_can('edit_others_posts')): ?>
                <a href="#" class="btn btn-primary">Award Contract</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="rfp-content">
        <div class="container">
            <h1 class="page-title">Proposals for: Pool Maintenance Services</h1>
            
            <div class="rfp-summary">
                <div class="rfp-meta">
                    <div class="meta-item">
                        <span class="meta-label">Status:</span>
                        <span class="meta-value status-open">Open</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Posted:</span>
                        <span class="meta-value">April 2, 2025</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Deadline:</span>
                        <span class="meta-value">April 16, 2025</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Community:</span>
                        <span class="meta-value">Oakwood Heights</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Proposals:</span>
                        <span class="meta-value">12 submitted</span>
                    </div>
                </div>
                <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>" class="btn btn-text">View Full RFP Details</a>
            </div>
            
            <div class="proposals-filters">
                <div class="filter-group">
                    <label for="sort-by">Sort By:</label>
                    <select id="sort-by" name="sort-by">
                        <option value="date-desc">Newest First</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="rating-desc">Rating: High to Low</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="filter-status">Status:</label>
                    <select id="filter-status" name="filter-status">
                        <option value="all">All Proposals</option>
                        <option value="under-review">Under Review</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="declined">Declined</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="button" class="btn btn-filter">Apply Filters</button>
                </div>
            </div>
            
            <div class="proposals-list">
                <div class="proposal-item">
                    <div class="proposal-status proposal-status-shortlisted">Shortlisted</div>
                    <div class="proposal-header">
                        <div class="proposal-vendor">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                            <div class="vendor-info">
                                <h2 class="vendor-name">Crystal Clear Pools</h2>
                                <div class="vendor-meta">
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
                        <div class="proposal-price">$12,500<span class="price-period">/year</span></div>
                    </div>
                    
                    <div class="proposal-details">
                        <h3>Crystal Clear Pools - Maintenance Services Proposal</h3>
                        <div class="proposal-meta">
                            <span class="proposal-date">Submitted: April 5, 2025</span>
                            <span class="proposal-timeline">May 1, 2025 - April 30, 2026</span>
                        </div>
                        <div class="proposal-summary">
                            <p>Crystal Clear Pools is pleased to submit this proposal for comprehensive pool maintenance services for Oakwood Heights. Our team of certified pool operators will ensure your community pool remains in pristine condition year-round. Our services include regular cleaning, chemical balancing, equipment maintenance, and prompt repairs.</p>
                        </div>
                        <div class="proposal-highlights">
                            <div class="highlight-item">
                                <span class="highlight-label">Experience:</span>
                                <span class="highlight-value">15+ years with community pools</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Certifications:</span>
                                <span class="highlight-value">CPO, NSPF, APSP</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Response Time:</span>
                                <span class="highlight-value">Same-day emergency service</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-actions">
                        <a href="#" class="btn">View Full Proposal</a>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <div class="admin-actions">
                            <button type="button" class="btn btn-sm btn-secondary">Shortlist</button>
                            <button type="button" class="btn btn-sm btn-primary">Award</button>
                            <button type="button" class="btn btn-sm btn-text">Decline</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="proposal-item">
                    <div class="proposal-status proposal-status-under-review">Under Review</div>
                    <div class="proposal-header">
                        <div class="proposal-vendor">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                            <div class="vendor-info">
                                <h2 class="vendor-name">Blue Water Pool Services</h2>
                                <div class="vendor-meta">
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
                        <div class="proposal-price">$13,800<span class="price-period">/year</span></div>
                    </div>
                    
                    <div class="proposal-details">
                        <h3>Comprehensive Pool Maintenance Proposal</h3>
                        <div class="proposal-meta">
                            <span class="proposal-date">Submitted: April 4, 2025</span>
                            <span class="proposal-timeline">May 1, 2025 - April 30, 2026</span>
                        </div>
                        <div class="proposal-summary">
                            <p>Blue Water Pool Services offers a complete pool maintenance solution for Oakwood Heights. Our team will provide weekly service visits, comprehensive water testing, equipment inspections, and preventative maintenance to ensure your pool operates efficiently and safely throughout the year.</p>
                        </div>
                        <div class="proposal-highlights">
                            <div class="highlight-item">
                                <span class="highlight-label">Experience:</span>
                                <span class="highlight-value">12 years with community pools</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Certifications:</span>
                                <span class="highlight-value">CPO, APSP</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Response Time:</span>
                                <span class="highlight-value">24-hour emergency service</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-actions">
                        <a href="#" class="btn">View Full Proposal</a>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <div class="admin-actions">
                            <button type="button" class="btn btn-sm btn-secondary">Shortlist</button>
                            <button type="button" class="btn btn-sm btn-primary">Award</button>
                            <button type="button" class="btn btn-sm btn-text">Decline</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="proposal-item">
                    <div class="proposal-status proposal-status-shortlisted">Shortlisted</div>
                    <div class="proposal-header">
                        <div class="proposal-vendor">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                            <div class="vendor-info">
                                <h2 class="vendor-name">Aqua Experts</h2>
                                <div class="vendor-meta">
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
                        <div class="proposal-price">$14,200<span class="price-period">/year</span></div>
                    </div>
                    
                    <div class="proposal-details">
                        <h3>Premium Pool Maintenance Package</h3>
                        <div class="proposal-meta">
                            <span class="proposal-date">Submitted: April 3, 2025</span>
                            <span class="proposal-timeline">May 1, 2025 - April 30, 2026</span>
                        </div>
                        <div class="proposal-summary">
                            <p>Aqua Experts is proud to offer our Premium Pool Maintenance Package for Oakwood Heights. Our comprehensive service includes twice-weekly visits during peak season, advanced water chemistry management, equipment optimization, and unlimited service calls. We also provide detailed monthly reports and quarterly presentations to the board.</p>
                        </div>
                        <div class="proposal-highlights">
                            <div class="highlight-item">
                                <span class="highlight-label">Experience:</span>
                                <span class="highlight-value">20+ years with community pools</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Certifications:</span>
                                <span class="highlight-value">CPO, NSPF, APSP, AFO</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Response Time:</span>
                                <span class="highlight-value">4-hour emergency service</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-actions">
                        <a href="#" class="btn">View Full Proposal</a>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <div class="admin-actions">
                            <button type="button" class="btn btn-sm btn-secondary">Shortlist</button>
                            <button type="button" class="btn btn-sm btn-primary">Award</button>
                            <button type="button" class="btn btn-sm btn-text">Decline</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="proposal-item">
                    <div class="proposal-status proposal-status-declined">Declined</div>
                    <div class="proposal-header">
                        <div class="proposal-vendor">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                            <div class="vendor-info">
                                <h2 class="vendor-name">Splash Pool Services</h2>
                                <div class="vendor-meta">
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
                        <div class="proposal-price">$10,800<span class="price-period">/year</span></div>
                    </div>
                    
                    <div class="proposal-details">
                        <h3>Basic Pool Maintenance Services</h3>
                        <div class="proposal-meta">
                            <span class="proposal-date">Submitted: April 3, 2025</span>
                            <span class="proposal-timeline">May 1, 2025 - April 30, 2026</span>
                        </div>
                        <div class="proposal-summary">
                            <p>Splash Pool Services offers a cost-effective pool maintenance solution for Oakwood Heights. Our services include weekly cleaning, basic water testing, and routine maintenance. Additional services available at extra cost.</p>
                        </div>
                        <div class="proposal-highlights">
                            <div class="highlight-item">
                                <span class="highlight-label">Experience:</span>
                                <span class="highlight-value">5 years with community pools</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Certifications:</span>
                                <span class="highlight-value">CPO</span>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-label">Response Time:</span>
                                <span class="highlight-value">48-hour emergency service</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-actions">
                        <a href="#" class="btn">View Full Proposal</a>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <div class="admin-actions">
                            <button type="button" class="btn btn-sm btn-secondary">Shortlist</button>
                            <button type="button" class="btn btn-sm btn-primary">Award</button>
                            <button type="button" class="btn btn-sm btn-text">Decline</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="proposals-pagination">
                <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                <span class="pagination-current">Page 1 of 3</span>
                <a href="#" class="pagination-next">Next &raquo;</a>
            </div>
            
            <div class="comparison-tools">
                <h2>Proposal Comparison</h2>
                <p>Select proposals to compare side-by-side</p>
                <div class="comparison-actions">
                    <button type="button" class="btn btn-primary" disabled>Compare Selected (0)</button>
                    <button type="button" class="btn btn-secondary">Compare All Shortlisted</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
