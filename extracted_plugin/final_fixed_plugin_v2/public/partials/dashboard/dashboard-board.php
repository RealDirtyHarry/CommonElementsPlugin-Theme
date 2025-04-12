<?php
/**
 * Board Member Dashboard Template
 *
 * This template displays the dashboard for board members.
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

if ( ! in_array( 'administrator', $roles ) && ! in_array( 'editor', $roles ) ) {
    wp_redirect( home_url() );
    exit;
}

get_header();
?>

<div class="ce-dashboard">
    <div class="ce-container">
        <div class="ce-dashboard-header">
            <h1 class="ce-dashboard-title">Board Member Dashboard</h1>
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
                            <a href="#rfps" class="ce-dashboard-nav-link" data-toggle="tab">RFPs</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#proposals" class="ce-dashboard-nav-link" data-toggle="tab">Proposals</a>
                        </li>
                        <li class="ce-dashboard-nav-item">
                            <a href="#community" class="ce-dashboard-nav-link" data-toggle="tab">Community</a>
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
                                        <div class="ce-stat-value">5</div>
                                        <div class="ce-stat-label">Active RFPs</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">12</div>
                                        <div class="ce-stat-label">New Proposals</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">1,250</div>
                                        <div class="ce-stat-label">Community Members</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">24</div>
                                        <div class="ce-stat-label">Learning Courses</div>
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
                                                        <span class="ce-activity-user">by John Smith</span>
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
                                                        <span class="ce-activity-user">by Aqua Services Inc.</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New Vendor Registered</div>
                                                    <div class="ce-activity-description">Green Thumb Landscaping</div>
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
                                                    <div class="ce-activity-title">RFP Awarded</div>
                                                    <div class="ce-activity-description">Security System Upgrade</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">3 days ago</span>
                                                        <span class="ce-activity-user">to SecureTech Solutions</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
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
                                                    <th>Category</th>
                                                    <th>Posted Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Landscaping Services</td>
                                                    <td>Maintenance</td>
                                                    <td>Apr 5, 2025</td>
                                                    <td>Apr 20, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pool Maintenance</td>
                                                    <td>Maintenance</td>
                                                    <td>Apr 2, 2025</td>
                                                    <td>Apr 17, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Elevator Modernization</td>
                                                    <td>Capital Improvement</td>
                                                    <td>Mar 28, 2025</td>
                                                    <td>Apr 28, 2025</td>
                                                    <td><span class="ce-badge ce-badge-success">Open</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Security System Upgrade</td>
                                                    <td>Security</td>
                                                    <td>Mar 15, 2025</td>
                                                    <td>Apr 5, 2025</td>
                                                    <td><span class="ce-badge ce-badge-secondary">Awarded</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Roof Replacement</td>
                                                    <td>Capital Improvement</td>
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
                        
                        <!-- Proposals Tab -->
                        <div class="tab-pane" id="proposals">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Vendor Proposals</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-header">
                                        <div class="ce-card-title">Recent Proposals</div>
                                    </div>
                                    <div class="ce-card-body">
                                        <table class="ce-table ce-table-striped ce-table-hover">
                                            <thead>
                                                <tr>
                                                    <th>RFP Title</th>
                                                    <th>Vendor</th>
                                                    <th>Submitted Date</th>
                                                    <th>Bid Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pool Maintenance</td>
                                                    <td>Aqua Services Inc.</td>
                                                    <td>Apr 10, 2025</td>
                                                    <td>$12,500</td>
                                                    <td><span class="ce-badge ce-badge-warning">Pending Review</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pool Maintenance</td>
                                                    <td>Blue Wave Pools</td>
                                                    <td>Apr 8, 2025</td>
                                                    <td>$14,200</td>
                                                    <td><span class="ce-badge ce-badge-warning">Pending Review</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Landscaping Services</td>
                                                    <td>Green Thumb Landscaping</td>
                                                    <td>Apr 7, 2025</td>
                                                    <td>$24,000</td>
                                                    <td><span class="ce-badge ce-badge-warning">Pending Review</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Security System Upgrade</td>
                                                    <td>SecureTech Solutions</td>
                                                    <td>Apr 2, 2025</td>
                                                    <td>$35,750</td>
                                                    <td><span class="ce-badge ce-badge-success">Accepted</span></td>
                                                    <td>
                                                        <a href="#" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Security System Upgrade</td>
                                                    <td>Guardian Security</td>
                                                    <td>Apr 1, 2025</td>
                                                    <td>$42,100</td>
                                                    <td><span class="ce-badge ce-badge-danger">Rejected</span></td>
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
                        
                        <!-- Community Tab -->
                        <div class="tab-pane" id="community">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Community Statistics</h2>
                                
                                <div class="ce-stats-grid">
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">1,250</div>
                                        <div class="ce-stat-label">Total Members</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">875</div>
                                        <div class="ce-stat-label">Active Members</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">3,240</div>
                                        <div class="ce-stat-label">Total Posts</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">645</div>
                                        <div class="ce-stat-label">Total Topics</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Recent Forum Activity</h2>
                                
                                <div class="ce-card">
                                    <div class="ce-card-body">
                                        <ul class="ce-activity-list">
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-comments"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New Topic: Pool Safety Guidelines</div>
                                                    <div class="ce-activity-description">Discussion about updated pool safety guidelines for the summer season.</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">1 hour ago</span>
                                                        <span class="ce-activity-user">by Sarah Johnson</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-reply"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">Reply: Community Garden Project</div>
                                                    <div class="ce-activity-description">Response to the proposal for starting a community garden.</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">3 hours ago</span>
                                                        <span class="ce-activity-user">by Michael Brown</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="ce-activity-item">
                                                <div class="ce-activity-icon">
                                                    <i class="fas fa-comments"></i>
                                                </div>
                                                <div class="ce-activity-content">
                                                    <div class="ce-activity-title">New Topic: Electric Vehicle Charging Stations</div>
                                                    <div class="ce-activity-description">Proposal to install EV charging stations in the community parking areas.</div>
                                                    <div class="ce-activity-meta">
                                                        <span class="ce-activity-time">Yesterday</span>
                                                        <span class="ce-activity-user">by David Wilson</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ce-card-footer">
                                        <a href="<?php echo esc_url( home_url( '/forum' ) ); ?>" class="ce-btn ce-btn-primary">View All Forum Activity</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Learning Hub Tab -->
                        <div class="tab-pane" id="learning">
                            <div class="ce-section">
                                <h2 class="ce-section-title">Learning Hub Statistics</h2>
                                
                                <div class="ce-stats-grid">
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">24</div>
                                        <div class="ce-stat-label">Total Courses</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">430</div>
                                        <div class="ce-stat-label">Active Learners</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">1,875</div>
                                        <div class="ce-stat-label">Completed Courses</div>
                                    </div>
                                    <div class="ce-stat-card">
                                        <div class="ce-stat-value">1,245</div>
                                        <div class="ce-stat-label">Certificates Issued</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ce-section">
                                <h2 class="ce-section-title">Popular Courses</h2>
                                
                                <div class="ce-courses-grid">
                                    <div class="ce-course-card">
                                        <img src="https://via.placeholder.com/300x200" alt="Board Member Fundamentals" class="ce-course-image">
                                        <div class="ce-course-body">
                                            <h3 class="ce-course-title">Board Member Fundamentals</h3>
                                            <div class="ce-course-instructor">By John Smith</div>
                                            <div class="ce-course-description">Learn the essential responsibilities and best practices for community association board members.</div>
                                            <div class="ce-course-meta">
                                                <span><i class="fas fa-users"></i> 125 Enrolled</span>
                                                <span><i class="fas fa-clock"></i> 4 Hours</span>
                                            </div>
                                        </div>
                                        <div class="ce-course-footer">
                                            <a href="#" class="ce-btn ce-btn-primary">View Course</a>
                                        </div>
                                    </div>
                                    
                                    <div class="ce-course-card">
                                        <img src="https://via.placeholder.com/300x200" alt="Financial Management for HOAs" class="ce-course-image">
                                        <div class="ce-course-body">
                                            <h3 class="ce-course-title">Financial Management for HOAs</h3>
                                            <div class="ce-course-instructor">By Sarah Johnson</div>
                                            <div class="ce-course-description">Master the financial aspects of managing a homeowners association, including budgeting and reserves.</div>
                                            <div class="ce-course-meta">
                                                <span><i class="fas fa-users"></i> 98 Enrolled</span>
                                                <span><i class="fas fa-clock"></i> 6 Hours</span>
                                            </div>
                                        </div>
                                        <div class="ce-course-footer">
                                            <a href="#" class="ce-btn ce-btn-primary">View Course</a>
                                        </div>
                                    </div>
                                    
                                    <div class="ce-course-card">
                                        <img src="https://via.placeholder.com/300x200" alt="Effective Community Governance" class="ce-course-image">
                                        <div class="ce-course-body">
                                            <h3 class="ce-course-title">Effective Community Governance</h3>
                                            <div class="ce-course-instructor">By Michael Brown</div>
                                            <div class="ce-course-description">Explore strategies for creating and maintaining effective governance in community associations.</div>
                                            <div class="ce-course-meta">
                                                <span><i class="fas fa-users"></i> 87 Enrolled</span>
                                                <span><i class="fas fa-clock"></i> 5 Hours</span>
                                            </div>
                                        </div>
                                        <div class="ce-course-footer">
                                            <a href="#" class="ce-btn ce-btn-primary">View Course</a>
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
