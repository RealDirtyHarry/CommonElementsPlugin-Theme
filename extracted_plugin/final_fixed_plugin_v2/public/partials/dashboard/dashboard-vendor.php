<?php
/**
 * Vendor Dashboard Template
 *
 * This template displays the dashboard for vendors.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Check if user is logged in and has appropriate role
if ( ! is_user_logged_in() ) {
    wp_redirect( wp_login_url( get_permalink() ) );
    exit;
}

$user = wp_get_current_user();
$roles = (array) $user->roles;

if ( ! in_array( 'contributor', $roles ) ) {
    wp_redirect( home_url() );
    exit;
}

get_header();
?>

<div class="ce-dashboard">
    <div class="ce-container">
        <div class="ce-dashboard-header">
            <h1 class="ce-dashboard-title">Vendor Dashboard</h1>
            <div class="ce-dashboard-actions">
                <a href="<?php echo esc_url( home_url( '/directory/my-listing' ) ); ?>" class="ce-btn ce-btn-primary">Manage My Listing</a>
                <a href="<?php echo esc_url( home_url( '/rfp' ) ); ?>" class="ce-btn ce-btn-outline-primary">View Open RFPs</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="ce-dashboard-sidebar">
                    <ul class="ce-dashboard-nav">
                        <li class="ce-dashboard-nav-item">
                            <a href="#overview" class="ce-dashboard-nav-link active" data-toggle="tab">Overview</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#rfps" class="ce-dashboard-nav-link" data-toggle="tab">Open RFPs</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#proposals" class="ce-dashboard-nav-link" data-toggle="tab">My Proposals</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#directory" class="ce-dashboard-nav-link" data-toggle="tab">My Directory Listing</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#learning" class="ce-dashboard-nav-link" data-toggle="tab">Learning Hub</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="ce-dashboard-main">
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane active" id="overview">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Dashboard Overview</h2>
                                
                                <div class="ce-stats-grid">
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">12</div>
                                        <div class="ce-stat-label">Open RFPs</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">5</div>
                                        <div class="ce-stat-label">My Proposals</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">28</div>
                                        <div class="ce-stat-label">Profile Views</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">4.8</div>
                                        <div class="ce-stat-label">Rating (out of 5)</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Recent Activity</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-body">
                                        <ul class="ce-activity-list">
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New RFP Posted</div>
                                                    <div class="ce-activity-description">Landscaping Services for Oakwood Heights</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">2 hours ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-paper-plane"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">Proposal Submitted</div>
                                                    <div class="ce-activity-description">Pool Maintenance RFP</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">Yesterday</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-eye"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">Directory Listing Viewed</div>
                                                    <div class="ce-activity-description">Your listing was viewed 5 times</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">2 days ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New Review Received</div>
                                                    <div class="ce-activity-description">5-star review from Riverside Gardens</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">3 days ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Upcoming Deadlines</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-body">
                                        <ul class="ce-deadline-list">
                                            <li class="ce-deadline-item">
                                                <div class="ce-deadline-date">
                                                    <span class="ce-deadline-day">17</span>
                                                    <span class="ce-deadline-month">Apr</span>
                                                </div>
                                                <div class="ce-deadline-content">
                                                    <div class="ce-deadline-title">Pool Maintenance RFP Closes</div>
                                                    <div class="ce-deadline-description">Oakwood Heights Community Association</div>
                                                    <div class="ce-deadline-meta">
                                                        <span class="ce-deadline-status">Proposal Submitted</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-deadline-item">
                                                <div class="ce-deadline-date">
                                                    <span class="ce-deadline-day">20</span>
                                                    <span class="ce-deadline-month">Apr</span>
                                                </div>
                                                <div class="ce-deadline-content">
                                                    <div class="ce-deadline-title">Landscaping Services RFP Closes</div>
                                                    <div class="ce-deadline-description">Oakwood Heights Community Association</div>
                                                    <div class="ce-deadline-meta">
                                                        <span class="ce-deadline-status ce-status-warning">No Proposal Yet</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-deadline-item">
                                                <div class="ce-deadline-date">
                                                    <span class="ce-deadline-day">28</span>
                                                    <span class="ce-deadline-month">Apr</span>
                                                </div>
                                                <div class="ce-deadline-content">
                                                    <div class="ce-deadline-title">Elevator Modernization RFP Closes</div>
                                                    <div class="ce-deadline-description">Riverside Gardens Community Association</div>
                                                    <div class="ce-deadline-meta">
                                                        <span class="ce-deadline-status ce-status-warning">No Proposal Yet</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Open RFPs Tab -->
                        <div class="tab-pane" id="rfps">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Open Request for Proposals</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Available RFPs</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-rfp-filters">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="ce-form-group">
                                                        <label class="ce-form-label">Category</label>
                                                        <select class="ce-form-select">
                                                            <option value="">All Categories</option>
                                                            <option value="maintenance">Maintenance</option>
                                                            <option value="landscaping">Landscaping</option>
                                                            <option value="security">Security</option>
                                                            <option value="renovation">Renovation</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="ce-form-group">
                                                        <label class="ce-form-label">Community</label>
                                                        <select class="ce-form-select">
                                                            <option value="">All Communities</option>
                                                            <option value="oakwood">Oakwood Heights</option>
                                                            <option value="riverside">Riverside Gardens</option>
                                                            <option value="maple">Maple Ridge Estates</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="ce-form-group">
                                                        <label class="ce-form-label">Due Date</label>
                                                        <select class="ce-form-select">
                                                            <option value="">Any Due Date</option>
                                                            <option value="7">Next 7 Days</option>
                                                            <option value="14">Next 14 Days</option>
                                                            <option value="30">Next 30 Days</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="ce-rfp-list">
                                            <div class="ce-rfp-item">
                                                <div class="ce-rfp-header">
                                                    <h3 class="ce-rfp-title">Landscaping Services</h3>
                                                    <div class="ce-rfp-status">
                                                        <span class="ce-badge ce-badge-success">Open</span>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-body">
                                                    <div class="ce-rfp-meta">
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Community</div>
                                                            <div class="ce-rfp-meta-value">Oakwood Heights</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Posted Date</div>
                                                            <div class="ce-rfp-meta-value">Apr 5, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Due Date</div>
                                                            <div class="ce-rfp-meta-value">Apr 20, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Category</div>
                                                            <div class="ce-rfp-meta-value">Maintenance</div>
                                                        </div>
                                                    </div>
                                                    <div class="ce-rfp-description">
                                                        <p>Seeking professional landscaping services for community common areas, including lawn maintenance, seasonal plantings, and irrigation system management.</p>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                    <a href="#" class="ce-btn ce-btn-secondary">Submit Proposal</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-rfp-item">
                                                <div class="ce-rfp-header">
                                                    <h3 class="ce-rfp-title">Pool Maintenance</h3>
                                                    <div class="ce-rfp-status">
                                                        <span class="ce-badge ce-badge-success">Open</span>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-body">
                                                    <div class="ce-rfp-meta">
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Community</div>
                                                            <div class="ce-rfp-meta-value">Oakwood Heights</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Posted Date</div>
                                                            <div class="ce-rfp-meta-value">Apr 2, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Due Date</div>
                                                            <div class="ce-rfp-meta-value">Apr 17, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Category</div>
                                                            <div class="ce-rfp-meta-value">Maintenance</div>
                                                        </div>
                                                    </div>
                                                    <div class="ce-rfp-description">
                                                        <p>Looking for qualified pool maintenance services for community swimming pool, including chemical treatment, cleaning, and equipment maintenance.</p>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                    <span class="ce-proposal-status">Proposal Submitted</span>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-rfp-item">
                                                <div class="ce-rfp-header">
                                                    <h3 class="ce-rfp-title">Elevator Modernization</h3>
                                                    <div class="ce-rfp-status">
                                                        <span class="ce-badge ce-badge-success">Open</span>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-body">
                                                    <div class="ce-rfp-meta">
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Community</div>
                                                            <div class="ce-rfp-meta-value">Riverside Gardens</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Posted Date</div>
                                                            <div class="ce-rfp-meta-value">Mar 28, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Due Date</div>
                                                            <div class="ce-rfp-meta-value">Apr 28, 2025</div>
                                                        </div>
                                                        <div class="ce-rfp-meta-item">
                                                            <div class="ce-rfp-meta-label">Category</div>
                                                            <div class="ce-rfp-meta-value">Capital Improvement</div>
                                                        </div>
                                                    </div>
                                                    <div class="ce-rfp-description">
                                                        <p>Seeking proposals for elevator modernization project in a 5-story residential building, including control system upgrade, cab renovation, and ADA compliance improvements.</p>
                                                    </div>
                                                </div>
                                                <div class="ce-rfp-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                    <a href="#" class="ce-btn ce-btn-secondary">Submit Proposal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- My Proposals Tab -->
                        <div class="tab-pane" id="proposals">
                            <div class="ce-section">
                                <h2 class="ce-section-title">My Proposals</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Submitted Proposals</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <table class="ce-table ce-table-striped ce-table-hover">
                                            <thead>
                                                <tr>
                                                    <th>RFP Title</th>
                                                    <th>Community</th>
                                                    <th>Submitted Date</th>
                                                    <th>Bid Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pool Maintenance</td>
                                                    <td>Oakwood Heights</td>
                                                    <td>Apr 10, 2025</td>
                                                    <td>$12,500</td>
                                                    <td><span class="ce-badge ce-badge-warning">Pending Review</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Security System Upgrade</td>
                                                    <td>Maple Ridge Estates</td>
                                                    <td>Apr 2, 2025</td>
                                                    <td>$35,750</td>
                                                    <td><span class="ce-badge ce-badge-success">Accepted</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Roof Replacement</td>
                                                    <td>Riverside Gardens</td>
                                                    <td>Mar 15, 2025</td>
                                                    <td>$78,200</td>
                                                    <td><span class="ce-badge ce-badge-danger">Rejected</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Parking Lot Resurfacing</td>
                                                    <td>Oakwood Heights</td>
                                                    <td>Feb 28, 2025</td>
                                                    <td>$42,500</td>
                                                    <td><span class="ce-badge ce-badge-success">Accepted</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Clubhouse Renovation</td>
                                                    <td>Maple Ridge Estates</td>
                                                    <td>Jan 15, 2025</td>
                                                    <td>$125,000</td>
                                                    <td><span class="ce-badge ce-badge-info">Completed</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Directory Listing Tab -->
                        <div class="tab-pane" id="directory">
                            <div class="ce-section">
                                <h2 class="ce-section-title">My Directory Listing</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Listing Preview</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-directory-preview">
                                            <div class="ce-directory-preview-header">
                                                <img src="https://via.placeholder.com/800x400" alt="Company Banner" class="ce-directory-preview-banner">
                                            </div>
                                            <div class="ce-directory-preview-body">
                                                <div class="ce-directory-preview-logo">
                                                    <img src="https://via.placeholder.com/150x150" alt="Company Logo">
                                                </div>
                                                <div class="ce-directory-preview-content">
                                                    <h3 class="ce-directory-preview-title">Your Company Name</h3>
                                                    <div class="ce-directory-preview-category">Maintenance & Repair</div>
                                                    <div class="ce-directory-preview-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                        <span>(4.8)</span>
                                                    </div>
                                                    <div class="ce-directory-preview-description">
                                                        <p>Your company description appears here. This should be a compelling summary of your services, expertise, and what makes your company unique in the industry.</p>
                                                    </div>
                                                    <div class="ce-directory-preview-details">
                                                        <div class="ce-directory-preview-detail">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <span>123 Business Street, City, State ZIP</span>
                                                        </div>
                                                        <div class="ce-directory-preview-detail">
                                                            <i class="fas fa-phone"></i>
                                                            <span>(555) 123-4567</span>
                                                        </div>
                                                        <div class="ce-directory-preview-detail">
                                                            <i class="fas fa-envelope"></i>
                                                            <span>contact@yourcompany.com</span>
                                                        </div>
                                                        <div class="ce-directory-preview-detail">
                                                            <i class="fas fa-globe"></i>
                                                            <span>www.yourcompany.com</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="<?php echo esc_url( home_url( '/directory/my-listing/edit' ) ); ?>" class="ce-btn ce-btn-primary">Edit Listing</a>
                                        <a href="<?php echo esc_url( home_url( '/directory/my-listing' ) ); ?>" class="ce-btn ce-btn-outline-primary">View Public Listing</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Listing Performance</h2>
                                
                                <div class="ce-stats-grid">
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">28</div>
                                        <div class="ce-stat-label">Profile Views</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">12</div>
                                        <div class="ce-stat-label">Contact Clicks</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">8</div>
                                        <div class="ce-stat-label">Website Visits</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">5</div>
                                        <div class="ce-stat-label">Reviews</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Customer Reviews</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-body">
                                        <div class="ce-reviews-list">
                                            <div class="ce-review-item">
                                                <div class="ce-review-header">
                                                    <div class="ce-review-author">Riverside Gardens</div>
                                                    <div class="ce-review-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div class="ce-review-date">April 8, 2025</div>
                                                <div class="ce-review-content">
                                                    <p>Excellent service! The team was professional, on time, and completed the work to our exact specifications. Would highly recommend to other communities.</p>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-review-item">
                                                <div class="ce-review-header">
                                                    <div class="ce-review-author">Oakwood Heights</div>
                                                    <div class="ce-review-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="ce-review-date">March 15, 2025</div>
                                                <div class="ce-review-content">
                                                    <p>Very satisfied with the parking lot resurfacing project. The work was completed on schedule and within budget. The only minor issue was some initial miscommunication about the timeline.</p>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-review-item">
                                                <div class="ce-review-header">
                                                    <div class="ce-review-author">Maple Ridge Estates</div>
                                                    <div class="ce-review-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div class="ce-review-date">January 30, 2025</div>
                                                <div class="ce-review-content">
                                                    <p>The clubhouse renovation exceeded our expectations. The attention to detail and quality of workmanship was outstanding. Our residents are thrilled with the results.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Learning Hub Tab -->
                        <div class="tab-pane" id="learning">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Vendor Education</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Recommended Courses</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-courses-grid">
                                            <div class="ce-course-card">
                                                <img src="https://via.placeholder.com/300x200" alt="HOA Vendor Best Practices" class="ce-course-image">
                                                <div class="ce-course-body">
                                                    <h3 class="ce-course-title">HOA Vendor Best Practices</h3>
                                                    <div class="ce-course-instructor">By John Smith</div>
                                                    <div class="ce-course-description">Learn how to effectively work with HOAs and community associations to build long-term relationships.</div>
                                                    <div class="ce-course-meta">
                                                        <span><i class="fas fa-users"></i> 87 Enrolled</span>
                                                        <span><i class="fas fa-clock"></i> 3 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Course</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-course-card">
                                                <img src="https://via.placeholder.com/300x200" alt="Winning RFP Strategies" class="ce-course-image">
                                                <div class="ce-course-body">
                                                    <h3 class="ce-course-title">Winning RFP Strategies</h3>
                                                    <div class="ce-course-instructor">By Sarah Johnson</div>
                                                    <div class="ce-course-description">Master the art of creating compelling proposals that stand out from the competition.</div>
                                                    <div class="ce-course-meta">
                                                        <span><i class="fas fa-users"></i> 112 Enrolled</span>
                                                        <span><i class="fas fa-clock"></i> 4 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Course</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-course-card">
                                                <img src="https://via.placeholder.com/300x200" alt="Community Association Law for Vendors" class="ce-course-image">
                                                <div class="ce-course-body">
                                                    <h3 class="ce-course-title">Community Association Law for Vendors</h3>
                                                    <div class="ce-course-instructor">By Michael Brown</div>
                                                    <div class="ce-course-description">Understand the legal framework that governs community associations and how it affects vendors.</div>
                                                    <div class="ce-course-meta">
                                                        <span><i class="fas fa-users"></i> 64 Enrolled</span>
                                                        <span><i class="fas fa-clock"></i> 5 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="<?php echo esc_url( home_url( '/learning-hub' ) ); ?>" class="ce-btn ce-btn-primary">View All Courses</a>
                                    </div>
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
    // Simple tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.ce-dashboard-nav-link');
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                tabLinks.forEach(function(tab) {
                    tab.classList.remove('active');
                });
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding tab content
                const tabId = this.getAttribute('href').substring(1);
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<?php get_footer(); ?>
