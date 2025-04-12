<?php
/**
 * Template Name: CAM Professional Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="dashboard-container cam-dashboard">
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">CAM Professional Dashboard</h1>
            <div class="dashboard-actions">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-primary">Create New RFP</a>
                <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-secondary">Vendor Directory</a>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <!-- Communities Overview -->
                <div class="dashboard-card dashboard-overview">
                    <h2 class="card-title">Communities Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value">5</span>
                            <span class="stat-label">Managed Communities</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">18</span>
                            <span class="stat-label">Active RFPs</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">124</span>
                            <span class="stat-label">Vendor Proposals</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">32</span>
                            <span class="stat-label">CE Credits</span>
                        </div>
                    </div>
                </div>

                <!-- Managed Communities -->
                <div class="dashboard-card">
                    <h2 class="card-title">Managed Communities</h2>
                    <div class="communities-list">
                        <div class="community-item">
                            <div class="community-details">
                                <h3 class="community-name"><a href="#">Oakwood Heights</a></h3>
                                <div class="community-meta">
                                    <span class="community-units">124 Units</span>
                                    <span class="community-location">Atlanta, GA</span>
                                </div>
                            </div>
                            <div class="community-stats">
                                <div class="community-stat">
                                    <span class="stat-label">RFPs</span>
                                    <span class="stat-value">5</span>
                                </div>
                                <div class="community-stat">
                                    <span class="stat-label">Tasks</span>
                                    <span class="stat-value">12</span>
                                </div>
                            </div>
                            <div class="community-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="community-item">
                            <div class="community-details">
                                <h3 class="community-name"><a href="#">Riverside Gardens</a></h3>
                                <div class="community-meta">
                                    <span class="community-units">86 Units</span>
                                    <span class="community-location">Marietta, GA</span>
                                </div>
                            </div>
                            <div class="community-stats">
                                <div class="community-stat">
                                    <span class="stat-label">RFPs</span>
                                    <span class="stat-value">3</span>
                                </div>
                                <div class="community-stat">
                                    <span class="stat-label">Tasks</span>
                                    <span class="stat-value">8</span>
                                </div>
                            </div>
                            <div class="community-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="community-item">
                            <div class="community-details">
                                <h3 class="community-name"><a href="#">Maple Ridge Estates</a></h3>
                                <div class="community-meta">
                                    <span class="community-units">210 Units</span>
                                    <span class="community-location">Roswell, GA</span>
                                </div>
                            </div>
                            <div class="community-stats">
                                <div class="community-stat">
                                    <span class="stat-label">RFPs</span>
                                    <span class="stat-value">7</span>
                                </div>
                                <div class="community-stat">
                                    <span class="stat-label">Tasks</span>
                                    <span class="stat-value">15</span>
                                </div>
                            </div>
                            <div class="community-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="community-item">
                            <div class="community-details">
                                <h3 class="community-name"><a href="#">Sunset Villas</a></h3>
                                <div class="community-meta">
                                    <span class="community-units">64 Units</span>
                                    <span class="community-location">Alpharetta, GA</span>
                                </div>
                            </div>
                            <div class="community-stats">
                                <div class="community-stat">
                                    <span class="stat-label">RFPs</span>
                                    <span class="stat-value">2</span>
                                </div>
                                <div class="community-stat">
                                    <span class="stat-label">Tasks</span>
                                    <span class="stat-value">9</span>
                                </div>
                            </div>
                            <div class="community-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="community-item">
                            <div class="community-details">
                                <h3 class="community-name"><a href="#">Pinecrest Commons</a></h3>
                                <div class="community-meta">
                                    <span class="community-units">142 Units</span>
                                    <span class="community-location">Dunwoody, GA</span>
                                </div>
                            </div>
                            <div class="community-stats">
                                <div class="community-stat">
                                    <span class="stat-label">RFPs</span>
                                    <span class="stat-value">4</span>
                                </div>
                                <div class="community-stat">
                                    <span class="stat-label">Tasks</span>
                                    <span class="stat-value">11</span>
                                </div>
                            </div>
                            <div class="community-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
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
                                <span class="rfp-community">Oakwood Heights</span>
                                <span class="rfp-date">Posted: Apr 2, 2025</span>
                                <span class="rfp-proposals">12 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-open">Open</div>
                            <h3 class="rfp-title"><a href="#">Landscaping Contract</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Riverside Gardens</span>
                                <span class="rfp-date">Posted: Mar 28, 2025</span>
                                <span class="rfp-proposals">8 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-closed">Closed</div>
                            <h3 class="rfp-title"><a href="#">Security System Upgrade</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Maple Ridge Estates</span>
                                <span class="rfp-date">Posted: Mar 15, 2025</span>
                                <span class="rfp-proposals">15 Proposals</span>
                            </div>
                        </div>
                        <div class="rfp-item">
                            <div class="rfp-status rfp-status-awarded">Awarded</div>
                            <h3 class="rfp-title"><a href="#">Clubhouse Renovation</a></h3>
                            <div class="rfp-meta">
                                <span class="rfp-community">Sunset Villas</span>
                                <span class="rfp-date">Posted: Feb 28, 2025</span>
                                <span class="rfp-proposals">9 Proposals</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-text">View All RFPs</a>
                    </div>
                </div>

                <!-- Task Management -->
                <div class="dashboard-card">
                    <h2 class="card-title">Task Management</h2>
                    <div class="task-list">
                        <div class="task-item">
                            <div class="task-checkbox">
                                <input type="checkbox" id="task1" name="task1">
                                <label for="task1"></label>
                            </div>
                            <div class="task-details">
                                <h3 class="task-title">Review pool maintenance proposals</h3>
                                <div class="task-meta">
                                    <span class="task-community">Oakwood Heights</span>
                                    <span class="task-due">Due: Apr 10, 2025</span>
                                    <span class="task-priority task-priority-high">High Priority</span>
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-checkbox">
                                <input type="checkbox" id="task2" name="task2">
                                <label for="task2"></label>
                            </div>
                            <div class="task-details">
                                <h3 class="task-title">Schedule board meeting</h3>
                                <div class="task-meta">
                                    <span class="task-community">Riverside Gardens</span>
                                    <span class="task-due">Due: Apr 15, 2025</span>
                                    <span class="task-priority task-priority-medium">Medium Priority</span>
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-checkbox">
                                <input type="checkbox" id="task3" name="task3">
                                <label for="task3"></label>
                            </div>
                            <div class="task-details">
                                <h3 class="task-title">Prepare financial report</h3>
                                <div class="task-meta">
                                    <span class="task-community">Maple Ridge Estates</span>
                                    <span class="task-due">Due: Apr 20, 2025</span>
                                    <span class="task-priority task-priority-high">High Priority</span>
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-checkbox">
                                <input type="checkbox" id="task4" name="task4">
                                <label for="task4"></label>
                            </div>
                            <div class="task-details">
                                <h3 class="task-title">Inspect playground equipment</h3>
                                <div class="task-meta">
                                    <span class="task-community">Sunset Villas</span>
                                    <span class="task-due">Due: Apr 25, 2025</span>
                                    <span class="task-priority task-priority-medium">Medium Priority</span>
                                </div>
                            </div>
                            <div class="task-actions">
                                <a href="#" class="btn btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-text">View All Tasks</a>
                    </div>
                </div>

                <!-- Professional Development -->
                <div class="dashboard-card">
                    <h2 class="card-title">Professional Development</h2>
                    <div class="learning-progress">
                        <div class="progress-summary">
                            <div class="progress-item">
                                <span class="progress-label">CE Credits Earned</span>
                                <span class="progress-value">32 / 40</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 80%;"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <span class="progress-label">Courses Completed</span>
                                <span class="progress-value">5 / 8</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 62.5%;"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <span class="progress-label">License Renewal</span>
                                <span class="progress-value">Due in 120 days</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 67%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="current-courses">
                            <h3>Current Courses</h3>
                            <div class="course-item">
                                <div class="course-image">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="Course Image">
                                </div>
                                <div class="course-details">
                                    <h4 class="course-title"><a href="#">Advanced Financial Management for CAMs</a></h4>
                                    <div class="course-meta">
                                        <span class="course-lessons">10 Lessons</span>
                                        <span class="course-progress">60% Complete</span>
                                        <span class="course-credits">8 CE Credits</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="course-item">
                                <div class="course-image">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="Course Image">
                                </div>
                                <div class="course-details">
                                    <h4 class="course-title"><a href="#">Conflict Resolution in Community Management</a></h4>
                                    <div class="course-meta">
                                        <span class="course-lessons">6 Lessons</span>
                                        <span class="course-progress">33% Complete</span>
                                        <span class="course-credits">4 CE Credits</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 33%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/learning-hub/')); ?>" class="btn btn-text">View Learning Hub</a>
                    </div>
                </div>

                <!-- Community Forum -->
                <div class="dashboard-card">
                    <h2 class="card-title">CAM Professional Forum</h2>
                    <div class="forum-topics">
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Best practices for handling delinquent accounts</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Jennifer Lee</span>
                                <span class="topic-replies">18 Replies</span>
                                <span class="topic-date">Last activity: 1 day ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Software recommendations for community management</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: David Wilson</span>
                                <span class="topic-replies">24 Replies</span>
                                <span class="topic-date">Last activity: 3 days ago</span>
                            </div>
                        </div>
                        <div class="forum-topic">
                            <h3 class="topic-title"><a href="#">Handling difficult board members</a></h3>
                            <div class="topic-meta">
                                <span class="topic-author">Started by: Sarah Johnson</span>
                                <span class="topic-replies">32 Replies</span>
                                <span class="topic-date">Last activity: 4 days ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo esc_url(home_url('/forums/cam-professional-corner/')); ?>" class="btn btn-text">Visit CAM Forums</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
