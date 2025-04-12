<?php
/**
 * Template for Directory Card
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info-card directory-card">
    <div class="info-card-image">
        <img src="{{image}}" alt="{{title}}">
    </div>
    <div class="info-card-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">
            <h3 class="info-card-title">{{title}}</h3>
            <span class="info-card-badge">{{category}}</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
            <div class="info-card-rating" style="color: var(--secondary-color);">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>{{rating}}</span>
            </div>
            
            <div style="font-weight: 600;">
                <i class="fas fa-map-marker-alt" style="margin-right: 4px; color: var(--secondary-color);"></i> {{location}}
            </div>
        </div>
        
        <p class="info-card-description">{{description}}</p>
        
        <div class="info-card-meta">
            <span><i class="fas fa-phone"></i> {{phone}}</span>
            <span><i class="fas fa-envelope"></i> {{email}}</span>
            <span><i class="fas fa-globe"></i> {{website}}</span>
        </div>
        
        <div class="info-card-footer">
            <a href="{{permalink}}" class="btn btn-sm btn-outline">View Details</a>
            <a href="mailto:{{email}}" class="btn btn-sm btn-secondary">Contact</a>
        </div>
    </div>
</div>
