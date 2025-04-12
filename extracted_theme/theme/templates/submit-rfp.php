<?php
/**
 * Template Name: Submit RFP
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="rfp-container submit-rfp">
    <div class="rfp-header">
        <div class="container">
            <div class="rfp-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>">RFPs</a> &raquo; Submit New RFP
            </div>
        </div>
    </div>

    <div class="rfp-content">
        <div class="container">
            <h1 class="page-title">Submit a New Request for Proposal</h1>
            
            <div class="rfp-form-container">
                <!-- This is where the GravityForm would be embedded -->
                <div class="gravity-form-placeholder">
                    <form class="rfp-submission-form">
                        <div class="form-section">
                            <h2 class="section-title">Basic Information</h2>
                            
                            <div class="form-field">
                                <label for="rfp-title">RFP Title <span class="required">*</span></label>
                                <input type="text" id="rfp-title" name="rfp-title" required placeholder="e.g., Pool Maintenance Services">
                                <div class="field-description">Provide a clear, descriptive title for your RFP</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-category">Category <span class="required">*</span></label>
                                <select id="rfp-category" name="rfp-category" required>
                                    <option value="">Select a category</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="renovation">Renovation</option>
                                    <option value="landscaping">Landscaping</option>
                                    <option value="security">Security</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-community">Community <span class="required">*</span></label>
                                <select id="rfp-community" name="rfp-community" required>
                                    <option value="">Select a community</option>
                                    <option value="oakwood-heights">Oakwood Heights</option>
                                    <option value="riverside-gardens">Riverside Gardens</option>
                                    <option value="maple-ridge-estates">Maple Ridge Estates</option>
                                    <option value="sunset-villas">Sunset Villas</option>
                                    <option value="pinecrest-commons">Pinecrest Commons</option>
                                </select>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-deadline">Submission Deadline <span class="required">*</span></label>
                                <input type="date" id="rfp-deadline" name="rfp-deadline" required>
                                <div class="field-description">The date by which vendors must submit their proposals</div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="section-title">Project Details</h2>
                            
                            <div class="form-field">
                                <label for="rfp-description">Project Description <span class="required">*</span></label>
                                <textarea id="rfp-description" name="rfp-description" rows="6" required placeholder="Describe the project in detail..."></textarea>
                                <div class="field-description">Provide a comprehensive description of the project, including background information and objectives</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-scope">Scope of Work <span class="required">*</span></label>
                                <textarea id="rfp-scope" name="rfp-scope" rows="6" required placeholder="List the specific tasks and deliverables..."></textarea>
                                <div class="field-description">Clearly define what is included in the scope of work</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-requirements">Requirements <span class="required">*</span></label>
                                <textarea id="rfp-requirements" name="rfp-requirements" rows="6" required placeholder="List vendor qualifications and requirements..."></textarea>
                                <div class="field-description">Specify any vendor qualifications, certifications, or other requirements</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-timeline">Project Timeline</label>
                                <textarea id="rfp-timeline" name="rfp-timeline" rows="4" placeholder="Outline key project dates and milestones..."></textarea>
                                <div class="field-description">Provide a timeline for the project, including start date, milestones, and completion date</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-selection">Selection Criteria</label>
                                <textarea id="rfp-selection" name="rfp-selection" rows="4" placeholder="Explain how proposals will be evaluated..."></textarea>
                                <div class="field-description">Describe how proposals will be evaluated and the criteria for selection</div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="section-title">Attachments & Contact Information</h2>
                            
                            <div class="form-field">
                                <label for="rfp-attachments">Attachments</label>
                                <input type="file" id="rfp-attachments" name="rfp-attachments" multiple>
                                <div class="field-description">Upload any relevant documents, specifications, photos, or other files (max 10MB per file)</div>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-contact-name">Contact Name <span class="required">*</span></label>
                                <input type="text" id="rfp-contact-name" name="rfp-contact-name" required>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-contact-email">Contact Email <span class="required">*</span></label>
                                <input type="email" id="rfp-contact-email" name="rfp-contact-email" required>
                            </div>
                            
                            <div class="form-field">
                                <label for="rfp-contact-phone">Contact Phone</label>
                                <input type="tel" id="rfp-contact-phone" name="rfp-contact-phone">
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large">Submit RFP</button>
                            <button type="button" class="btn btn-secondary">Save Draft</button>
                        </div>
                    </form>
                </div>
                
                <div class="form-sidebar">
                    <div class="sidebar-card">
                        <h3>RFP Submission Guidelines</h3>
                        <ul class="guidelines-list">
                            <li>Provide clear, detailed information to attract qualified vendors</li>
                            <li>Be specific about requirements and expectations</li>
                            <li>Include all relevant documents and specifications</li>
                            <li>Set a reasonable deadline (typically 2-4 weeks)</li>
                            <li>Clearly define the selection criteria</li>
                            <li>Include contact information for questions</li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3>What Happens Next?</h3>
                        <ol class="process-list">
                            <li>Your RFP will be reviewed and published</li>
                            <li>Vendors will be notified of the new opportunity</li>
                            <li>You'll receive proposals through the system</li>
                            <li>Review and evaluate proposals</li>
                            <li>Select a vendor and award the contract</li>
                        </ol>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3>Need Help?</h3>
                        <p>Contact our support team for assistance with creating your RFP:</p>
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
