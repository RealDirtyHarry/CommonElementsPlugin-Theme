<?php
/**
 * Template Name: Single RFP
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="rfp-container single-rfp">
    <div class="rfp-header">
        <div class="container">
            <div class="rfp-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/rfp/')); ?>">RFPs</a> &raquo; Pool Maintenance Services
            </div>
            <div class="rfp-actions">
                <?php if (current_user_can('edit_posts')): ?>
                <a href="<?php echo esc_url(home_url('/rfp-proposals/pool-maintenance-services/')); ?>" class="btn btn-primary">View Proposals</a>
                <?php endif; ?>
                <?php if (current_user_can('edit_others_posts')): ?>
                <a href="#" class="btn btn-secondary">Edit RFP</a>
                <?php endif; ?>
                <?php if (current_user_can('contributor')): ?>
                <a href="<?php echo esc_url(home_url('/submit-proposal/?rfp_id=123')); ?>" class="btn btn-primary">Submit Proposal</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="rfp-content">
        <div class="container">
            <div class="rfp-details">
                <div class="rfp-status-banner rfp-status-open">Open for Proposals</div>
                
                <h1 class="rfp-title">Pool Maintenance Services</h1>
                
                <div class="rfp-meta">
                    <div class="meta-item">
                        <span class="meta-label">Posted By:</span>
                        <span class="meta-value">Oakwood Heights HOA</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Posted Date:</span>
                        <span class="meta-value">April 2, 2025</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Deadline:</span>
                        <span class="meta-value">April 16, 2025</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">Maintenance</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Proposals:</span>
                        <span class="meta-value">12 submitted</span>
                    </div>
                </div>
                
                <div class="rfp-description">
                    <h2>Project Description</h2>
                    <p>Oakwood Heights Community Association is seeking professional pool maintenance services for our community pool. The selected vendor will be responsible for maintaining the pool in compliance with all local health department regulations and ensuring a safe, clean environment for our residents.</p>
                    
                    <h2>Scope of Work</h2>
                    <ul>
                        <li>Regular cleaning of pool and surrounding areas</li>
                        <li>Chemical balancing and water quality testing</li>
                        <li>Equipment maintenance and monitoring</li>
                        <li>Repairs as needed</li>
                        <li>Opening and closing the pool for the season</li>
                        <li>Weekly reporting on pool conditions</li>
                    </ul>
                    
                    <h2>Requirements</h2>
                    <ul>
                        <li>Licensed and insured pool maintenance provider</li>
                        <li>Minimum 5 years experience with community pools</li>
                        <li>Certified pool operator on staff</li>
                        <li>Available for emergency service calls</li>
                        <li>References from at least 3 community associations</li>
                    </ul>
                    
                    <h2>Timeline</h2>
                    <ul>
                        <li>RFP Issued: April 2, 2025</li>
                        <li>Questions Due: April 9, 2025</li>
                        <li>Proposals Due: April 16, 2025</li>
                        <li>Vendor Selection: April 23, 2025</li>
                        <li>Contract Start: May 1, 2025</li>
                    </ul>
                    
                    <h2>Submission Requirements</h2>
                    <ul>
                        <li>Company profile and qualifications</li>
                        <li>Detailed service plan</li>
                        <li>Pricing structure (annual contract with monthly payments preferred)</li>
                        <li>References</li>
                        <li>Sample reports and documentation</li>
                        <li>Certificate of insurance</li>
                    </ul>
                    
                    <h2>Selection Criteria</h2>
                    <ul>
                        <li>Experience and qualifications (30%)</li>
                        <li>Service plan and approach (25%)</li>
                        <li>Pricing (25%)</li>
                        <li>References and reputation (20%)</li>
                    </ul>
                </div>
                
                <div class="rfp-attachments">
                    <h2>Attachments</h2>
                    <ul class="attachment-list">
                        <li class="attachment-item">
                            <a href="#" class="attachment-link">
                                <i class="fa fa-file-pdf-o"></i>
                                <span class="attachment-name">Pool_Specifications.pdf</span>
                                <span class="attachment-size">(1.2 MB)</span>
                            </a>
                        </li>
                        <li class="attachment-item">
                            <a href="#" class="attachment-link">
                                <i class="fa fa-file-image-o"></i>
                                <span class="attachment-name">Pool_Photos.zip</span>
                                <span class="attachment-size">(3.5 MB)</span>
                            </a>
                        </li>
                        <li class="attachment-item">
                            <a href="#" class="attachment-link">
                                <i class="fa fa-file-word-o"></i>
                                <span class="attachment-name">Service_Contract_Template.docx</span>
                                <span class="attachment-size">(245 KB)</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="rfp-contact">
                    <h2>Contact Information</h2>
                    <p>For questions regarding this RFP, please contact:</p>
                    <div class="contact-details">
                        <div class="contact-name">Sarah Johnson</div>
                        <div class="contact-title">Community Manager, Oakwood Heights</div>
                        <div class="contact-email">sjohnson@oakwoodheightshoa.com</div>
                        <div class="contact-phone">(555) 123-4567</div>
                    </div>
                </div>
                
                <?php if (current_user_can('contributor')): ?>
                <div class="rfp-submit-proposal">
                    <a href="<?php echo esc_url(home_url('/submit-proposal/?rfp_id=123')); ?>" class="btn btn-primary btn-large">Submit Your Proposal</a>
                    <p class="proposal-deadline">Proposals must be submitted by April 16, 2025 at 5:00 PM EST</p>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="rfp-sidebar">
                <div class="sidebar-card">
                    <h3>RFP Summary</h3>
                    <div class="summary-item">
                        <span class="summary-label">Status:</span>
                        <span class="summary-value status-open">Open</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Posted:</span>
                        <span class="summary-value">April 2, 2025</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Deadline:</span>
                        <span class="summary-value">April 16, 2025</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Category:</span>
                        <span class="summary-value">Maintenance</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Community:</span>
                        <span class="summary-value">Oakwood Heights</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Proposals:</span>
                        <span class="summary-value">12 submitted</span>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3>Community Information</h3>
                    <div class="community-info">
                        <div class="community-name">Oakwood Heights</div>
                        <div class="community-location">Atlanta, GA</div>
                        <div class="community-size">124 Units</div>
                        <div class="community-type">Single-family homes</div>
                        <a href="#" class="community-link">View Community Profile</a>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3>Similar RFPs</h3>
                    <div class="similar-rfps">
                        <div class="similar-rfp">
                            <a href="#" class="similar-rfp-title">Pool Equipment Replacement</a>
                            <div class="similar-rfp-meta">
                                <span class="similar-rfp-community">Riverside Gardens</span>
                                <span class="similar-rfp-deadline">Due: Apr 11</span>
                            </div>
                        </div>
                        <div class="similar-rfp">
                            <a href="#" class="similar-rfp-title">Pool Resurfacing Project</a>
                            <div class="similar-rfp-meta">
                                <span class="similar-rfp-community">Maple Ridge Estates</span>
                                <span class="similar-rfp-deadline">Due: Apr 8</span>
                            </div>
                        </div>
                        <div class="similar-rfp">
                            <a href="#" class="similar-rfp-title">Pool Maintenance Services</a>
                            <div class="similar-rfp-meta">
                                <span class="similar-rfp-community">Pinecrest Commons</span>
                                <span class="similar-rfp-deadline">Due: Apr 20</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
