<?php
/**
 * Template Name: Board Member Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="dashboard-container board-dashboard">
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">Board Member Dashboard</h1>
            <div class="dashboard-actions">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-primary">Create New RFP</a>
                <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-secondary">Vendor Directory</a>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <!-- Overview Stats -->
                <div class="dashboard-card dashboard-overview">
                    <h2 class="card-title">Community Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value">24</span>
                            <span class="stat-label">Active RFPs</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">156</span>
                            <span class="stat-label">Vendor Proposals</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">432</span>
                            <span class="stat-label">Community Members</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">18</span>
                            <span class="stat-label">Recent Forum Posts</span>
                        </div>
                    </div>
                </div>

                <!-- Recent RFPs -->
                <div class="dashboard-card">
                    <h2 class="card-title">Recent RFPs</h2>
                    <div class="rfp-list">
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Pool Maintenance Services</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-date">Posted: Apr 2, 2025</span>
                                <span class="rfp-proposals">12 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Landscaping Contract</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-date">Posted: Mar 28, 2025</span>
                                <span class="rfp-proposals">8 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-closed">Closed</div>
                            <h3 class="rfp-title"><a href="#">Security System Upgrade</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-date">Posted: Mar 15, 2025</span>
                                <span class="rfp-proposals">15 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-awarded">Awarded</div>
                            <h3 class="rfp-title"><a href="#">Clubhouse Renovation</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-date">Posted: Feb 28, 2025</span>
                                <span class="rfp-proposals">9 Proposals</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-text">View All RFPs</a>
                    </div>
                </div>

                <!-- Financial Overview -->
                <div class="dashboard-card">
                    <h2 class="card-title">Financial Overview</h2>
                    <div class="financial-summary">
                        <div class="financial-item">
                            <span class="financial-label">Annual Budget</span>
                            <span class="financial-value">$1,250,000</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">YTD Expenses</span>
                            <span class="financial-value">$425,000</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">Reserve Fund</span>
                            <span class="financial-value">$750,000</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">Outstanding Dues</span>
                            <span class="financial-value">$32,500</span>
                        </div>
                    </div>
                    <div class="financial-chart">
                        <!-- Placeholder for chart -->
                        <div class="chart-placeholder">
                            <div class="chart-bar" style="height: 60%;"></div>
                            <div class="chart-bar" style="height: 80%;"></div>
                            <div class="chart-bar" style="height: 45%;"></div>
                            <div class="chart-bar" style="height: 70%;"></div>
                            <div class="chart-bar" style="height: 55%;"></div>
                            <div class="chart-bar" style="height: 65%;"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-text">View Financial Reports</a>
                    </div>
                </div>

                <!-- Recent Proposals -->
                <div class="dashboard-card">
                    <h2 class="card-title">Recent Proposals</h2>
                    <div class="proposal-list">
                        <div class="proposal-item">
                            <div class="proposal-vendor">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                                <span class="vendor-name">Crystal Clear Pools</span>
                            </div>
                            <div class="proposal-details">
                                <h3 class="proposal-title">Pool Maintenance Services</h3>
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
                            <div class="proposal-vendor">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                                <span class="vendor-name">Green Thumb Landscaping</span>
                            </div>
                            <div class="proposal-details">
                                <h3 class="proposal-title">Landscaping Contract</h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Apr 3, 2025</span>
                                    <span class="proposal-amount">$36,000/year</span>
                                </div>
                            </div>
                            <div class="proposal-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="proposal-item">
                            <div class="proposal-vendor">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="Vendor Logo" class="vendor-logo">
                                <span class="vendor-name">Secure Home Systems</span>
                            </div>
                            <div class="proposal-details">
                                <h3 class="proposal-title">Security System Upgrade</h3>
                                <div class="proposal-meta">
                                    <span class="proposal-date">Submitted: Mar 20, 2025</span>
                                    <span class="proposal-amount">$45,750</span>
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

                <!-- Community Forum -->
                <div class="dashboard-card">
                    <h2 class="card-title">Community Forum</h2>
                    <div class="forum-topics">
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Best practices for community pool maintenance</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: John Smith</span>
                                <span class="topic-replies">12 Replies</span>
                                <span class="topic-date">Last activity: 2 days ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Recommended vendors for landscaping services</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Sarah Johnson</span>
                                <span class="topic-replies">8 Replies</span>
                                <span class="topic-date">Last activity: 3 days ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">New regulations affecting HOA governance</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Michael Brown</span>
                                <span class="topic-replies">15 Replies</span>
                                <span class="topic-date">Last activity: 5 days ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/forums/')); ?>" class="btn btn-text">Visit Forums</a>
                    </div>
                </div>

                <!-- Learning Hub -->
                <div class="dashboard-card">
                    <h2 class="card-title">Learning Hub</h2>
                    <div class="learning-courses">
                        <div class="course-item">
                            <div class="course-image">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="Course Image">
                            </div>
                            <div class="course-details">
                                <h3 class="course-title"><a href="#">Board Member Certification</a></h3>
                                <div class="course-meta">
                                    <span class="course-lessons">8 Lessons</span>
                                    <span class="course-progress">75% Complete</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 75%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="course-item">
                            <div class="course-image">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="Course Image">
                            </div>
                            <div class="course-details">
                                <h3 class="course-title"><a href="#">Financial Management for HOAs</a></h3>
                                <div class="course-meta">
                                    <span class="course-lessons">6 Lessons</span>
                                    <span class="course-progress">50% Complete</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 50%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/learning-hub/')); ?>" class="btn btn-text">View All Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
