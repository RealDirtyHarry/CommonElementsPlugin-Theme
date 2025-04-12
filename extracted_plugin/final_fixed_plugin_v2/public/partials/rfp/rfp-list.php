<?php
/**
 * RFP Listing Template
 *
 * This template displays a list of RFPs.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get RFPs from the query
global $query;
if ( ! isset( $query ) ) {
    $query = $GLOBALS['wp_query'];
}
?>

<div class="ce-rfp-system">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <h1 class="ce-section-title">Request for Proposals</h1>
                <?php if ( is_user_logged_in() && ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) || current_user_can( 'author' ) ) ) : ?>
                    <div class="ce-section-actions">
                        <a href="<?php echo esc_url( home_url( '/rfp/new' ) ); ?>" class="ce-btn ce-btn-primary">Create New RFP</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">Available RFPs</div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-rfp-filters">
                        <form action="<?php echo esc_url( home_url( '/rfp' ) ); ?>" method="get" class="ce-filter-form">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="ce-form-group">
                                        <label class="ce-form-label">Category</label>
                                        <select name="category" class="ce-form-select">
                                            <option value="">All Categories</option>
                                            <?php
                                            $categories = get_terms( array(
                                                'taxonomy' => 'rfp_category',
                                                'hide_empty' => false,
                                            ) );
                                            
                                            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                                                foreach ( $categories as $category ) {
                                                    $selected = isset( $_GET['category'] ) && $_GET['category'] === $category->slug ? 'selected' : '';
                                                    echo '<option value="' . esc_attr( $category->slug ) . '" ' . $selected . '>' . esc_html( $category->name ) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="ce-form-group">
                                        <label class="ce-form-label">Status</label>
                                        <select name="status" class="ce-form-select">
                                            <option value="">All Statuses</option>
                                            <option value="open" <?php selected( isset( $_GET['status'] ) && $_GET['status'] === 'open' ); ?>>Open</option>
                                            <option value="closed" <?php selected( isset( $_GET['status'] ) && $_GET['status'] === 'closed' ); ?>>Closed</option>
                                            <option value="awarded" <?php selected( isset( $_GET['status'] ) && $_GET['status'] === 'awarded' ); ?>>Awarded</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="ce-form-group">
                                        <label class="ce-form-label">Sort By</label>
                                        <select name="orderby" class="ce-form-select">
                                            <option value="date" <?php selected( ! isset( $_GET['orderby'] ) || $_GET['orderby'] === 'date' ); ?>>Date Posted</option>
                                            <option value="due_date" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'due_date' ); ?>>Due Date</option>
                                            <option value="title" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'title' ); ?>>Title</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="ce-form-group">
                                        <label class="ce-form-label">&nbsp;</label>
                                        <button type="submit" class="ce-btn ce-btn-primary ce-btn-block">Apply Filters</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <?php if ( $query->have_posts() ) : ?>
                        <div class="ce-rfp-list">
                            <?php while ( $query->have_posts() ) : $query->the_post(); 
                                // Get RFP meta data
                                $status = get_post_meta( get_the_ID(), 'rfp_status', true );
                                $due_date = get_post_meta( get_the_ID(), 'rfp_due_date', true );
                                $community = get_post_meta( get_the_ID(), 'rfp_community', true );
                                $budget = get_post_meta( get_the_ID(), 'rfp_budget', true );
                                
                                // Format due date
                                $due_date_formatted = ! empty( $due_date ) ? date_i18n( get_option( 'date_format' ), strtotime( $due_date ) ) : '';
                                
                                // Get status badge class
                                $status_class = 'ce-badge-secondary';
                                if ( $status === 'open' ) {
                                    $status_class = 'ce-badge-success';
                                } elseif ( $status === 'closed' ) {
                                    $status_class = 'ce-badge-info';
                                } elseif ( $status === 'awarded' ) {
                                    $status_class = 'ce-badge-secondary';
                                }
                            ?>
                                <div class="ce-rfp-item">
                                    <div class="ce-rfp-header">
                                        <h3 class="ce-rfp-title"><?php the_title(); ?></h3>
                                        <div class="ce-rfp-status">
                                            <span class="ce-badge <?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( ucfirst( $status ) ); ?></span>
                                        </div>
                                    </div>
                                    <div class="ce-rfp-body">
                                        <div class="ce-rfp-meta">
                                            <?php if ( ! empty( $community ) ) : ?>
                                                <div class="ce-rfp-meta-item">
                                                    <div class="ce-rfp-meta-label">Community</div>
                                                    <div class="ce-rfp-meta-value"><?php echo esc_html( $community ); ?></div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ce-rfp-meta-item">
                                                <div class="ce-rfp-meta-label">Posted Date</div>
                                                <div class="ce-rfp-meta-value"><?php echo get_the_date(); ?></div>
                                            </div>
                                            <?php if ( ! empty( $due_date_formatted ) ) : ?>
                                                <div class="ce-rfp-meta-item">
                                                    <div class="ce-rfp-meta-label">Due Date</div>
                                                    <div class="ce-rfp-meta-value"><?php echo esc_html( $due_date_formatted ); ?></div>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                            $categories = get_the_terms( get_the_ID(), 'rfp_category' );
                                            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                                                $category_names = array();
                                                foreach ( $categories as $category ) {
                                                    $category_names[] = $category->name;
                                                }
                                            ?>
                                                <div class="ce-rfp-meta-item">
                                                    <div class="ce-rfp-meta-label">Category</div>
                                                    <div class="ce-rfp-meta-value"><?php echo esc_html( implode( ', ', $category_names ) ); ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ce-rfp-description">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                    <div class="ce-rfp-footer">
                                        <a href="<?php the_permalink(); ?>" class="ce-btn ce-btn-primary">View Details</a>
                                        <?php if ( $status === 'open' && is_user_logged_in() && current_user_can( 'contributor' ) ) : ?>
                                            <a href="<?php echo esc_url( add_query_arg( 'rfp_id', get_the_ID(), home_url( '/rfp/proposal' ) ) ); ?>" class="ce-btn ce-btn-secondary">Submit Proposal</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php
                        // Pagination
                        $big = 999999999;
                        echo '<div class="ce-pagination">';
                        echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format' => '?paged=%#%',
                            'current' => max( 1, get_query_var( 'paged' ) ),
                            'total' => $query->max_num_pages,
                            'prev_text' => '&laquo; Previous',
                            'next_text' => 'Next &raquo;',
                        ) );
                        echo '</div>';
                        ?>
                        
                    <?php else : ?>
                        <div class="ce-alert ce-alert-info">
                            <p>No RFPs found matching your criteria. Please try different filters or check back later.</p>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
