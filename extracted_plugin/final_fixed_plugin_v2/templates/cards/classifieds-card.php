<?php
/**
 * Template for Classifieds Card
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info-card classified-card">
    <div class="info-card-image">
        <img src="{{image}}" alt="{{title}}">
        <span class="info-card-badge info-card-category">{{category}}</span>
    </div>
    <div class="info-card-content">
        <h3 class="info-card-title">{{title}}</h3>
        
        <div class="info-card-price">
            <i class="fas fa-tag" style="margin-right: 4px;"></i> {{price}}
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
            <div style="font-weight: 600;">
                <i class="fas fa-map-marker-alt" style="margin-right: 4px; color: var(--secondary-color);"></i> {{location}}
            </div>
            
            <div>
                <i class="fas fa-clock" style="margin-right: 4px; color: var(--secondary-color);"></i> {{date}}
            </div>
        </div>
        
        <p class="info-card-description">{{description}}</p>
        
        <div class="info-card-meta">
            <span><i class="fas fa-box"></i> {{condition}}</span>
            <span><i class="fas fa-user"></i> {{contact}}</span>
            <span><i class="fas fa-calendar-alt"></i> {{expiry}}</span>
        </div>
        
        <div class="info-card-footer">
            <a href="{{permalink}}" class="btn btn-sm btn-outline">View Details</a>
            <a href="tel:{{phone}}" class="btn btn-sm btn-secondary">Call Now</a>
        </div>
    </div>
</div>
