<?php
/**
 * Template for RFP Card
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info-card rfp-card">
    <div class="info-card-image">
        <img src="{{image}}" alt="{{title}}">
    </div>
    <div class="info-card-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">
            <h3 class="info-card-title">{{title}}</h3>
            <span class="info-card-badge">{{category}}</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
            <div class="info-card-budget">
                <i class="fas fa-dollar-sign" style="margin-right: 4px;"></i> Budget: {{budget}}
            </div>
            
            <div class="info-card-due-date">
                <i class="fas fa-calendar-alt" style="margin-right: 4px;"></i> Due: {{due_date}}
            </div>
        </div>
        
        <p class="info-card-description">{{description}}</p>
        
        <div class="info-card-meta">
            <span><i class="fas fa-building" style="color: var(--secondary-color);"></i> {{organization}}</span>
            <span><i class="fas fa-map-marker-alt" style="color: var(--secondary-color);"></i> {{location}}</span>
            <span><i class="fas fa-clock" style="color: var(--secondary-color);"></i> Posted: {{posted_date}}</span>
        </div>
        
        <div class="info-card-footer">
            <a href="{{permalink}}" class="btn btn-sm btn-outline">View Details</a>
            <a href="{{permalink}}#submit-proposal" class="btn btn-sm btn-secondary">Submit Proposal</a>
        </div>
    </div>
</div>
