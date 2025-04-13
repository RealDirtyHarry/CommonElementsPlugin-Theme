<?php
/**
 * Template Name: Board Member Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="ce-dashboard-container board-dashboard">
    <?php if ( function_exists( 'common_elements_dashboard_header' ) ) : ?>
        <?php common_elements_dashboard_header(); ?>
    <?php else : ?>
        <div class="ce-dashboard-header">
            <div class="container">
                <div class="ce-dashboard-header-inner">
                    <div class="ce-dashboard-welcome">
                        <h2><?php printf( esc_html__( 'Welcome, %s', 'common-elements' ), esc_html( wp_get_current_user()->display_name ) ); ?></h2>
                        <p class="ce-dashboard-role"><?php esc_html_e( 'Board Member Dashboard', 'common-elements' ); ?></p>
                    </div>
                    <div class="ce-dashboard-actions">
                        <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php esc_html_e( 'Create New RFP', 'common-elements' ); ?></a>
                        <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-secondary"><i class="fas fa-search"></i> <?php esc_html_e( 'Vendor Directory', 'common-elements' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="ce-dashboard-content">
        <div class="container">
            <div class="ce-dashboard-layout">
                <div class="ce-dashboard-sidebar">
                    <?php if ( is_active_sidebar( 'dashboard-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-sidebar' ); ?>
                    <?php else : ?>
                        <div class="ce-dashboard-widget">
                            <div class="ce-dashboard-widget-header">
                                <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Quick Links', 'common-elements' ); ?></h3>
                                <div class="ce-dashboard-widget-actions">
                                    <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <ul class="ce-quick-links">
                                    <li><a href="<?php echo esc_url( home_url( '/rfp/' ) ); ?>"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'RFP System', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/directory/' ) ); ?>"><i class="fas fa-address-book"></i> <?php esc_html_e( 'Vendor Directory', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>"><i class="fas fa-comments"></i> <?php esc_html_e( 'Community Forums', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/learning-hub/' ) ); ?>"><i class="fas fa-graduation-cap"></i> <?php esc_html_e( 'Learning Hub', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/documents/' ) ); ?>"><i class="fas fa-file-alt"></i> <?php esc_html_e( 'Documents', 'common-elements' ); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="ce-dashboard-content">
                    <?php if ( is_active_sidebar( 'dashboard-content-top' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-content-top' ); ?>
                    <?php endif; ?>
                    
                    <div class="ce-dashboard-columns">
                        <div class="ce-dashboard-column" data-column="1">
                            <div class="ce-dashboard-widgets-container">
                                <!-- Widget: Community Overview -->
                                <div id="ce-widget-overview" class="ce-dashboard-widget" data-widget-id="overview">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Community Overview', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-file-contract"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">24</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Active RFPs', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-clipboard-list"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">156</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Vendor Proposals', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">432</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Community Members', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-comments"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">18</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Recent Forum Posts', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Widget: Financial Overview -->
                                <div id="ce-widget-financial" class="ce-dashboard-widget" data-widget-id="financial">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Financial Overview', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="financial-summary">
                                            <div class="financial-item">
                                                <span class="financial-label"><?php esc_html_e( 'Annual Budget', 'common-elements' ); ?></span>
                                                <span class="financial-value">$1,250,000</span>
                                            </div>
                                            <div class="financial-item">
                                                <span class="financial-label"><?php esc_html_e( 'YTD Expenses', 'common-elements' ); ?></span>
                                                <span class="financial-value">$425,000</span>
                                            </div>
                                            <div class="financial-item">
                                                <span class="financial-label"><?php esc_html_e( 'Reserve Fund', 'common-elements' ); ?></span>
                                                <span class="financial-value">$750,000</span>
                                            </div>
                                            <div class="financial-item">
                                                <span class="financial-label"><?php esc_html_e( 'Outstanding Dues', 'common-elements' ); ?></span>
                                                <span class="financial-value">$32,500</span>
                                            </div>
                                        </div>
                                        <div class="financial-chart">
                                            <div class="chart-placeholder">
                                                <div class="chart-bar" style="height: 60%;"></div>
                                                <div class="chart-bar" style="height: 80%;"></div>
                                                <div class="chart-bar" style="height: 45%;"></div>
                                                <div class="chart-bar" style="height: 70%;"></div>
                                                <div class="chart-bar" style="height: 55%;"></div>
                                                <div class="chart-bar" style="height: 65%;"></div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="#" class="btn btn-text"><i class="fas fa-chart-line"></i> <?php esc_html_e( 'View Financial Reports', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ce-dashboard-column" data-column="2">
                            <div class="ce-dashboard-widgets-container">
                                <!-- Widget: Recent RFPs -->
                                <div id="ce-widget-rfps" class="ce-dashboard-widget" data-widget-id="rfps">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Recent RFPs', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="rfp-list">
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Pool Maintenance Services', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-date"><?php esc_html_e( 'Posted: Apr 2, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><?php esc_html_e( '12 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Landscaping Contract', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-date"><?php esc_html_e( 'Posted: Mar 28, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><?php esc_html_e( '8 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-closed"><?php esc_html_e( 'Closed', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Security System Upgrade', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-date"><?php esc_html_e( 'Posted: Mar 15, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><?php esc_html_e( '15 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-text"><i class="fas fa-list"></i> <?php esc_html_e( 'View All RFPs', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Widget: Community Forum -->
                                <div id="ce-widget-forum" class="ce-dashboard-widget" data-widget-id="forum">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Community Forum', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="forum-topics">
                                            <div class="forum-topic">
                                                <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Best practices for community pool maintenance', 'common-elements' ); ?></a></h3>
                                                <div class="topic-meta">
                                                    <span class="topic-author"><?php esc_html_e( 'Started by: John Smith', 'common-elements' ); ?></span>
                                                    <span class="topic-replies"><?php esc_html_e( '12 Replies', 'common-elements' ); ?></span>
                                                    <span class="topic-date"><?php esc_html_e( 'Last activity: 2 days ago', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="forum-topic">
                                                <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Recommended vendors for landscaping services', 'common-elements' ); ?></a></h3>
                                                <div class="topic-meta">
                                                    <span class="topic-author"><?php esc_html_e( 'Started by: Sarah Johnson', 'common-elements' ); ?></span>
                                                    <span class="topic-replies"><?php esc_html_e( '8 Replies', 'common-elements' ); ?></span>
                                                    <span class="topic-date"><?php esc_html_e( 'Last activity: 3 days ago', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="<?php echo esc_url(home_url('/forums/')); ?>" class="btn btn-text"><i class="fas fa-comments"></i> <?php esc_html_e( 'Visit Forums', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ( is_active_sidebar( 'dashboard-content-bottom' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-content-bottom' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
