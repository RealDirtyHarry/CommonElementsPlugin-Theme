<?php
/**
 * CAM Professional Dashboard Template
 *
 * This template displays the dashboard for CAM professionals.
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

if ( ! in_array( 'author', $roles ) ) {
    wp_redirect( home_url() );
    exit;
}

get_header();
?>

<div class="ce-dashboard">
    <div class="ce-container">
        <div class="ce-dashboard-header">
            <h1 class="ce-dashboard-title">CAM Professional Dashboard</h1>
            <div class="ce-dashboard-actions">
                <a href="<?php echo esc_url( home_url( '/rfp/new' ) ); ?>" class="ce-btn ce-btn-primary">Create New RFP</a>
                <a href="<?php echo esc_url( home_url( '/directory' ) ); ?>" class="ce-btn ce-btn-outline-primary">View Directory</a>
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
                            <a href="#communities" class="ce-dashboard-nav-link" data-toggle="tab">My Communities</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#rfps" class="ce-dashboard-nav-link" data-toggle="tab">RFPs</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#vendors" class="ce-dashboard-nav-link" data-toggle="tab">Vendors</a>
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
                                        <div class="ce-stat-value">3</div>
                                        <div class="ce-stat-label">Communities</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">8</div>
                                        <div class="ce-stat-label">Active RFPs</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">24</div>
                                        <div class="ce-stat-label">Vendor Relationships</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">75%</div>
                                        <div class="ce-stat-label">Learning Progress</div>
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
                                                    <div class="ce-activity-title">New RFP Submitted</div>
                                                    <div class="ce-activity-description">Landscaping Services for Oakwood Heights</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">2 hours ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-reply"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New Proposal Received</div>
                                                    <div class="ce-activity-description">Pool Maintenance RFP</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">Yesterday</span>
                                                        <span class="ce-activity-user">from Aqua Services Inc.</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">Community Added</div>
                                                    <div class="ce-activity-description">Maple Ridge Estates</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">2 days ago</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">Course Completed</div>
                                                    <div class="ce-activity-description">CAM Legal Responsibilities</div>
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
                                <h2 class="ce-section-title">Upcoming Tasks</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-body">
                                        <ul class="ce-task-list">
                                            <li class="ce-task-item">
                                                <div class="ce-task-checkbox">
                                                    <input type="checkbox" id="task1" class="ce-form-check-input">
                                                </div>
                                                <div class="ce-task-content">
                                                    <label for="task1" class="ce-task-title">Review Pool Maintenance Proposals</label>
                                                    <div class="ce-task-meta">
                                                        <span class="ce-task-due">Due: Apr 15, 2025</span>
                                                        <span class="ce-task-priority ce-priority-high">High Priority</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-task-item">
                                                <div class="ce-task-checkbox">
                                                    <input type="checkbox" id="task2" class="ce-form-check-input">
                                                </div>
                                                <div class="ce-task-content">
                                                    <label for="task2" class="ce-task-title">Prepare Board Meeting Agenda</label>
                                                    <div class="ce-task-meta">
                                                        <span class="ce-task-due">Due: Apr 18, 2025</span>
                                                        <span class="ce-task-priority ce-priority-medium">Medium Priority</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-task-item">
                                                <div class="ce-task-checkbox">
                                                    <input type="checkbox" id="task3" class="ce-form-check-input">
                                                </div>
                                                <div class="ce-task-content">
                                                    <label for="task3" class="ce-task-title">Schedule Community Inspection</label>
                                                    <div class="ce-task-meta">
                                                        <span class="ce-task-due">Due: Apr 20, 2025</span>
                                                        <span class="ce-task-priority ce-priority-medium">Medium Priority</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-task-item">
                                                <div class="ce-task-checkbox">
                                                    <input type="checkbox" id="task4" class="ce-form-check-input">
                                                </div>
                                                <div class="ce-task-content">
                                                    <label for="task4" class="ce-task-title">Complete CAM Certification Course</label>
                                                    <div class="ce-task-meta">
                                                        <span class="ce-task-due">Due: Apr 30, 2025</span>
                                                        <span class="ce-task-priority ce-priority-low">Low Priority</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="#" class="ce-btn ce-btn-primary">Add New Task</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Communities Tab -->
                        <div class="tab-pane" id="communities">
                            <div class="ce-section">
                                <h2 class="ce-section-title">My Communities</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Assigned Communities</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-community-grid">
                                            <div class="ce-community-card">
                                                <div class="ce-community-header">
                                                    <h3 class="ce-community-name">Oakwood Heights</h3>
                                                    <span class="ce-badge ce-badge-success">Active</span>
                                                </div>
                                                <div class="ce-community-body">
                                                    <div class="ce-community-info">
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Units:</span>
                                                            <span class="ce-community-info-value">124</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Board Members:</span>
                                                            <span class="ce-community-info-value">5</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Active RFPs:</span>
                                                            <span class="ce-community-info-value">3</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ce-community-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-community-card">
                                                <div class="ce-community-header">
                                                    <h3 class="ce-community-name">Riverside Gardens</h3>
                                                    <span class="ce-badge ce-badge-success">Active</span>
                                                </div>
                                                <div class="ce-community-body">
                                                    <div class="ce-community-info">
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Units:</span>
                                                            <span class="ce-community-info-value">86</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Board Members:</span>
                                                            <span class="ce-community-info-value">3</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Active RFPs:</span>
                                                            <span class="ce-community-info-value">2</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ce-community-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-community-card">
                                                <div class="ce-community-header">
                                                    <h3 class="ce-community-name">Maple Ridge Estates</h3>
                                                    <span class="ce-badge ce-badge-success">Active</span>
                                                </div>
                                                <div class="ce-community-body">
                                                    <div class="ce-community-info">
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Units:</span>
                                                            <span class="ce-community-info-value">210</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Board Members:</span>
                                                            <span class="ce-community-info-value">7</span>
                                                        </div>
                                                        <div class="ce-community-info-item">
                                                            <span class="ce-community-info-label">Active RFPs:</span>
                                                            <span class="ce-community-info-value">3</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ce-community-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Community Calendar</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Upcoming Events</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <table class="ce-table ce-table-striped ce-table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Community</th>
                                                    <th>Event</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Apr 15, 2025</td>
                                                    <td>7:00 PM</td>
                                                    <td>Oakwood Heights</td>
                                                    <td>Board Meeting</td>
                                                    <td>Community Clubhouse</td>
                                                </tr>
                                                <tr>
                                                    <td>Apr 18, 2025</td>
                                                    <td>10:00 AM</td>
                                                    <td>Riverside Gardens</td>
                                                    <td>Landscape Committee</td>
                                                    <td>Virtual Meeting</td>
                                                </tr>
                                                <tr>
                                                    <td>Apr 20, 2025</td>
                                                    <td>9:00 AM</td>
                                                    <td>Maple Ridge Estates</td>
                                                    <td>Community Inspection</td>
                                                    <td>Property Grounds</td>
                                                </tr>
                                                <tr>
                                                    <td>Apr 22, 2025</td>
                                                    <td>6:30 PM</td>
                                                    <td>Maple Ridge Estates</td>
                                                    <td>Board Meeting</td>
                                                    <td>Community Center</td>
                                                </tr>
                                                <tr>
                                                    <td>Apr 25, 2025</td>
                                                    <td>7:00 PM</td>
                                                    <td>Riverside Gardens</td>
                                                    <td>Annual Meeting</td>
                                                    <td>Community Clubhouse</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="#" class="ce-btn ce-btn-primary">Add New Event</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- RFPs Tab -->
                        <div class="tab-pane" id="rfps">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Request for Proposals</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Active RFPs</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <table class="ce-table ce-table-striped ce-table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Community</th>
                                                    <th>Posted Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Landscaping Services</td>
                                                    <td>Oakwood Heights</td>
                                                    <td>Apr 5, 2025</td>
                                                    <td>Apr 20, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pool Maintenance</td>
                                                    <td>Oakwood Heights</td>
                                                    <td>Apr 2, 2025</td>
                                                    <td>Apr 17, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Elevator Modernization</td>
                                                    <td>Riverside Gardens</td>
                                                    <td>Mar 28, 2025</td>
                                                    <td>Apr 28, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Security System Upgrade</td>
                                                    <td>Maple Ridge Estates</td>
                                                    <td>Mar 15, 2025</td>
                                                    <td>Apr 5, 2025</td>
                                                    <td><span class="ce-badge ce-badge-secondary">Awarded</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Roof Replacement</td>
                                                    <td>Riverside Gardens</td>
                                                    <td>Feb 20, 2025</td>
                                                    <td>Mar 20, 2025</td>
                                                    <td><span class="ce-badge ce-badge-info">Closed</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="<?php echo esc_url( home_url( '/rfp/new' ) ); ?>" class="ce-btn ce-btn-primary">Create New RFP</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vendors Tab -->
                        <div class="tab-pane" id="vendors">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Vendor Directory</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Preferred Vendors</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-directory-filters">
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
                                                        <label class="ce-form-label">Rating</label>
                                                        <select class="ce-form-select">
                                                            <option value="">Any Rating</option>
                                                            <option value="5">5 Stars</option>
                                                            <option value="4">4+ Stars</option>
                                                            <option value="3">3+ Stars</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="ce-form-group">
                                                        <label class="ce-form-label">Search</label>
                                                        <input type="text" class="ce-form-control" placeholder="Search vendors...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="ce-directory-grid">
                                            <div class="ce-directory-item">
                                                <img src="https://via.placeholder.com/300x200" alt="Aqua Services Inc." class="ce-directory-item-image">
                                                <div class="ce-directory-item-body">
                                                    <h3 class="ce-directory-item-title">Aqua Services Inc.</h3>
                                                    <div class="ce-directory-item-category">Pool Maintenance</div>
                                                    <div class="ce-directory-item-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                        <span>(4.5)</span>
                                                    </div>
                                                    <div class="ce-directory-item-description">Professional pool maintenance and repair services for community associations.</div>
                                                </div>
                                                <div class="ce-directory-item-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Profile</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-directory-item">
                                                <img src="https://via.placeholder.com/300x200" alt="Green Thumb Landscaping" class="ce-directory-item-image">
                                                <div class="ce-directory-item-body">
                                                    <h3 class="ce-directory-item-title">Green Thumb Landscaping</h3>
                                                    <div class="ce-directory-item-category">Landscaping</div>
                                                    <div class="ce-directory-item-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span>(5.0)</span>
                                                    </div>
                                                    <div class="ce-directory-item-description">Complete landscaping services including design, installation, and maintenance.</div>
                                                </div>
                                                <div class="ce-directory-item-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Profile</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-directory-item">
                                                <img src="https://via.placeholder.com/300x200" alt="SecureTech Solutions" class="ce-directory-item-image">
                                                <div class="ce-directory-item-body">
                                                    <h3 class="ce-directory-item-title">SecureTech Solutions</h3>
                                                    <div class="ce-directory-item-category">Security</div>
                                                    <div class="ce-directory-item-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <span>(4.0)</span>
                                                    </div>
                                                    <div class="ce-directory-item-description">Security system installation, monitoring, and maintenance for communities.</div>
                                                </div>
                                                <div class="ce-directory-item-footer">
                                                    <a href="#" class="ce-btn ce-btn-primary">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="<?php echo esc_url( home_url( '/directory' ) ); ?>" class="ce-btn ce-btn-primary">View Full Directory</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Learning Hub Tab -->
                        <div class="tab-pane" id="learning">
                            <div class="ce-section">
                                <h2 class="ce-section-title">My Learning Progress</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">CAM Certification Progress</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <div class="ce-course-progress">
                                            <div class="ce-progress-bar">
                                                <div class="ce-progress-bar-fill" style="width: 75%;"></div>
                                            </div>
                                            <div class="ce-progress-text">
                                                <span>75% Complete</span>
                                                <span>9/12 Courses</span>
                                            </div>
                                        </div>
                                        
                                        <div class="ce-course-list">
                                            <div class="ce-course-item">
                                                <div class="ce-course-status completed">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="ce-course-info">
                                                    <h4 class="ce-course-title">CAM Legal Responsibilities</h4>
                                                    <div class="ce-course-meta">
                                                        <span>Completed: Apr 8, 2025</span>
                                                        <span>Score: 92%</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-actions">
                                                    <a href="#" class="ce-btn ce-btn-sm ce-btn-outline-primary">View Certificate</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-course-item">
                                                <div class="ce-course-status completed">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="ce-course-info">
                                                    <h4 class="ce-course-title">Financial Management for CAMs</h4>
                                                    <div class="ce-course-meta">
                                                        <span>Completed: Mar 25, 2025</span>
                                                        <span>Score: 88%</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-actions">
                                                    <a href="#" class="ce-btn ce-btn-sm ce-btn-outline-primary">View Certificate</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-course-item">
                                                <div class="ce-course-status in-progress">
                                                    <i class="fas fa-spinner"></i>
                                                </div>
                                                <div class="ce-course-info">
                                                    <h4 class="ce-course-title">Vendor Management Best Practices</h4>
                                                    <div class="ce-course-meta">
                                                        <span>Progress: 60%</span>
                                                        <span>3/5 Lessons Completed</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-actions">
                                                    <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">Continue</a>
                                                </div>
                                            </div>
                                            
                                            <div class="ce-course-item">
                                                <div class="ce-course-status not-started">
                                                    <i class="fas fa-circle"></i>
                                                </div>
                                                <div class="ce-course-info">
                                                    <h4 class="ce-course-title">Conflict Resolution in Communities</h4>
                                                    <div class="ce-course-meta">
                                                        <span>Not Started</span>
                                                        <span>Estimated Time: 4 hours</span>
                                                    </div>
                                                </div>
                                                <div class="ce-course-actions">
                                                    <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">Start Course</a>
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
