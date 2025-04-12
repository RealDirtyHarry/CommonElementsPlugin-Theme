<?php
/**
 * Template for Jobs Card
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info-card job-card">
    <div class="info-card-image">
        <img src="{{image}}" alt="{{title}}">
        <span class="info-card-badge info-card-job-type">{{job_type}}</span>
    </div>
    <div class="info-card-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">
            <h3 class="info-card-title">{{title}}</h3>
            <div class="info-card-company">{{company}}</div>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
            <div class="info-card-salary">
                <i class="fas fa-dollar-sign" style="margin-right: 4px;"></i> {{salary}}
            </div>
            
            <div>
                <i class="fas fa-map-marker-alt" style="margin-right: 4px; color: var(--secondary-color);"></i> {{location}}
            </div>
        </div>
        
        <p class="info-card-description">{{description}}</p>
        
        <div class="info-card-meta">
            <span><i class="fas fa-briefcase" style="color: var(--secondary-color);"></i> {{requirements}}</span>
            <span><i class="fas fa-clock" style="color: var(--secondary-color);"></i> Posted: {{posted_date}}</span>
            <span><i class="fas fa-calendar-times" style="color: var(--secondary-color);"></i> Closes: {{closing_date}}</span>
        </div>
        
        <div class="info-card-footer">
            <a href="{{permalink}}" class="btn btn-sm btn-outline">View Details</a>
            <a href="{{permalink}}#apply" class="btn btn-sm btn-secondary">Apply Now</a>
        </div>
    </div>
</div>
