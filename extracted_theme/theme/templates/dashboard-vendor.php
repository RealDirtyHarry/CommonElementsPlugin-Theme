<?php
/**
 * Template Name: Vendor Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="dashboard-container vendor-dashboard">
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">Vendor Dashboard</h1>
            <div class="dashboard-actions">
                <a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>" class="btn btn-primary">Edit Directory Listing</a>
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-secondary">View Open RFPs</a>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <!-- Vendor Overview -->
                <div class="dashboard-card dashboard-overview">
                    <h2 class="card-title">Vendor Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value">15</span>
                            <span class="stat-label">Open RFPs</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">8</span>
                            <span class="stat-label">My Proposals</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">3</span>
                            <span class="stat-label">Awarded Projects</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">245</span>
                            <span class="stat-label">Directory Views</span>
                        </div>
                    </div>
                </div>

                <!-- Directory Listing -->
                <div class="dashboard-card">
                    <h2 class="card-title">Directory Listing</h2>
                    <div class="directory-preview">
                        <div class="directory-header">
                            <div class="directory-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo">
                            </div>
                            <div class="directory-info">
                                <h3 class="directory-name">Crystal Clear Pools</h3>
                                <div class="directory-meta">
                                    <span class="directory-category">Pool Maintenance</span>
                                    <span class="directory-location">Atlanta, GA</span>
                                    <span class="directory-rating">
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
                        <div class="directory-content">
                            <p>Crystal Clear Pools provides professional pool maintenance services for community associations and residential properties. Our services include regular cleaning, chemical balancing, equipment maintenance, and repairs.</p>
                        </div>
                        <div class="directory-stats">
                            <div class="stat-item">
                                <span class="stat-label">Profile Views</span>
                                <span class="stat-value">245</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Contact Clicks</span>
                                <span class="stat-value">32</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Last Updated</span>
                                <span class="stat-value">Mar 15, 2025</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>" class="btn btn-text">Edit Listing</a>
                    </div>
                </div>

                <!-- Open RFPs -->
                <div class="dashboard-card">
                    <h2 class="card-title">Open RFPs</h2>
                    <div class="rfp-list">
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Pool Maintenance Services</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Oakwood Heights</span>
                                <span class="rfp-date">Posted: Apr 2, 2025</span>
                                <span class="rfp-deadline">Deadline: Apr 16, 2025</span>
                            </div>
                            <div class="rfp-actions">
                                <a href="#" class="btn btn-sm">Submit Proposal</a>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Pool Equipment Replacement</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Riverside Gardens</span>
                                <span class="rfp-date">Posted: Mar 28, 2025</span>
                                <span class="rfp-deadline">Deadline: Apr 11, 2025</span>
                            </div>
                            <div class="rfp-actions">
                                <a href="#" class="btn btn-sm">Submit Proposal</a>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Pool Resurfacing Project</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Maple Ridge Estates</span>
                                <span class="rfp-date">Posted: Mar 25, 2025</span>
                                <span class="rfp-deadline">Deadline: Apr 8, 2025</span>
                            </div>
                            <div class="rfp-actions">
                                <a href="#" class="btn btn-sm">Submit Proposal</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-text">View All Open RFPs</a>
                    </div>
                </div>

                <!-- My Proposals -->
                <div class="dashboard-card">
                    <h2 class="card-title">My Proposals</h2>
                    <div class="proposal-list">
                        <div class="proposal-item">
                            <div class="proposal-status proposal-status-pending">Pending</div>
                            <div class="proposal-details">
                                <h3 class="proposal-title"><a href="#">Pool Maintenance Services - Sunset Villas</a></h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Apr 5, 2025</span>
                                    <span class="proposal-amount">$12,500/year</span>
                                </div>
                            </div>
                            <div class="proposal-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="proposal-item">
                            <div class="proposal-status proposal-status-pending">Pending</div>
                            <div class="proposal-details">
                                <h3 class="proposal-title"><a href="#">Pool Equipment Replacement - Pinecrest Commons</a></h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Mar 30, 2025</span>
                                    <span class="proposal-amount">$8,750</span>
                                </div>
                            </div>
                            <div class="proposal-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="proposal-item">
                            <div class="proposal-status proposal-status-awarded">Awarded</div>
                            <div class="proposal-details">
                                <h3 class="proposal-title"><a href="#">Pool Maintenance Services - Oakwood Heights</a></h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Mar 15, 2025</span>
                                    <span class="proposal-amount">$14,200/year</span>
                                </div>
                            </div>
                            <div class="proposal-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="proposal-item">
                            <div class="proposal-status proposal-status-declined">Declined</div>
                            <div class="proposal-details">
                                <h3 class="proposal-title"><a href="#">Pool Resurfacing - Riverside Gardens</a></h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Feb 28, 2025</span>
                                    <span class="proposal-amount">$32,500</span>
                                </div>
                            </div>
                            <div class="proposal-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-text">View All Proposals</a>
                    </div>
                </div>

                <!-- Reviews & Ratings -->
                <div class="dashboard-card">
                    <h2 class="card-title">Reviews & Ratings</h2>
                    <div class="reviews-summary">
                        <div class="rating-overview">
                            <div class="rating-score">4.5</div>
                            <div class="rating-stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <div class="rating-count">24 reviews</div>
                        </div>
                        <div class="rating-breakdown">
                            <div class="rating-item">
                                <span class="rating-label">5 Stars</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" style="width: 75%;"></div>
                                </div>
                                <span class="rating-count">18</span>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">4 Stars</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" style="width: 12.5%;"></div>
                                </div>
                                <span class="rating-count">3</span>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">3 Stars</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" style="width: 8.3%;"></div>
                                </div>
                                <span class="rating-count">2</span>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">2 Stars</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" style="width: 4.2%;"></div>
                                </div>
                                <span class="rating-count">1</span>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">1 Star</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" style="width: 0%;"></div>
                                </div>
                                <span class="rating-count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="recent-reviews">
                        <h3>Recent Reviews</h3>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">Oakwood Heights HOA</div>
                                <div class="review-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="review-date">Mar 20, 2025</div>
                            </div>
                            <div class="review-content">
                                <p>Crystal Clear Pools has been maintaining our community pool for the past year, and we couldn't be happier with their service. They are responsive, thorough, and always go above and beyond.</p>
                            </div>
                        </div>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">Riverside Gardens HOA</div>
                                <div class="review-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="review-date">Feb 15, 2025</div>
                            </div>
                            <div class="review-content">
                                <p>Good service overall. They maintain our pool well, but sometimes communication could be better when scheduling special maintenance.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-text">View All Reviews</a>
                    </div>
                </div>

                <!-- Vendor Forum -->
                <div class="dashboard-card">
                    <h2 class="card-title">Vendor Networking</h2>
                    <div class="forum-topics">
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Best practices for responding to RFPs</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: David Wilson</span>
                                <span class="topic-replies">14 Replies</span>
                                <span class="topic-date">Last activity: 2 days ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Working with community managers effectively</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Jennifer Lee</span>
                                <span class="topic-replies">22 Replies</span>
                                <span class="topic-date">Last activity: 4 days ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Insurance requirements for community contracts</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Michael Brown</span>
                                <span class="topic-replies">8 Replies</span>
                                <span class="topic-date">Last activity: 6 days ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/forums/vendor-networking/')); ?>" class="btn btn-text">Visit Vendor Forums</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
