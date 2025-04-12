<?php
/**
 * Template Name: Forums Home
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="forums-container">
    <div class="forums-header">
        <div class="container">
            <h1 class="forums-title">Community Forums</h1>
            <div class="forums-actions">
                <?php if (is_user_logged_in()): ?>
                <a href="<?php echo esc_url(home_url('/forums/new-topic/')); ?>" class="btn btn-primary">Create New Topic</a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/forums/search/')); ?>" class="btn btn-secondary">Search Forums</a>
            </div>
        </div>
    </div>

    <div class="forums-content">
        <div class="container">
            <div class="forums-navigation">
                <div class="forums-breadcrumbs">
                    <span class="current">Forums Home</span>
                </div>
                <div class="forums-search">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/forums/search/')); ?>">
                        <input type="text" name="bbp_search" placeholder="Search forums...">
                        <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="forums-categories">
                <!-- Board Member Forums -->
                <div class="forum-category">
                    <div class="category-header">
                        <h2 class="category-title">Board Member Forums</h2>
                        <div class="category-description">
                            <p>Discussion forums for board members to share experiences, best practices, and resources.</p>
                            <div class="category-meta">
                                <span class="category-access">Access: Board Members Only</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="forums-list">
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Board Governance</a></h3>
                                <div class="forum-description">Discussions about board governance, roles, responsibilities, and best practices.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">24 topics</span>
                                    <span class="forum-replies">142 replies</span>
                                    <span class="forum-activity">Last activity: 2 hours ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Financial Management</a></h3>
                                <div class="forum-description">Discussions about budgeting, reserves, financial reporting, and investment strategies.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">18 topics</span>
                                    <span class="forum-replies">97 replies</span>
                                    <span class="forum-activity">Last activity: 1 day ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Legal & Compliance</a></h3>
                                <div class="forum-description">Discussions about legal issues, compliance requirements, and regulatory changes.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">15 topics</span>
                                    <span class="forum-replies">83 replies</span>
                                    <span class="forum-activity">Last activity: 3 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- CAM Professional Forums -->
                <div class="forum-category">
                    <div class="category-header">
                        <h2 class="category-title">CAM Professional Forums</h2>
                        <div class="category-description">
                            <p>Discussion forums for community association managers to share knowledge, resources, and best practices.</p>
                            <div class="category-meta">
                                <span class="category-access">Access: CAM Professionals Only</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="forums-list">
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Community Management</a></h3>
                                <div class="forum-description">Discussions about day-to-day community management, resident relations, and operational issues.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">32 topics</span>
                                    <span class="forum-replies">187 replies</span>
                                    <span class="forum-activity">Last activity: 5 hours ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Vendor Management</a></h3>
                                <div class="forum-description">Discussions about working with vendors, contract management, and service quality.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">27 topics</span>
                                    <span class="forum-replies">156 replies</span>
                                    <span class="forum-activity">Last activity: 1 day ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Professional Development</a></h3>
                                <div class="forum-description">Discussions about certifications, continuing education, career advancement, and industry trends.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">19 topics</span>
                                    <span class="forum-replies">112 replies</span>
                                    <span class="forum-activity">Last activity: 2 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Vendor Forums -->
                <div class="forum-category">
                    <div class="category-header">
                        <h2 class="category-title">Vendor Forums</h2>
                        <div class="category-description">
                            <p>Discussion forums for vendors to network, share industry knowledge, and discuss best practices.</p>
                            <div class="category-meta">
                                <span class="category-access">Access: Vendors Only</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="forums-list">
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Vendor Networking</a></h3>
                                <div class="forum-description">General discussion forum for vendors to network and share information.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">28 topics</span>
                                    <span class="forum-replies">163 replies</span>
                                    <span class="forum-activity">Last activity: 8 hours ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">RFP & Proposal Strategies</a></h3>
                                <div class="forum-description">Discussions about responding to RFPs, creating effective proposals, and winning contracts.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">22 topics</span>
                                    <span class="forum-replies">134 replies</span>
                                    <span class="forum-activity">Last activity: 1 day ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Industry Trends</a></h3>
                                <div class="forum-description">Discussions about industry trends, technology, and innovations in community services.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">17 topics</span>
                                    <span class="forum-replies">95 replies</span>
                                    <span class="forum-activity">Last activity: 3 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- General Discussion Forums -->
                <div class="forum-category">
                    <div class="category-header">
                        <h2 class="category-title">General Discussion</h2>
                        <div class="category-description">
                            <p>Open discussion forums for all community members to participate in.</p>
                            <div class="category-meta">
                                <span class="category-access">Access: All Members</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="forums-list">
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Community Announcements</a></h3>
                                <div class="forum-description">Important announcements and updates from Common Elements.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">12 topics</span>
                                    <span class="forum-replies">45 replies</span>
                                    <span class="forum-activity">Last activity: 2 days ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Industry News</a></h3>
                                <div class="forum-description">Discussions about news and events in the community association industry.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">25 topics</span>
                                    <span class="forum-replies">132 replies</span>
                                    <span class="forum-activity">Last activity: 1 day ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="forum-item">
                            <div class="forum-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="forum-info">
                                <h3 class="forum-title"><a href="#">Help & Support</a></h3>
                                <div class="forum-description">Get help with using Common Elements features and services.</div>
                                <div class="forum-meta">
                                    <span class="forum-topics">18 topics</span>
                                    <span class="forum-replies">87 replies</span>
                                    <span class="forum-activity">Last activity: 12 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="forums-statistics">
                <h3>Forum Statistics</h3>
                <div class="statistics-grid">
                    <div class="statistic-item">
                        <span class="statistic-value">257</span>
                        <span class="statistic-label">Topics</span>
                    </div>
                    <div class="statistic-item">
                        <span class="statistic-value">1,433</span>
                        <span class="statistic-label">Replies</span>
                    </div>
                    <div class="statistic-item">
                        <span class="statistic-value">842</span>
                        <span class="statistic-label">Members</span>
                    </div>
                    <div class="statistic-item">
                        <span class="statistic-value">JohnDoe</span>
                        <span class="statistic-label">Newest Member</span>
                    </div>
                </div>
            </div>
            
            <div class="forums-activity">
                <h3>Recent Activity</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                        </div>
                        <div class="activity-content">
                            <div class="activity-header">
                                <a href="#" class="activity-user">Sarah Johnson</a> replied to <a href="#" class="activity-topic">Best practices for responding to RFPs</a>
                            </div>
                            <div class="activity-excerpt">
                                <p>I've found that including case studies from similar communities really helps strengthen proposals...</p>
                            </div>
                            <div class="activity-meta">
                                <span class="activity-time">2 hours ago</span>
                                <span class="activity-forum">in <a href="#">RFP & Proposal Strategies</a></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                        </div>
                        <div class="activity-content">
                            <div class="activity-header">
                                <a href="#" class="activity-user">Michael Brown</a> started a new topic <a href="#" class="activity-topic">Insurance requirements for community contracts</a>
                            </div>
                            <div class="activity-excerpt">
                                <p>What are the standard insurance requirements you include in vendor contracts? I'm reviewing our templates and...</p>
                            </div>
                            <div class="activity-meta">
                                <span class="activity-time">6 hours ago</span>
                                <span class="activity-forum">in <a href="#">Vendor Management</a></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                        </div>
                        <div class="activity-content">
                            <div class="activity-header">
                                <a href="#" class="activity-user">Jennifer Lee</a> replied to <a href="#" class="activity-topic">Working with community managers effectively</a>
                            </div>
                            <div class="activity-excerpt">
                                <p>Communication is key. I always make sure to provide regular updates and be responsive to inquiries...</p>
                            </div>
                            <div class="activity-meta">
                                <span class="activity-time">12 hours ago</span>
                                <span class="activity-forum">in <a href="#">Vendor Networking</a></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                        </div>
                        <div class="activity-content">
                            <div class="activity-header">
                                <a href="#" class="activity-user">David Wilson</a> replied to <a href="#" class="activity-topic">New legislation affecting HOA governance</a>
                            </div>
                            <div class="activity-excerpt">
                                <p>The new bill includes significant changes to meeting notification requirements. Boards will need to...</p>
                            </div>
                            <div class="activity-meta">
                                <span class="activity-time">1 day ago</span>
                                <span class="activity-forum">in <a href="#">Legal & Compliance</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="activity-footer">
                    <a href="#" class="btn btn-text">View More Activity</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
