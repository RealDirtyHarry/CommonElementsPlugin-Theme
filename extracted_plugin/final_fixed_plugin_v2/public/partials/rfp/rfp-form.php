<?php
/**
 * RFP Submission Form Template
 *
 * This template displays the form for creating a new RFP.
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

if ( ! ( in_array( 'editor', $roles ) || in_array( 'administrator', $roles ) || in_array( 'author', $roles ) ) ) {
    wp_redirect( home_url( '/rfp' ) );
    exit;
}

// Check if form is submitted
$form_submitted = false;
$form_errors = array();
$form_success = false;

if ( isset( $_POST['submit_rfp'] ) && isset( $_POST['rfp_nonce'] ) && wp_verify_nonce( $_POST['rfp_nonce'], 'submit_rfp_nonce' ) ) {
    $form_submitted = true;
    
    // Validate required fields
    if ( empty( $_POST['rfp_title'] ) ) {
        $form_errors[] = 'RFP title is required.';
    }
    
    if ( empty( $_POST['rfp_description'] ) ) {
        $form_errors[] = 'RFP description is required.';
    }
    
    if ( empty( $_POST['rfp_due_date'] ) ) {
        $form_errors[] = 'Due date is required.';
    }
    
    // If no errors, create the RFP
    if ( empty( $form_errors ) ) {
        $rfp_data = array(
            'post_title'    => sanitize_text_field( $_POST['rfp_title'] ),
            'post_content'  => wp_kses_post( $_POST['rfp_description'] ),
            'post_status'   => 'publish',
            'post_type'     => 'rfp',
            'post_author'   => get_current_user_id(),
        );
        
        $rfp_id = wp_insert_post( $rfp_data );
        
        if ( ! is_wp_error( $rfp_id ) ) {
            // Save RFP meta data
            update_post_meta( $rfp_id, 'rfp_status', 'open' );
            update_post_meta( $rfp_id, 'rfp_due_date', sanitize_text_field( $_POST['rfp_due_date'] ) );
            
            if ( ! empty( $_POST['rfp_community'] ) ) {
                update_post_meta( $rfp_id, 'rfp_community', sanitize_text_field( $_POST['rfp_community'] ) );
            }
            
            if ( ! empty( $_POST['rfp_budget'] ) ) {
                update_post_meta( $rfp_id, 'rfp_budget', sanitize_text_field( $_POST['rfp_budget'] ) );
            }
            
            if ( ! empty( $_POST['rfp_requirements'] ) ) {
                update_post_meta( $rfp_id, 'rfp_requirements', wp_kses_post( $_POST['rfp_requirements'] ) );
            }
            
            if ( ! empty( $_POST['rfp_contact_name'] ) ) {
                update_post_meta( $rfp_id, 'rfp_contact_name', sanitize_text_field( $_POST['rfp_contact_name'] ) );
            }
            
            if ( ! empty( $_POST['rfp_contact_email'] ) ) {
                update_post_meta( $rfp_id, 'rfp_contact_email', sanitize_email( $_POST['rfp_contact_email'] ) );
            }
            
            if ( ! empty( $_POST['rfp_contact_phone'] ) ) {
                update_post_meta( $rfp_id, 'rfp_contact_phone', sanitize_text_field( $_POST['rfp_contact_phone'] ) );
            }
            
            // Handle categories
            if ( ! empty( $_POST['rfp_category'] ) ) {
                wp_set_object_terms( $rfp_id, (int) $_POST['rfp_category'], 'rfp_category' );
            }
            
            // Handle attachments
            if ( ! empty( $_FILES['rfp_attachments']['name'][0] ) ) {
                $attachment_ids = array();
                
                for ( $i = 0; $i < count( $_FILES['rfp_attachments']['name'] ); $i++ ) {
                    $file = array(
                        'name'     => $_FILES['rfp_attachments']['name'][$i],
                        'type'     => $_FILES['rfp_attachments']['type'][$i],
                        'tmp_name' => $_FILES['rfp_attachments']['tmp_name'][$i],
                        'error'    => $_FILES['rfp_attachments']['error'][$i],
                        'size'     => $_FILES['rfp_attachments']['size'][$i]
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
                        
                        $attach_id = wp_insert_attachment( $attachment, $filename, $rfp_id );
                        
                        if ( ! is_wp_error( $attach_id ) ) {
                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            $attachment_ids[] = $attach_id;
                        }
                    }
                }
                
                if ( ! empty( $attachment_ids ) ) {
                    update_post_meta( $rfp_id, 'rfp_attachments', implode( ',', $attachment_ids ) );
                }
            }
            
            $form_success = true;
            wp_redirect( get_permalink( $rfp_id ) );
            exit;
        } else {
            $form_errors[] = 'Error creating RFP. Please try again.';
        }
    }
}
?>

<div class="ce-rfp-system">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <div class="ce-breadcrumbs">
                    <a href="<?php echo esc_url( home_url( '/rfp' ) ); ?>">RFPs</a> &raquo; Create New RFP
                </div>
                <h1 class="ce-section-title">Create New Request for Proposal</h1>
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
                    <p>RFP created successfully!</p>
                </div>
            <?php endif; ?>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">RFP Information</div>
                </div>
                <div class="ce-card-body">
                    <form action="" method="post" enctype="multipart/form-data" class="ce-form">
                        <?php wp_nonce_field( 'submit_rfp_nonce', 'rfp_nonce' ); ?>
                        
                        <div class="ce-form-section">
                            <h3 class="ce-form-section-title">Basic Information</h3>
                            
                            <div class="ce-form-group">
                                <label for="rfp_title" class="ce-form-label">RFP Title <span class="ce-required">*</span></label>
                                <input type="text" id="rfp_title" name="rfp_title" class="ce-form-control" value="<?php echo isset( $_POST['rfp_title'] ) ? esc_attr( $_POST['rfp_title'] ) : ''; ?>" required>
                                <div class="ce-form-text">Enter a descriptive title for the RFP.</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="rfp_category" class="ce-form-label">Category</label>
                                        <select id="rfp_category" name="rfp_category" class="ce-form-select">
                                            <option value="">Select Category</option>
                                            <?php
                                            $categories = get_terms( array(
                                                'taxonomy' => 'rfp_category',
                                                'hide_empty' => false,
                                            ) );
                                            
                                            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                                                foreach ( $categories as $category ) {
                                                    $selected = isset( $_POST['rfp_category'] ) && $_POST['rfp_category'] == $category->term_id ? 'selected' : '';
                                                    echo '<option value="' . esc_attr( $category->term_id ) . '" ' . $selected . '>' . esc_html( $category->name ) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="rfp_community" class="ce-form-label">Community</label>
                                        <input type="text" id="rfp_community" name="rfp_community" class="ce-form-control" value="<?php echo isset( $_POST['rfp_community'] ) ? esc_attr( $_POST['rfp_community'] ) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="rfp_due_date" class="ce-form-label">Due Date <span class="ce-required">*</span></label>
                                        <input type="date" id="rfp_due_date" name="rfp_due_date" class="ce-form-control" value="<?php echo isset( $_POST['rfp_due_date'] ) ? esc_attr( $_POST['rfp_due_date'] ) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ce-form-group">
                                        <label for="rfp_budget" class="ce-form-label">Budget</label>
                                        <input type="text" id="rfp_budget" name="rfp_budget" class="ce-form-control" value="<?php echo isset( $_POST['rfp_budget'] ) ? esc_attr( $_POST['rfp_budget'] ) : ''; ?>" placeholder="e.g. $5,000 - $10,000">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ce-form-section">
                            <h3 class="ce-form-section-title">RFP Details</h3>
                            
                            <div class="ce-form-group">
                                <label for="rfp_description" class="ce-form-label">Description <span class="ce-required">*</span></label>
                                <textarea id="rfp_description" name="rfp_description" class="ce-form-control" rows="6" required><?php echo isset( $_POST['rfp_description'] ) ? esc_textarea( $_POST['rfp_description'] ) : ''; ?></textarea>
                                <div class="ce-form-text">Provide a detailed description of the project or service needed.</div>
                            </div>
                            
                            <div class="ce-form-group">
                                <label for="rfp_requirements" class="ce-form-label">Requirements</label>
                                <textarea id="rfp_requirements" name="rfp_requirements" class="ce-form-control" rows="6"><?php echo isset( $_POST['rfp_requirements'] ) ? esc_textarea( $_POST['rfp_requirements'] ) : ''; ?></textarea>
                                <div class="ce-form-text">List specific requirements, qualifications, or deliverables expected from vendors.</div>
                            </div>
                            
                            <div class="ce-form-group">
                                <label for="rfp_attachments" class="ce-form-label">Attachments</label>
                                <input type="file" id="rfp_attachments" name="rfp_attachments[]" class="ce-form-control-file" multiple>
                                <div class="ce-form-text">Upload any relevant documents, specifications, or supporting materials. (PDF, Word, Excel, Images)</div>
                            </div>
                        </div>
                        
                        <div class="ce-form-section">
                            <h3 class="ce-form-section-title">Contact Information</h3>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ce-form-group">
                                        <label for="rfp_contact_name" class="ce-form-label">Contact Name</label>
                                        <input type="text" id="rfp_contact_name" name="rfp_contact_name" class="ce-form-control" value="<?php echo isset( $_POST['rfp_contact_name'] ) ? esc_attr( $_POST['rfp_contact_name'] ) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="ce-form-group">
                                        <label for="rfp_contact_email" class="ce-form-label">Contact Email</label>
                                        <input type="email" id="rfp_contact_email" name="rfp_contact_email" class="ce-form-control" value="<?php echo isset( $_POST['rfp_contact_email'] ) ? esc_attr( $_POST['rfp_contact_email'] ) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="ce-form-group">
                                        <label for="rfp_contact_phone" class="ce-form-label">Contact Phone</label>
                                        <input type="tel" id="rfp_contact_phone" name="rfp_contact_phone" class="ce-form-control" value="<?php echo isset( $_POST['rfp_contact_phone'] ) ? esc_attr( $_POST['rfp_contact_phone'] ) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ce-form-actions">
                            <button type="submit" name="submit_rfp" class="ce-btn ce-btn-primary">Create RFP</button>
                            <a href="<?php echo esc_url( home_url( '/rfp' ) ); ?>" class="ce-btn ce-btn-outline-primary">Cancel</a>
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
        const rfpDescriptionField = document.getElementById('rfp_description');
        const rfpRequirementsField = document.getElementById('rfp_requirements');
        
        if (typeof wp !== 'undefined' && wp.editor) {
            wp.editor.initialize('rfp_description', {
                tinymce: {
                    wpautop: true,
                    plugins: 'lists,paste,tabfocus,wplink,wordpress',
                    toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker,wp_adv',
                    toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                },
                quicktags: true
            });
            
            wp.editor.initialize('rfp_requirements', {
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
