<?php
/**
 * RFP Detail Template
 *
 * This template displays the details of a single RFP.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get the current RFP
global $post;

// Get RFP meta data
$status = get_post_meta( get_the_ID(), 'rfp_status', true );
$due_date = get_post_meta( get_the_ID(), 'rfp_due_date', true );
$community = get_post_meta( get_the_ID(), 'rfp_community', true );
$budget = get_post_meta( get_the_ID(), 'rfp_budget', true );
$contact_name = get_post_meta( get_the_ID(), 'rfp_contact_name', true );
$contact_email = get_post_meta( get_the_ID(), 'rfp_contact_email', true );
$contact_phone = get_post_meta( get_the_ID(), 'rfp_contact_phone', true );
$requirements = get_post_meta( get_the_ID(), 'rfp_requirements', true );
$attachments = get_post_meta( get_the_ID(), 'rfp_attachments', true );

// Format due date
$due_date_formatted = !empty($due_date) ? date_i18n(get_option('date_format'), strtotime($due_date)) : '';

// Get status badge class
$status_class = 'ce-badge-secondary';
if ($status === 'open') {
    $status_class = 'ce-badge-success';
} elseif ($status === 'closed') {
    $status_class = 'ce-badge-info';
} elseif ($status === 'awarded') {
    $status_class = 'ce-badge-secondary';
}

// Get categories
$categories = get_the_terms(get_the_ID(), 'rfp_category');
$category_names = array();
if (!empty($categories) && !is_wp_error($categories)) {
    foreach ($categories as $category) {
        $category_names[] = $category->name;
    }
}

// Check if current user can submit a proposal
$can_submit_proposal = is_user_logged_in() && current_user_can('contributor') && $status === 'open';

// Check if current user has already submitted a proposal
$has_submitted_proposal = false;
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'proposal',
        'posts_per_page' => 1,
        'author' => $current_user->ID,
        'meta_query' => array(
            array(
                'key' => 'related_rfp',
                'value' => get_the_ID(),
                'compare' => '=',
            ),
        ),
    );
    $proposals = get_posts($args);
    $has_submitted_proposal = !empty($proposals);
}

// Get proposals if user is admin or editor
$proposals = array();
if (current_user_can('editor') || current_user_can('administrator')) {
    $args = array(
        'post_type' => 'proposal',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'related_rfp',
                'value' => get_the_ID(),
                'compare' => '=',
            ),
        ),
    );
    $proposals = get_posts($args);
}
?>

<div class="ce-rfp-system">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <div class="ce-breadcrumbs">
                    <a href="<?php echo esc_url(home_url('/rfp')); ?>">RFPs</a> &raquo; <?php the_title(); ?>
                </div>
                <h1 class="ce-section-title"><?php the_title(); ?></h1>
                <div class="ce-rfp-status-badge">
                    <span class="ce-badge <?php echo esc_attr($status_class); ?>"><?php echo esc_html(ucfirst($status)); ?></span>
                </div>
            </div>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">RFP Details</div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-rfp-meta-grid">
                        <?php if (!empty($community)) : ?>
                            <div class="ce-rfp-meta-item">
                                <div class="ce-rfp-meta-label">Community</div>
                                <div class="ce-rfp-meta-value"><?php echo esc_html($community); ?></div>
                            </div>
                        <?php endif; ?>
                        <div class="ce-rfp-meta-item">
                            <div class="ce-rfp-meta-label">Posted Date</div>
                            <div class="ce-rfp-meta-value"><?php echo get_the_date(); ?></div>
                        </div>
                        <?php if (!empty($due_date_formatted)) : ?>
                            <div class="ce-rfp-meta-item">
                                <div class="ce-rfp-meta-label">Due Date</div>
                                <div class="ce-rfp-meta-value"><?php echo esc_html($due_date_formatted); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($category_names)) : ?>
                            <div class="ce-rfp-meta-item">
                                <div class="ce-rfp-meta-label">Category</div>
                                <div class="ce-rfp-meta-value"><?php echo esc_html(implode(', ', $category_names)); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($budget)) : ?>
                            <div class="ce-rfp-meta-item">
                                <div class="ce-rfp-meta-label">Budget</div>
                                <div class="ce-rfp-meta-value"><?php echo esc_html($budget); ?></div>
                            </div>
                        <?php endif; ?>
                        <div class="ce-rfp-meta-item">
                            <div class="ce-rfp-meta-label">Status</div>
                            <div class="ce-rfp-meta-value">
                                <span class="ce-badge <?php echo esc_attr($status_class); ?>"><?php echo esc_html(ucfirst($status)); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ce-rfp-section">
                        <h3 class="ce-rfp-section-title">Description</h3>
                        <div class="ce-rfp-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($requirements)) : ?>
                        <div class="ce-rfp-section">
                            <h3 class="ce-rfp-section-title">Requirements</h3>
                            <div class="ce-rfp-content">
                                <?php echo wp_kses_post($requirements); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($attachments)) : ?>
                        <div class="ce-rfp-section">
                            <h3 class="ce-rfp-section-title">Attachments</h3>
                            <div class="ce-rfp-attachments">
                                <?php
                                $attachment_ids = explode(',', $attachments);
                                foreach ($attachment_ids as $attachment_id) {
                                    $attachment_url = wp_get_attachment_url($attachment_id);
                                    $attachment_title = get_the_title($attachment_id);
                                    $attachment_type = get_post_mime_type($attachment_id);
                                    $attachment_icon = 'fa-file';
                                    
                                    if (strpos($attachment_type, 'pdf') !== false) {
                                        $attachment_icon = 'fa-file-pdf';
                                    } elseif (strpos($attachment_type, 'word') !== false) {
                                        $attachment_icon = 'fa-file-word';
                                    } elseif (strpos($attachment_type, 'excel') !== false || strpos($attachment_type, 'spreadsheet') !== false) {
                                        $attachment_icon = 'fa-file-excel';
                                    } elseif (strpos($attachment_type, 'image') !== false) {
                                        $attachment_icon = 'fa-file-image';
                                    }
                                    
                                    if (!empty($attachment_url)) {
                                        echo '<div class="ce-rfp-attachment">';
                                        echo '<i class="fas ' . esc_attr($attachment_icon) . '"></i>';
                                        echo '<a href="' . esc_url($attachment_url) . '" target="_blank">' . esc_html($attachment_title) . '</a>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($contact_name) || !empty($contact_email) || !empty($contact_phone)) : ?>
                        <div class="ce-rfp-section">
                            <h3 class="ce-rfp-section-title">Contact Information</h3>
                            <div class="ce-rfp-contact">
                                <?php if (!empty($contact_name)) : ?>
                                    <div class="ce-rfp-contact-item">
                                        <div class="ce-rfp-contact-label">Name:</div>
                                        <div class="ce-rfp-contact-value"><?php echo esc_html($contact_name); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($contact_email)) : ?>
                                    <div class="ce-rfp-contact-item">
                                        <div class="ce-rfp-contact-label">Email:</div>
                                        <div class="ce-rfp-contact-value">
                                            <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($contact_phone)) : ?>
                                    <div class="ce-rfp-contact-item">
                                        <div class="ce-rfp-contact-label">Phone:</div>
                                        <div class="ce-rfp-contact-value">
                                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="ce-card-footer">
                    <?php if ($status === 'open') : ?>
                        <?php if ($can_submit_proposal && !$has_submitted_proposal) : ?>
                            <a href="<?php echo esc_url(add_query_arg('rfp_id', get_the_ID(), home_url('/rfp/proposal'))); ?>" class="ce-btn ce-btn-primary">Submit Proposal</a>
                        <?php elseif ($has_submitted_proposal) : ?>
                            <span class="ce-proposal-status">You have already submitted a proposal for this RFP.</span>
                        <?php elseif (!is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="ce-btn ce-btn-primary">Login to Submit Proposal</a>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="ce-proposal-status">This RFP is no longer accepting proposals.</span>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(home_url('/rfp')); ?>" class="ce-btn ce-btn-outline-primary">Back to RFP List</a>
                </div>
            </div>
            
            <?php if (!empty($proposals) && (current_user_can('editor') || current_user_can('administrator'))) : ?>
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-title">Submitted Proposals</div>
                    </div>
                    <div class="ce-card-body">
                        <table class="ce-table ce-table-striped ce-table-hover">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Submitted Date</th>
                                    <th>Bid Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proposals as $proposal) : 
                                    $proposal_status = get_post_meta($proposal->ID, 'proposal_status', true);
                                    $proposal_amount = get_post_meta($proposal->ID, 'proposal_amount', true);
                                    $proposal_status_class = 'ce-badge-warning';
                                    
                                    if ($proposal_status === 'accepted') {
                                        $proposal_status_class = 'ce-badge-success';
                                    } elseif ($proposal_status === 'rejected') {
                                        $proposal_status_class = 'ce-badge-danger';
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo esc_html(get_the_author_meta('display_name', $proposal->post_author)); ?></td>
                                        <td><?php echo get_the_date('', $proposal->ID); ?></td>
                                        <td><?php echo esc_html($proposal_amount); ?></td>
                                        <td><span class="ce-badge <?php echo esc_attr($proposal_status_class); ?>"><?php echo esc_html(ucfirst($proposal_status)); ?></span></td>
                                        <td>
                                            <a href="<?php echo esc_url(get_permalink($proposal->ID)); ?>" class="ce-btn ce-btn-sm ce-btn-primary">View</a>
                                            <?php if ($proposal_status === 'pending') : ?>
                                                <a href="<?php echo esc_url(add_query_arg(array('proposal_id' => $proposal->ID, 'action' => 'accept'), get_permalink())); ?>" class="ce-btn ce-btn-sm ce-btn-success">Accept</a>
                                                <a href="<?php echo esc_url(add_query_arg(array('proposal_id' => $proposal->ID, 'action' => 'reject'), get_permalink())); ?>" class="ce-btn ce-btn-sm ce-btn-danger">Reject</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
