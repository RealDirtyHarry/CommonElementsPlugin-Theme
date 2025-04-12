<?php
/**
 * Template Name: Submit Proposal
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="rfp-container submit-proposal">
    <div class="rfp-header">
        <div class="container">
            <div class="rfp-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>">RFPs</a> &raquo; 
                <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>">Pool Maintenance Services</a> &raquo; 
                Submit Proposal
            </div>
        </div>
    </div>

    <div class="rfp-content">
        <div class="container">
            <h1 class="page-title">Submit a Proposal</h1>
            
            <div class="rfp-summary">
                <h2>RFP: Pool Maintenance Services</h2>
                <div class="rfp-meta">
                    <div class="meta-item">
                        <span class="meta-label">Posted By:</span>
                        <span class="meta-value">Oakwood Heights HOA</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Deadline:</span>
                        <span class="meta-value">April 16, 2025</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">Maintenance</span>
                    </div>
                </div>
                <div class="rfp-description-summary">
                    <p>Oakwood Heights Community Association is seeking professional pool maintenance services for our community pool. The selected vendor will be responsible for maintaining the pool in compliance with all local health department regulations and ensuring a safe, clean environment for our residents.</p>
                    <a href="<?php echo esc_url(home_url('/rfp/pool-maintenance-services/')); ?>" class="btn btn-text">View Full RFP Details</a>
                </div>
            </div>
            
            <div class="proposal-form-container">
                <!-- This is where the GravityForm would be embedded -->
                <div class="gravity-form-placeholder">
                    <form class="proposal-submission-form">
                        <input type="hidden" name="rfp_id" value="123">
                        
                        <div class="form-section">
                            <h2 class="section-title">Proposal Information</h2>
                            
                            <div class="form-field">
                                <label for="proposal-title">Proposal Title <span class="required">*</span></label>
                                <input type="text" id="proposal-title" name="proposal-title" required placeholder="e.g., Crystal Clear Pools - Maintenance Services Proposal">
                                <div class="field-description">Provide a clear title for your proposal</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-price">Proposed Price <span class="required">*</span></label>
                                <input type="text" id="proposal-price" name="proposal-price" required placeholder="e.g., $12,500/year or $1,000/month">
                                <div class="field-description">Specify your price, including whether it's a one-time fee, monthly, or annual</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-timeline">Proposed Timeline <span class="required">*</span></label>
                                <input type="text" id="proposal-timeline" name="proposal-timeline" required placeholder="e.g., May 1, 2025 - April 30, 2026">
                                <div class="field-description">Specify the timeline for your services</div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="section-title">Proposal Details</h2>
                            
                            <div class="form-field">
                                <label for="proposal-description">Proposal Description <span class="required">*</span></label>
                                <textarea id="proposal-description" name="proposal-description" rows="8" required placeholder="Describe your proposal in detail..."></textarea>
                                <div class="field-description">Provide a comprehensive description of your proposed services, approach, and methodology</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-qualifications">Company Qualifications <span class="required">*</span></label>
                                <textarea id="proposal-qualifications" name="proposal-qualifications" rows="6" required placeholder="Describe your company's qualifications and experience..."></textarea>
                                <div class="field-description">Highlight your company's experience, certifications, and qualifications relevant to this project</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-differentiators">Differentiators</label>
                                <textarea id="proposal-differentiators" name="proposal-differentiators" rows="4" placeholder="What sets your company apart from competitors..."></textarea>
                                <div class="field-description">Explain what makes your company and proposal unique</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-references">References</label>
                                <textarea id="proposal-references" name="proposal-references" rows="4" placeholder="List relevant references with contact information..."></textarea>
                                <div class="field-description">Provide references from similar projects or clients</div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="section-title">Attachments & Contact Information</h2>
                            
                            <div class="form-field">
                                <label for="proposal-attachments">Attachments</label>
                                <input type="file" id="proposal-attachments" name="proposal-attachments" multiple>
                                <div class="field-description">Upload any relevant documents, such as detailed proposals, certifications, sample reports, etc. (max 10MB per file)</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-contact-name">Contact Name <span class="required">*</span></label>
                                <input type="text" id="proposal-contact-name" name="proposal-contact-name" required>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-contact-email">Contact Email <span class="required">*</span></label>
                                <input type="email" id="proposal-contact-email" name="proposal-contact-email" required>
                            </div>
                            
                            <div class="form-field">
                                <label for="proposal-contact-phone">Contact Phone <span class="required">*</span></label>
                                <input type="tel" id="proposal-contact-phone" name="proposal-contact-phone" required>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large">Submit Proposal</button>
                            <button type="button" class="btn btn-secondary">Save Draft</button>
                        </div>
                    </form>
                </div>
                
                <div class="form-sidebar">
                    <div class="sidebar-card">
                        <h3>Proposal Submission Guidelines</h3>
                        <ul class="guidelines-list">
                            <li>Address all requirements specified in the RFP</li>
                            <li>Be clear and specific about your services and pricing</li>
                            <li>Highlight your relevant experience and qualifications</li>
                            <li>Include references from similar projects</li>
                            <li>Attach supporting documentation</li>
                            <li>Submit before the deadline (April 16, 2025)</li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3>What Happens Next?</h3>
                        <ol class="process-list">
                            <li>Your proposal will be reviewed by the community</li>
                            <li>You may be contacted for clarification or additional information</li>
                            <li>Selected vendors may be invited for presentations or interviews</li>
                            <li>The community will select a vendor and award the contract</li>
                            <li>All vendors will be notified of the decision</li>
                        </ol>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3>Need Help?</h3>
                        <p>Contact our support team for assistance with submitting your proposal:</p>
                        <div class="support-contact">
                            <div class="support-email">support@commonelements.com</div>
                            <div class="support-phone">(555) 987-6543</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
