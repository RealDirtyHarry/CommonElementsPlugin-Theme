<?php
/**
 * Template Name: RFP Listing
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="rfp-container">
    <div class="rfp-header">
        <div class="container">
            <h1 class="rfp-title">Request for Proposals</h1>
            <div class="rfp-actions">
                <?php if (current_user_can('edit_posts')): ?>
                <a href="<?php echo esc_url(home_url('/submit-rfp/')); ?>" class="btn btn-primary">Create New RFP</a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-secondary">Vendor Directory</a>
            </div>
        </div>
    </div>

    <div class="rfp-content">
        <div class="container">
            <div class="rfp-filters">
                <form class="rfp-filter-form" method="get">
                    <div class="filter-group">
                        <label for="rfp-status">Status</label>
                        <select id="rfp-status" name="status">
                            <option value="">All Statuses</option>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                            <option value="awarded">Awarded</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="rfp-category">Category</label>
                        <select id="rfp-category" name="category">
                            <option value="">All Categories</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="renovation">Renovation</option>
                            <option value="landscaping">Landscaping</option>
                            <option value="security">Security</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="rfp-community">Community</label>
                        <select id="rfp-community" name="community">
                            <option value="">All Communities</option>
                            <option value="oakwood-heights">Oakwood Heights</option>
                            <option value="riverside-gardens">Riverside Gardens</option>
                            <option value="maple-ridge-estates">Maple Ridge Estates</option>
                            <option value="sunset-villas">Sunset Villas</option>
                            <option value="pinecrest-commons">Pinecrest Commons</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="btn btn-filter">Filter RFPs</button>
                    </div>
                </form>
            </div>

            <div class="rfp-list">
                <!-- This would be populated with actual RFPs from the database -->
                <div class="rfp-item">
                    <div class="rfp-status rfp-status-open">Open</div>
                    <h2 class="rfp-title"><a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>">Pool Maintenance Services</a></h2>
                    <div class="rfp-meta">
                        <span class="rfp-community">Oakwood Heights</span>
                        <span class="rfp-date">Posted: Apr 2, 2025</span>
                        <span class="rfp-deadline">Deadline: Apr 16, 2025</span>
                        <span class="rfp-proposals">12 Proposals</span>
                    </div>
                    <div class="rfp-description">
                        <p>Seeking professional pool maintenance services for our community pool. Services should include regular cleaning, chemical balancing, equipment maintenance, and repairs as needed.</p>
                    </div>
                    <div class="rfp-actions">
                        <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>" class="btn">View Details</a>
                        <?php if (current_user_can('edit_posts')): ?>
                        <a href="<?php echo esc_url(home_url('/rfp-proposals/pool-maintenance-services/')); ?>" class="btn">View Proposals</a>
                        <?php endif; ?>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <a href="#" class="btn btn-secondary">Edit RFP</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="rfp-item">
                    <div class="rfp-status rfp-status-open">Open</div>
                    <h2 class="rfp-title"><a href="#">Landscaping Contract</a></h2>
                    <div class="rfp-meta">
                        <span class="rfp-community">Riverside Gardens</span>
                        <span class="rfp-date">Posted: Mar 28, 2025</span>
                        <span class="rfp-deadline">Deadline: Apr 11, 2025</span>
                        <span class="rfp-proposals">8 Proposals</span>
                    </div>
                    <div class="rfp-description">
                        <p>Looking for comprehensive landscaping services for our community. Services should include lawn maintenance, seasonal plantings, irrigation system maintenance, and tree care.</p>
                    </div>
                    <div class="rfp-actions">
                        <a href="#" class="btn">View Details</a>
                        <?php if (current_user_can('edit_posts')): ?>
                        <a href="#" class="btn">View Proposals</a>
                        <?php endif; ?>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <a href="#" class="btn btn-secondary">Edit RFP</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="rfp-item">
                    <div class="rfp-status rfp-status-closed">Closed</div>
                    <h2 class="rfp-title"><a href="#">Security System Upgrade</a></h2>
                    <div class="rfp-meta">
                        <span class="rfp-community">Maple Ridge Estates</span>
                        <span class="rfp-date">Posted: Mar 15, 2025</span>
                        <span class="rfp-deadline">Deadline: Mar 29, 2025</span>
                        <span class="rfp-proposals">15 Proposals</span>
                    </div>
                    <div class="rfp-description">
                        <p>Seeking proposals for upgrading our community security system. The project includes replacing cameras, installing access control systems, and implementing a new monitoring solution.</p>
                    </div>
                    <div class="rfp-actions">
                        <a href="#" class="btn">View Details</a>
                        <?php if (current_user_can('edit_posts')): ?>
                        <a href="#" class="btn">View Proposals</a>
                        <?php endif; ?>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <a href="#" class="btn btn-secondary">Edit RFP</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="rfp-item">
                    <div class="rfp-status rfp-status-awarded">Awarded</div>
                    <h2 class="rfp-title"><a href="#">Clubhouse Renovation</a></h2>
                    <div class="rfp-meta">
                        <span class="rfp-community">Sunset Villas</span>
                        <span class="rfp-date">Posted: Feb 28, 2025</span>
                        <span class="rfp-deadline">Deadline: Mar 14, 2025</span>
                        <span class="rfp-proposals">9 Proposals</span>
                    </div>
                    <div class="rfp-description">
                        <p>Comprehensive renovation of our community clubhouse. The project includes updating the interior design, replacing furniture, renovating the kitchen area, and improving accessibility features.</p>
                    </div>
                    <div class="rfp-actions">
                        <a href="#" class="btn">View Details</a>
                        <?php if (current_user_can('edit_posts')): ?>
                        <a href="#" class="btn">View Proposals</a>
                        <?php endif; ?>
                        <?php if (current_user_can('edit_others_posts')): ?>
                        <a href="#" class="btn btn-secondary">Edit RFP</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="rfp-pagination">
                <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                <span class="pagination-current">Page 1 of 3</span>
                <a href="#" class="pagination-next">Next &raquo;</a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
