<?php
/**
 * Proposal Submission Form Template
 *
 * This template displays the form for submitting a proposal for an RFP.
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

if ( ! in_array( 'contributor', $roles ) ) {
    wp_redirect( home_url( '/rfp' ) );
    exit;
}

// Check if RFP ID is provided
if ( ! isset( $_GET['rfp_id'] ) || empty( $_GET['rfp_id'] ) ) {
    wp_redirect( home_url( '/rfp' ) );
    exit;
}

$rfp_id = intval( $_GET['rfp_id'] );
$rfp = get_post( $rfp_id );

// Check if RFP exists and is published
if ( ! $rfp || $rfp->post_type !== 'rfp' || $rfp->post_status !== 'publish' ) {
    wp_redirect( home_url( '/rfp' ) );
    exit;
}

// Check if RFP is still open
$rfp_status = get_post_meta( $rfp_id, 'rfp_status', true );
if ( $rfp_status !== 'open' ) {
    wp_redirect( get_permalink( $rfp_id ) );
    exit;
}

// Check if user has already submitted a proposal for this RFP
$args = array(
    'post_type' => 'proposal',
    'posts_per_page' => 1,
    'author' => get_current_user_id(),
    'meta_query' => array(
        array(
            'key' => 'related_rfp',
            'value' => $rfp_id,
            'compare' => '=',
        ),
    ),
);
$existing_proposals = get_posts( $args );
if ( ! empty( $existing_proposals ) ) {
    wp_redirect( get_permalink( $rfp_id ) );
    exit;
}

// Get RFP meta data
$due_date = get_post_meta( $rfp_id, 'rfp_due_date', true );
$community = get_post_meta( $rfp_id, 'rfp_community', true );
$budget = get_post_meta( $rfp_id, 'rfp_budget', true );

// Format due date
$due_date_formatted = ! empty( $due_date ) ? date_i18n( get_option( 'date_format' ), strtotime( $due_date ) ) : '';

// Check if form is submitted
$form_submitted = false;
$form_errors = array();
$form_success = false;

if ( isset( $_POST['submit_proposal'] ) && isset( $_POST['proposal_nonce'] ) && wp_verify_nonce( $_POST['proposal_nonce'], 'submit_proposal_nonce' ) ) {
    $form_submitted = true;
    
    // Validate required fields
    if ( empty( $_POST['proposal_amount'] ) ) {
        $form_errors[] = 'Proposal amount is required.';
    }
    
    if ( empty( $_POST['proposal_description'] ) ) {
        $form_errors[] = 'Proposal description is required.';
    }
    
    // If no errors, create the proposal
    if ( empty( $form_errors ) ) {
        $proposal_data = array(
            'post_title'    => 'Proposal for ' . get_the_title( $rfp_id ),
            'post_content'  => wp_kses_post( $_POST['proposal_description'] ),
            'post_status'   => 'publish',
            'post_type'     => 'proposal',
            'post_author'   => get_current_user_id(),
        );
        
        $proposal_id = wp_insert_post( $proposal_data );
        
        if ( ! is_wp_error( $proposal_id ) ) {
            // Save proposal meta data
            update_post_meta( $proposal_id, 'related_rfp', $rfp_id );
            update_post_meta( $proposal_id, 'proposal_status', 'pending' );
            update_post_meta( $proposal_id, 'proposal_amount', sanitize_text_field( $_POST['proposal_amount'] ) );
            
            if ( ! empty( $_POST['proposal_timeline'] ) ) {
                update_post_meta( $proposal_id, 'proposal_timeline', sanitize_text_field( $_POST['proposal_timeline'] ) );
            }
            
            if ( ! empty( $_POST['proposal_experience'] ) ) {
                update_post_meta( $proposal_id, 'proposal_experience', wp_kses_post( $_POST['proposal_experience'] ) );
            }
            
            if ( ! empty( $_POST['proposal_references'] ) ) {
                update_post_meta( $proposal_id, 'proposal_references', wp_kses_post( $_POST['proposal_references'] ) );
            }
            
            // Handle attachments
            if ( ! empty( $_FILES['proposal_attachments']['name'][0] ) ) {
                $attachment_ids = array();
                
                for ( $i = 0; $i < count( $_FILES['proposal_attachments']['name'] ); $i++ ) {
                    $file = array(
                        'name'     => $_FILES['proposal_attachments']['name'][$i],
                        'type'     => $_FILES['proposal_attachments']['type'][$i],
                        'tmp_name' => $_FILES['proposal_attachments']['tmp_name'][$i],
                        'error'    => $_FILES['proposal_attachments']['error'][$i],
                        'size'     => $_FILES['proposal_attachments']['size'][$i]
                    );
                    
                    $upload_overrides = array( 'test_form' => false );
                    $uploaded_file = wp_handle_upload( $file, $upload_overrides );
                    
                    if ( ! isset( $uploaded_file['error'] ) ) {
                        $filename = $uploaded_file['file'];
                        $filetype = wp_check_filetype( basename( $filename ), null );
                        $wp_upload_dir = wp_upload_dir();
                        
                        $attachment = array(
                            'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
                            'post_mime_type' => $filetype['type'],
                            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        );
                        
                        $attach_id = wp_insert_attachment( $attachment, $filename, $proposal_id );
                        
                        if ( ! is_wp_error( $attach_id ) ) {
                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            $attachment_ids[] = $attach_id;
                        }
                    }
                }
                
                if ( ! empty( $attachment_ids ) ) {
                    update_post_meta( $proposal_id, 'proposal_attachments', implode( ',', $attachment_ids ) );
                }
            }
            
            // Send notification to RFP author
            $rfp_author_id = $rfp->post_author;
            $rfp_author = get_userdata( $rfp_author_id );
            $vendor_name = get_the_author_meta( 'display_name', get_current_user_id() );
            
            if ( $rfp_author && ! empty( $rfp_author->user_email ) ) {
                $subject = 'New Proposal Received for ' . get_the_title( $rfp_id );
                $message = "Hello,\n\n";
                $message .= "A new proposal has been submitted for your RFP: " . get_the_title( $rfp_id ) . "\n\n";
                $message .= "Vendor: " . $vendor_name . "\n";
                $message .= "Proposal Amount: " . sanitize_text_field( $_POST['proposal_amount'] ) . "\n\n";
                $message .= "To view the full proposal, please log in to your account and visit the RFP details page.\n\n";
                $message .= "Thank you,\n";
                $message .= get_bloginfo( 'name' );
                
                wp_mail( $rfp_author->user_email, $subject, $message );
            }
            
            $form_success = true;
            wp_redirect( get_permalink( $rfp_id ) );
            exit;
        } else {
            $form_errors[] = 'Error submitting proposal. Please try again.';
        }
    }
}
?>

<div class="ce-rfp-system">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <div class="ce-breadcrumbs">
                    <a href="<?php echo esc_url( home_url( '/rfp' ) ); ?>">RFPs</a> &raquo; 
                    <a href="<?php echo esc_url( get_permalink( $rfp_id ) ); ?>"><?php echo esc_html( get_the_title( $rfp_id ) ); ?></a> &raquo; 
                    Submit Proposal
                </div>
                <h1 class="ce-section-title">Submit Proposal</h1>
            </div>
            
            <?php if ( $form_submitted && ! empty( $form_errors ) ) : ?>
                <div class="ce-alert ce-alert-danger">
                    <ul>
                        <?php foreach ( $form_errors as $error ) : ?>
                            <li><?php echo esc_html( $error ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if ( $form_success ) : ?>
                <div class="ce-alert ce-alert-success">
                    <p>Proposal submitted successfully!</p>
                </div>
            <?php endif; ?>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">RFP Summary</div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-rfp-summary">
                        <h3 class="ce-rfp-summary-title"><?php echo esc_html( get_the_title( $rfp_id ) ); ?></h3>
                        
                        <div class="ce-rfp-meta-grid">
                            <?php if ( ! empty( $community ) ) : ?>
                                <div class="ce-rfp-meta-item">
                                    <div class="ce-rfp-meta-label">Community</div>
                                    <div class="ce-rfp-meta-value"><?php echo esc_html( $community ); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="ce-rfp-meta-item">
                                <div class="ce-rfp-meta-label">Posted Date</div>
                                <div class="ce-rfp-meta-value"><?php echo get_the_date( '', $rfp_id ); ?></div>
                            </div>
                            <?php if ( ! empty( $due_date_formatted ) ) : ?>
                                <div class="ce-rfp-meta-item">
                                    <div class="ce-rfp-meta-label">Due Date</div>
                                    <div class="ce-rfp-meta-value"><?php echo esc_html( $due_date_formatted ); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $budget ) ) : ?>
                                <div class="ce-rfp-meta-item">
                                    <div class="ce-rfp-meta-label">Budget</div>
                                    <div class="ce-rfp-meta-value"><?php echo esc_html( $budget ); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="ce-rfp-summary-description">
                            <?php echo apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $rfp_id ) ); ?>
                        </div>
                        
                        <div class="ce-rfp-summary-actions">
                            <a href="<?php echo esc_url( get_permalink( $rfp_id ) ); ?>" class="ce-btn ce-btn-outline-primary" target="_blank">View Full RFP Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">Proposal Information</div>
                </div>
                <div class="ce-card-body">
                    <form action="" method="post" enctype="multipart/form-data" class="ce-form">
                        <?php wp_nonce_field( 'submit_proposal_nonce', 'proposal_nonce' ); ?>
                        
                        <div class="ce-form-section">
                            <h3 class="ce-form-section-title">Basic Information</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="proposal_amount" class="ce-form-label">Proposal Amount <span class="ce-required">*</span></label>
                                        <input type="text" id="proposal_amount" name="proposal_amount" class="ce-form-control" value="<?php echo isset( $_POST['proposal_amount'] ) ? esc_attr( $_POST['proposal_amount'] ) : ''; ?>" placeholder="e.g. $8,500" required>
                                        <div class="ce-form-text">Enter your proposed bid amount.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="proposal_timeline" class="ce-form-label">Estimated Timeline</label>
                                        <input type="text" id="proposal_timeline" name="proposal_timeline" class="ce-form-control" value="<?php echo isset( $_POST['proposal_timeline'] ) ? esc_attr( $_POST['proposal_timeline'] ) : ''; ?>" placeholder="e.g. 4-6 weeks">
                                        <div class="ce-form-text">Enter your estimated timeline for project completion.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ce-form-section">
                            <h3 class="ce-form-section-title">Proposal Details</h3>
                            
                            <div class="ce-form-group">
                                <label for="proposal_description" class="ce-form-label">Proposal Description <span class="ce-required">*</span></label>
                                <textarea id="proposal_description" name="proposal_description" class="ce-form-control" rows="6" required><?php echo isset( $_POST['proposal_description'] ) ? esc_textarea( $_POST['proposal_description'] ) : ''; ?></textarea>
                                <div class="ce-form-text">Provide a detailed description of your proposal, including your approach, methodology, and any unique value propositions.</div>
                            </div>
                            
                            <div class="ce-form-group">
                                <label for="proposal_experience" class="ce-form-label">Relevant Experience</label>
                                <textarea id="proposal_experience" name="proposal_experience" class="ce-form-control" rows="4"><?php echo isset( $_POST['proposal_experience'] ) ? esc_textarea( $_POST['proposal_experience'] ) : ''; ?></textarea>
                                <div class="ce-form-text">Describe your relevant experience and qualifications for this project.</div>
                            </div>
                            
                            <div class="ce-form-group">
                                <label for="proposal_references" class="ce-form-label">References</label>
                                <textarea id="proposal_references" name="proposal_references" class="ce-form-control" rows="4"><?php echo isset( $_POST['proposal_references'] ) ? esc_textarea( $_POST['proposal_references'] ) : ''; ?></textarea>
                                <div class="ce-form-text">Provide references from similar projects or clients.</div>
                            </div>
                            
                            <div class="ce-form-group">
                                <label for="proposal_attachments" class="ce-form-label">Attachments</label>
                                <input type="file" id="proposal_attachments" name="proposal_attachments[]" class="ce-form-control-file" multiple>
                                <div class="ce-form-text">Upload any relevant documents, such as detailed proposals, portfolios, certifications, or supporting materials. (PDF, Word, Excel, Images)</div>
                            </div>
                        </div>
                        
                        <div class="ce-form-actions">
                            <button type="submit" name="submit_proposal" class="ce-btn ce-btn-primary">Submit Proposal</button>
                            <a href="<?php echo esc_url( get_permalink( $rfp_id ) ); ?>" class="ce-btn ce-btn-outline-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any JavaScript functionality here
        const proposalDescriptionField = document.getElementById('proposal_description');
        const proposalExperienceField = document.getElementById('proposal_experience');
        const proposalReferencesField = document.getElementById('proposal_references');
        
        if (typeof wp !== 'undefined' && wp.editor) {
            wp.editor.initialize('proposal_description', {
                tinymce: {
                    wpautop: true,
                    plugins: 'lists,paste,tabfocus,wplink,wordpress',
                    toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker,wp_adv',
                    toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                },
                quicktags: true
            });
            
            wp.editor.initialize('proposal_experience', {
                tinymce: {
                    wpautop: true,
                    plugins: 'lists,paste,tabfocus,wplink,wordpress',
                    toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker,wp_adv',
                    toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                },
                quicktags: true
            });
            
            wp.editor.initialize('proposal_references', {
                tinymce: {
                    wpautop: true,
                    plugins: 'lists,paste,tabfocus,wplink,wordpress',
                    toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker,wp_adv',
                    toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                },
                quicktags: true
            });
        }
    });
</script>
