<?php
/**
 * Template Name: Learning Hub
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="learning-hub-container">
    <div class="learning-hub-header">
        <div class="container">
            <h1 class="learning-hub-title">Learning Hub</h1>
            <div class="learning-hub-description">
                <p>Welcome to the Common Elements Learning Hub, your resource for community association education and professional development.</p>
            </div>
        </div>
    </div>

    <div class="learning-hub-content">
        <div class="container">
            <div class="learning-hub-search-filters">
                <div class="search-container">
                    <form class="learning-hub-search-form" method="get">
                        <div class="search-field">
                            <input type="text" name="search" placeholder="Search courses..." value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                
                <div class="filter-container">
                    <form class="learning-hub-filter-form" method="get">
                        <div class="filter-group">
                            <label for="category">Category</label>
                            <select id="category" name="category">
                                <option value="">All Categories</option>
                                <option value="board-governance" <?php selected(isset($_GET['category']) && $_GET['category'] === 'board-governance'); ?>>Board Governance</option>
                                <option value="financial-management" <?php selected(isset($_GET['category']) && $_GET['category'] === 'financial-management'); ?>>Financial Management</option>
                                <option value="legal-compliance" <?php selected(isset($_GET['category']) && $_GET['category'] === 'legal-compliance'); ?>>Legal & Compliance</option>
                                <option value="maintenance" <?php selected(isset($_GET['category']) && $_GET['category'] === 'maintenance'); ?>>Maintenance & Operations</option>
                                <option value="community-engagement" <?php selected(isset($_GET['category']) && $_GET['category'] === 'community-engagement'); ?>>Community Engagement</option>
                                <option value="vendor-management" <?php selected(isset($_GET['category']) && $_GET['category'] === 'vendor-management'); ?>>Vendor Management</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="level">Level</label>
                            <select id="level" name="level">
                                <option value="">All Levels</option>
                                <option value="beginner" <?php selected(isset($_GET['level']) && $_GET['level'] === 'beginner'); ?>>Beginner</option>
                                <option value="intermediate" <?php selected(isset($_GET['level']) && $_GET['level'] === 'intermediate'); ?>>Intermediate</option>
                                <option value="advanced" <?php selected(isset($_GET['level']) && $_GET['level'] === 'advanced'); ?>>Advanced</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="duration">Duration</label>
                            <select id="duration" name="duration">
                                <option value="">Any Duration</option>
                                <option value="short" <?php selected(isset($_GET['duration']) && $_GET['duration'] === 'short'); ?>>Under 1 hour</option>
                                <option value="medium" <?php selected(isset($_GET['duration']) && $_GET['duration'] === 'medium'); ?>>1-3 hours</option>
                                <option value="long" <?php selected(isset($_GET['duration']) && $_GET['duration'] === 'long'); ?>>3+ hours</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-filter">Apply Filters</button>
                            <a href="<?php echo esc_url(home_url('/learning-hub/')); ?>" class="btn btn-text">Clear Filters</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="learning-hub-featured">
                <h2 class="section-title">Featured Courses</h2>
                <div class="featured-courses">
                    <div class="course-card featured">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-1.jpg" alt="Board Member Essentials">
                            <div class="course-badge">Featured</div>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Board Governance</div>
                            <h3 class="course-title"><a href="<?php echo esc_url(home_url('/learning-hub/board-member-essentials/')); ?>">Board Member Essentials</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Beginner</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 2 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 8 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Learn the essential responsibilities, legal duties, and best practices for serving as an effective board member in your community association.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="<?php echo esc_url(home_url('/learning-hub/board-member-essentials/')); ?>" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card featured">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-2.jpg" alt="Financial Management for Community Associations">
                            <div class="course-badge">Featured</div>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Financial Management</div>
                            <h3 class="course-title"><a href="#">Financial Management for Community Associations</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Intermediate</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 3 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 12 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Master the fundamentals of community association finances, including budgeting, reserves, financial statements, and investment strategies.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card featured">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-3.jpg" alt="Effective Vendor Management">
                            <div class="course-badge">Featured</div>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Vendor Management</div>
                            <h3 class="course-title"><a href="#">Effective Vendor Management</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Intermediate</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 2.5 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 10 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Learn how to select, evaluate, and manage vendors effectively to ensure quality service delivery and value for your community association.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="learning-hub-categories">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=board-governance')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-gavel"></i></div>
                        <h3 class="category-name">Board Governance</h3>
                        <span class="category-count">8 courses</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=financial-management')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-money"></i></div>
                        <h3 class="category-name">Financial Management</h3>
                        <span class="category-count">6 courses</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=legal-compliance')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-balance-scale"></i></div>
                        <h3 class="category-name">Legal & Compliance</h3>
                        <span class="category-count">5 courses</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=maintenance')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-wrench"></i></div>
                        <h3 class="category-name">Maintenance & Operations</h3>
                        <span class="category-count">7 courses</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=community-engagement')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-users"></i></div>
                        <h3 class="category-name">Community Engagement</h3>
                        <span class="category-count">4 courses</span>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/learning-hub/?category=vendor-management')); ?>" class="category-card">
                        <div class="category-icon"><i class="fa fa-handshake-o"></i></div>
                        <h3 class="category-name">Vendor Management</h3>
                        <span class="category-count">3 courses</span>
                    </a>
                </div>
            </div>
            
            <div class="learning-hub-all-courses">
                <h2 class="section-title">All Courses</h2>
                <div class="courses-grid">
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-4.jpg" alt="Understanding HOA Governing Documents">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Legal & Compliance</div>
                            <h3 class="course-title"><a href="#">Understanding HOA Governing Documents</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Beginner</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 1.5 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 6 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Learn about the various governing documents that regulate community associations and how to interpret and apply them effectively.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-5.jpg" alt="Reserve Studies and Planning">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Financial Management</div>
                            <h3 class="course-title"><a href="#">Reserve Studies and Planning</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Intermediate</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 2 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 8 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Understand the importance of reserve studies, how they are conducted, and how to use them for long-term financial planning in your community.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-6.jpg" alt="Effective Board Meetings">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Board Governance</div>
                            <h3 class="course-title"><a href="#">Effective Board Meetings</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Beginner</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 1 hour</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 5 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Learn how to plan, conduct, and follow up on board meetings to maximize productivity and minimize conflicts.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-7.jpg" alt="Community Maintenance Planning">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Maintenance & Operations</div>
                            <h3 class="course-title"><a href="#">Community Maintenance Planning</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Intermediate</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 2.5 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 10 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Develop comprehensive maintenance plans for your community's common areas and facilities to prevent costly repairs and extend asset life.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-8.jpg" alt="Conflict Resolution in Communities">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Community Engagement</div>
                            <h3 class="course-title"><a href="#">Conflict Resolution in Communities</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Intermediate</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 1.5 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 7 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Learn effective strategies for managing and resolving conflicts between residents, board members, and management in community associations.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder-9.jpg" alt="Advanced Legal Issues in HOAs">
                        </div>
                        <div class="course-content">
                            <div class="course-category">Legal & Compliance</div>
                            <h3 class="course-title"><a href="#">Advanced Legal Issues in HOAs</a></h3>
                            <div class="course-meta">
                                <span class="course-level"><i class="fa fa-signal"></i> Advanced</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 3 hours</span>
                                <span class="course-lessons"><i class="fa fa-list"></i> 12 lessons</span>
                            </div>
                            <div class="course-description">
                                <p>Explore complex legal issues facing community associations, including fair housing, ADA compliance, insurance claims, and litigation management.</p>
                            </div>
                            <div class="course-footer">
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-text">Not started</div>
                                </div>
                                <a href="#" class="btn btn-primary">Start Course</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="learning-hub-pagination">
                    <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                    <span class="pagination-current">Page 1 of 6</span>
                    <a href="#" class="pagination-next">Next &raquo;</a>
                </div>
            </div>
            
            <div class="learning-hub-membership">
                <div class="membership-card">
                    <div class="membership-content">
                        <h2>Unlock All Courses with a Membership</h2>
                        <p>Get unlimited access to all courses, certificates, and exclusive resources with a Common Elements Learning Hub membership.</p>
                        <ul class="membership-benefits">
                            <li><i class="fa fa-check"></i> Access to all current and future courses</li>
                            <li><i class="fa fa-check"></i> Downloadable resources and templates</li>
                            <li><i class="fa fa-check"></i> Completion certificates</li>
                            <li><i class="fa fa-check"></i> Progress tracking across devices</li>
                            <li><i class="fa fa-check"></i> Community forum access</li>
                        </ul>
                        <div class="membership-cta">
                            <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn btn-primary btn-large">View Membership Options</a>
                        </div>
                    </div>
                    <div class="membership-image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/membership-placeholder.jpg" alt="Membership Benefits">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
