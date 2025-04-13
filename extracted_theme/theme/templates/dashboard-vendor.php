<?php
/**
 * Template Name: Vendor Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="dashboard-container vendor-dashboard">
    <?php if ( function_exists( 'common_elements_dashboard_header' ) ) : ?>
        <?php common_elements_dashboard_header(); ?>
    <?php else : ?>
        <div class="dashboard-header">
            <div class="container">
                <h1 class="dashboard-title"><?php esc_html_e( 'Vendor Dashboard', 'common-elements' ); ?></h1>
                <div class="dashboard-actions">
                    <a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> <?php esc_html_e( 'Edit Directory Listing', 'common-elements' ); ?></a>
                    <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-secondary"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'View Open RFPs', 'common-elements' ); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="dashboard-content">
        <div class="container">
            <div class="dashboard-layout">
                <div class="dashboard-sidebar">
                    <div class="dashboard-quick-links">
                        <h3><?php esc_html_e( 'Quick Links', 'common-elements' ); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>"><i class="fas fa-edit"></i> <?php esc_html_e( 'Edit Directory Listing', 'common-elements' ); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/rfp/')); ?>"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'View Open RFPs', 'common-elements' ); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/rfp/my-proposals/')); ?>"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( 'My Proposals', 'common-elements' ); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/forums/vendor-networking/')); ?>"><i class="fas fa-comments"></i> <?php esc_html_e( 'Vendor Forums', 'common-elements' ); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/account/profile/')); ?>"><i class="fas fa-user-cog"></i> <?php esc_html_e( 'Account Settings', 'common-elements' ); ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="dashboard-main">
                    <div class="ce-dashboard-columns">
                        <!-- Vendor Overview Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-vendor-overview" data-widget-id="vendor-overview">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-chart-pie"></i> <?php esc_html_e( 'Vendor Overview', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <span class="stat-value">15</span>
                                        <span class="stat-label"><?php esc_html_e( 'Open RFPs', 'common-elements' ); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">8</span>
                                        <span class="stat-label"><?php esc_html_e( 'My Proposals', 'common-elements' ); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">3</span>
                                        <span class="stat-label"><?php esc_html_e( 'Awarded Projects', 'common-elements' ); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">245</span>
                                        <span class="stat-label"><?php esc_html_e( 'Directory Views', 'common-elements' ); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/vendor/stats/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-chart-line"></i> <?php esc_html_e( 'View Detailed Stats', 'common-elements' ); ?></a>
                            </div>
                        </div>

                        <!-- Directory Listing Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-directory-listing" data-widget-id="directory-listing">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-building"></i> <?php esc_html_e( 'Directory Listing', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="directory-preview">
                                    <div class="directory-header">
                                        <div class="directory-logo">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vendor-placeholder.png" alt="<?php esc_attr_e( 'Vendor Logo', 'common-elements' ); ?>">
                                        </div>
                                        <div class="directory-info">
                                            <h3 class="directory-name"><?php esc_html_e( 'Crystal Clear Pools', 'common-elements' ); ?></h3>
                                            <div class="directory-meta">
                                                <span class="directory-category"><i class="fas fa-tag"></i> <?php esc_html_e( 'Pool Maintenance', 'common-elements' ); ?></span>
                                                <span class="directory-location"><i class="fas fa-map-marker-alt"></i> <?php esc_html_e( 'Atlanta, GA', 'common-elements' ); ?></span>
                                                <span class="directory-rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="rating-count"><?php esc_html_e( '(24 reviews)', 'common-elements' ); ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="directory-content">
                                        <p><?php esc_html_e( 'Crystal Clear Pools provides professional pool maintenance services for community associations and residential properties. Our services include regular cleaning, chemical balancing, equipment maintenance, and repairs.', 'common-elements' ); ?></p>
                                    </div>
                                    <div class="directory-stats">
                                        <div class="stat-item">
                                            <span class="stat-label"><i class="fas fa-eye"></i> <?php esc_html_e( 'Profile Views', 'common-elements' ); ?></span>
                                            <span class="stat-value">245</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label"><i class="fas fa-mouse-pointer"></i> <?php esc_html_e( 'Contact Clicks', 'common-elements' ); ?></span>
                                            <span class="stat-value">32</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Last Updated', 'common-elements' ); ?></span>
                                            <span class="stat-value"><?php esc_html_e( 'Mar 15, 2025', 'common-elements' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/directory/edit-listing/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-edit"></i> <?php esc_html_e( 'Edit Listing', 'common-elements' ); ?></a>
                            </div>
                        </div>

                        <!-- Open RFPs Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-open-rfps" data-widget-id="open-rfps">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'Open RFPs', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="rfp-list">
                                    <div class="rfp-item">
                                        <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                        <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Pool Maintenance Services', 'common-elements' ); ?></a></h3>
                                        <div class="rfp-meta">
                                            <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Oakwood Heights', 'common-elements' ); ?></span>
                                            <span class="rfp-date"><i class="fas fa-calendar-check"></i> <?php esc_html_e( 'Posted: Apr 2, 2025', 'common-elements' ); ?></span>
                                            <span class="rfp-deadline"><i class="fas fa-hourglass-half"></i> <?php esc_html_e( 'Deadline: Apr 16, 2025', 'common-elements' ); ?></span>
                                        </div>
                                        <div class="rfp-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-paper-plane"></i> <?php esc_html_e( 'Submit Proposal', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                    <div class="rfp-item">
                                        <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                        <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Pool Equipment Replacement', 'common-elements' ); ?></a></h3>
                                        <div class="rfp-meta">
                                            <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Riverside Gardens', 'common-elements' ); ?></span>
                                            <span class="rfp-date"><i class="fas fa-calendar-check"></i> <?php esc_html_e( 'Posted: Mar 28, 2025', 'common-elements' ); ?></span>
                                            <span class="rfp-deadline"><i class="fas fa-hourglass-half"></i> <?php esc_html_e( 'Deadline: Apr 11, 2025', 'common-elements' ); ?></span>
                                        </div>
                                        <div class="rfp-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-paper-plane"></i> <?php esc_html_e( 'Submit Proposal', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                    <div class="rfp-item">
                                        <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                        <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Pool Resurfacing Project', 'common-elements' ); ?></a></h3>
                                        <div class="rfp-meta">
                                            <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Maple Ridge Estates', 'common-elements' ); ?></span>
                                            <span class="rfp-date"><i class="fas fa-calendar-check"></i> <?php esc_html_e( 'Posted: Mar 25, 2025', 'common-elements' ); ?></span>
                                            <span class="rfp-deadline"><i class="fas fa-hourglass-half"></i> <?php esc_html_e( 'Deadline: Apr 8, 2025', 'common-elements' ); ?></span>
                                        </div>
                                        <div class="rfp-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-paper-plane"></i> <?php esc_html_e( 'Submit Proposal', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-list"></i> <?php esc_html_e( 'View All Open RFPs', 'common-elements' ); ?></a>
                            </div>
                        </div>

                        <!-- My Proposals Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-my-proposals" data-widget-id="my-proposals">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( 'My Proposals', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="proposal-list">
                                    <div class="proposal-item">
                                        <div class="proposal-status proposal-status-pending"><?php esc_html_e( 'Pending', 'common-elements' ); ?></div>
                                        <div class="proposal-details">
                                            <h3 class="proposal-title"><a href="#"><?php esc_html_e( 'Pool Maintenance Services - Sunset Villas', 'common-elements' ); ?></a></h3>
                                            <div class="proposal-meta">
                                                <span class="proposal-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Submitted: Apr 5, 2025', 'common-elements' ); ?></span>
                                                <span class="proposal-amount"><i class="fas fa-dollar-sign"></i> <?php esc_html_e( '$12,500/year', 'common-elements' ); ?></span>
                                            </div>
                                        </div>
                                        <div class="proposal-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                    <div class="proposal-item">
                                        <div class="proposal-status proposal-status-pending"><?php esc_html_e( 'Pending', 'common-elements' ); ?></div>
                                        <div class="proposal-details">
                                            <h3 class="proposal-title"><a href="#"><?php esc_html_e( 'Pool Equipment Replacement - Pinecrest Commons', 'common-elements' ); ?></a></h3>
                                            <div class="proposal-meta">
                                                <span class="proposal-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Submitted: Mar 30, 2025', 'common-elements' ); ?></span>
                                                <span class="proposal-amount"><i class="fas fa-dollar-sign"></i> <?php esc_html_e( '$8,750', 'common-elements' ); ?></span>
                                            </div>
                                        </div>
                                        <div class="proposal-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                    <div class="proposal-item">
                                        <div class="proposal-status proposal-status-awarded"><?php esc_html_e( 'Awarded', 'common-elements' ); ?></div>
                                        <div class="proposal-details">
                                            <h3 class="proposal-title"><a href="#"><?php esc_html_e( 'Pool Maintenance Services - Oakwood Heights', 'common-elements' ); ?></a></h3>
                                            <div class="proposal-meta">
                                                <span class="proposal-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Submitted: Mar 15, 2025', 'common-elements' ); ?></span>
                                                <span class="proposal-amount"><i class="fas fa-dollar-sign"></i> <?php esc_html_e( '$14,200/year', 'common-elements' ); ?></span>
                                            </div>
                                        </div>
                                        <div class="proposal-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                    <div class="proposal-item">
                                        <div class="proposal-status proposal-status-declined"><?php esc_html_e( 'Declined', 'common-elements' ); ?></div>
                                        <div class="proposal-details">
                                            <h3 class="proposal-title"><a href="#"><?php esc_html_e( 'Pool Resurfacing - Riverside Gardens', 'common-elements' ); ?></a></h3>
                                            <div class="proposal-meta">
                                                <span class="proposal-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Submitted: Feb 28, 2025', 'common-elements' ); ?></span>
                                                <span class="proposal-amount"><i class="fas fa-dollar-sign"></i> <?php esc_html_e( '$32,500', 'common-elements' ); ?></span>
                                            </div>
                                        </div>
                                        <div class="proposal-actions">
                                            <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/rfp/my-proposals/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-list"></i> <?php esc_html_e( 'View All Proposals', 'common-elements' ); ?></a>
                            </div>
                        </div>

                        <!-- Reviews & Ratings Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-reviews-ratings" data-widget-id="reviews-ratings">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-star"></i> <?php esc_html_e( 'Reviews & Ratings', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="reviews-summary">
                                    <div class="rating-overview">
                                        <div class="rating-score">4.5</div>
                                        <div class="rating-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="rating-count"><?php esc_html_e( '24 reviews', 'common-elements' ); ?></div>
                                    </div>
                                    <div class="rating-breakdown">
                                        <div class="rating-item">
                                            <span class="rating-label"><?php esc_html_e( '5 Stars', 'common-elements' ); ?></span>
                                            <div class="rating-bar-container">
                                                <div class="rating-bar" style="width: 75%;"></div>
                                            </div>
                                            <span class="rating-count">18</span>
                                        </div>
                                        <div class="rating-item">
                                            <span class="rating-label"><?php esc_html_e( '4 Stars', 'common-elements' ); ?></span>
                                            <div class="rating-bar-container">
                                                <div class="rating-bar" style="width: 12.5%;"></div>
                                            </div>
                                            <span class="rating-count">3</span>
                                        </div>
                                        <div class="rating-item">
                                            <span class="rating-label"><?php esc_html_e( '3 Stars', 'common-elements' ); ?></span>
                                            <div class="rating-bar-container">
                                                <div class="rating-bar" style="width: 8.3%;"></div>
                                            </div>
                                            <span class="rating-count">2</span>
                                        </div>
                                        <div class="rating-item">
                                            <span class="rating-label"><?php esc_html_e( '2 Stars', 'common-elements' ); ?></span>
                                            <div class="rating-bar-container">
                                                <div class="rating-bar" style="width: 4.2%;"></div>
                                            </div>
                                            <span class="rating-count">1</span>
                                        </div>
                                        <div class="rating-item">
                                            <span class="rating-label"><?php esc_html_e( '1 Star', 'common-elements' ); ?></span>
                                            <div class="rating-bar-container">
                                                <div class="rating-bar" style="width: 0%;"></div>
                                            </div>
                                            <span class="rating-count">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent-reviews">
                                    <h3><?php esc_html_e( 'Recent Reviews', 'common-elements' ); ?></h3>
                                    <div class="review-item">
                                        <div class="review-header">
                                            <div class="review-author"><i class="fas fa-building"></i> <?php esc_html_e( 'Oakwood Heights HOA', 'common-elements' ); ?></div>
                                            <div class="review-rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="review-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Mar 20, 2025', 'common-elements' ); ?></div>
                                        </div>
                                        <div class="review-content">
                                            <p><?php esc_html_e( 'Crystal Clear Pools has been maintaining our community pool for the past year, and we couldn\'t be happier with their service. They are responsive, thorough, and always go above and beyond.', 'common-elements' ); ?></p>
                                        </div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-header">
                                            <div class="review-author"><i class="fas fa-building"></i> <?php esc_html_e( 'Riverside Gardens HOA', 'common-elements' ); ?></div>
                                            <div class="review-rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="review-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Feb 15, 2025', 'common-elements' ); ?></div>
                                        </div>
                                        <div class="review-content">
                                            <p><?php esc_html_e( 'Good service overall. They maintain our pool well, but sometimes communication could be better when scheduling special maintenance.', 'common-elements' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/directory/reviews/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-list"></i> <?php esc_html_e( 'View All Reviews', 'common-elements' ); ?></a>
                            </div>
                        </div>

                        <!-- Vendor Networking Widget -->
                        <div class="ce-dashboard-widget" id="ce-widget-vendor-networking" data-widget-id="vendor-networking">
                            <div class="ce-dashboard-widget-header">
                                <h2 class="ce-dashboard-widget-title"><i class="fas fa-comments"></i> <?php esc_html_e( 'Vendor Networking', 'common-elements' ); ?></h2>
                                <div class="ce-dashboard-widget-actions">
                                    <a href="#" class="ce-dashboard-widget-settings" title="<?php esc_attr_e( 'Widget Settings', 'common-elements' ); ?>"><i class="fas fa-cog"></i></a>
                                    <a href="#" class="ce-dashboard-widget-toggle" title="<?php esc_attr_e( 'Toggle Widget', 'common-elements' ); ?>"><i class="fas fa-chevron-up"></i></a>
                                    <a href="#" class="ce-dashboard-widget-remove" title="<?php esc_attr_e( 'Remove Widget', 'common-elements' ); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <div class="forum-topics">
                                    <div class="forum-topic">
                                        <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Best practices for responding to RFPs', 'common-elements' ); ?></a></h3>
                                        <div class="topic-meta">
                                            <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: David Wilson', 'common-elements' ); ?></span>
                                            <span class="topic-replies"><i class="fas fa-reply"></i> <?php esc_html_e( '14 Replies', 'common-elements' ); ?></span>
                                            <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 2 days ago', 'common-elements' ); ?></span>
                                        </div>
                                    </div>
                                    <div class="forum-topic">
                                        <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Working with community managers effectively', 'common-elements' ); ?></a></h3>
                                        <div class="topic-meta">
                                            <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: Jennifer Lee', 'common-elements' ); ?></span>
                                            <span class="topic-replies"><i class="fas fa-reply"></i> <?php esc_html_e( '22 Replies', 'common-elements' ); ?></span>
                                            <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 4 days ago', 'common-elements' ); ?></span>
                                        </div>
                                    </div>
                                    <div class="forum-topic">
                                        <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Insurance requirements for community contracts', 'common-elements' ); ?></a></h3>
                                        <div class="topic-meta">
                                            <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: Michael Brown', 'common-elements' ); ?></span>
                                            <span class="topic-replies"><i class="fas fa-reply"></i> <?php esc_html_e( '8 Replies', 'common-elements' ); ?></span>
                                            <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 6 days ago', 'common-elements' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-footer">
                                <a href="<?php echo esc_url(home_url('/forums/vendor-networking/')); ?>" class="ce-dashboard-widget-link"><i class="fas fa-external-link-alt"></i> <?php esc_html_e( 'Visit Vendor Forums', 'common-elements' ); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ( is_active_sidebar( 'dashboard-vendor-bottom' ) ) : ?>
                    <div class="dashboard-sidebar-bottom">
                        <?php dynamic_sidebar( 'dashboard-vendor-bottom' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
