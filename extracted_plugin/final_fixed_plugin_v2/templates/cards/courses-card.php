<?php
/**
 * Template for Courses Card
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info-card course-card">
    <div class="info-card-image">
        <img src="{{image}}" alt="{{title}}">
    </div>
    <div class="info-card-content">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">
            <h3 class="info-card-title">{{title}}</h3>
            <span class="info-card-badge">{{category}}</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
            <div class="info-card-instructor">
                <i class="fas fa-user-tie" style="margin-right: 4px; color: var(--secondary-color);"></i> {{instructor}}
            </div>
            
            <div class="info-card-price">
                <i class="fas fa-tag" style="margin-right: 4px;"></i> {{price}}
            </div>
        </div>
        
        <p class="info-card-description">{{description}}</p>
        
        <div class="info-card-meta">
            <span class="info-card-duration"><i class="fas fa-clock"></i> {{duration}}</span>
            <span class="info-card-lessons"><i class="fas fa-book"></i> {{lessons}} Lessons</span>
            <span><i class="fas fa-signal" style="color: var(--secondary-color);"></i> {{level}}</span>
            <span><i class="fas fa-calendar-alt" style="color: var(--secondary-color);"></i> Starts: {{start_date}}</span>
        </div>
        
        <div class="info-card-footer">
            <a href="{{permalink}}" class="btn btn-sm btn-outline">View Course</a>
            <a href="{{permalink}}#enroll" class="btn btn-sm btn-secondary">Enroll Now</a>
        </div>
    </div>
</div>
