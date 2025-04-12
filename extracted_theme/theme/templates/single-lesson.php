<?php
/**
 * Template Name: Single Lesson
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="single-lesson-container">
    <div class="lesson-header">
        <div class="container">
            <div class="lesson-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/learning-hub/')); ?>">Learning Hub</a> &raquo; 
                <a href="<?php echo esc_url(home_url('/learning-hub/board-member-essentials/')); ?>">Board Member Essentials</a> &raquo; 
                <span class="current">Welcome and Course Overview</span>
            </div>
            
            <div class="lesson-progress-container">
                <div class="lesson-progress">
                    <div class="progress-text">Lesson 1 of 8</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 12.5%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lesson-content">
        <div class="container">
            <div class="lesson-main">
                <div class="lesson-title-container">
                    <h1 class="lesson-title">Welcome and Course Overview</h1>
                    <div class="lesson-meta">
                        <span class="lesson-type"><i class="fa fa-play-circle"></i> Video</span>
                        <span class="lesson-duration"><i class="fa fa-clock-o"></i> 10 minutes</span>
                    </div>
                </div>
                
                <div class="lesson-video-container">
                    <div class="lesson-video">
                        <div class="video-placeholder">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/video-placeholder.jpg" alt="Video Placeholder">
                            <div class="video-play-button">
                                <i class="fa fa-play"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lesson-tabs">
                    <ul class="tabs-nav">
                        <li class="active"><a href="#content">Lesson Content</a></li>
                        <li><a href="#resources">Resources</a></li>
                        <li><a href="#discussion">Discussion</a></li>
                        <li><a href="#notes">My Notes</a></li>
                    </ul>
                    
                    <div class="tabs-content">
                        <div id="content" class="tab-pane active">
                            <div class="lesson-text">
                                <h2>Welcome to Board Member Essentials</h2>
                                <p>Welcome to Board Member Essentials! I'm Jennifer Wilson, your instructor for this course. As a community association professional with over 20 years of experience, I've worked with hundreds of board members and have seen firsthand the challenges and rewards of board service.</p>
                                
                                <p>This introductory lesson will provide an overview of what you can expect from this course and how to get the most out of your learning experience.</p>
                                
                                <h3>Course Objectives</h3>
                                <p>By the end of this course, you will be able to:</p>
                                <ul>
                                    <li>Understand the legal responsibilities and fiduciary duties of board members</li>
                                    <li>Interpret and apply governing documents effectively</li>
                                    <li>Conduct productive board meetings using proper parliamentary procedure</li>
                                    <li>Provide effective financial oversight for your association</li>
                                    <li>Work collaboratively with management companies and vendors</li>
                                    <li>Communicate effectively with residents and handle conflicts</li>
                                    <li>Implement risk management strategies to protect your association</li>
                                </ul>
                                
                                <h3>Course Structure</h3>
                                <p>This course is divided into four main sections:</p>
                                <ol>
                                    <li><strong>Introduction to Board Service</strong> - Understanding the role and responsibilities of the board</li>
                                    <li><strong>Legal Responsibilities</strong> - Fiduciary duties and governing documents</li>
                                    <li><strong>Effective Governance</strong> - Meeting management and decision-making</li>
                                    <li><strong>Practical Skills</strong> - Financial oversight and communication strategies</li>
                                </ol>
                                
                                <p>Each section contains video lessons, downloadable resources, and knowledge check quizzes. After completing all sections, you'll take a comprehensive assessment to earn your certificate of completion.</p>
                                
                                <h3>How to Use This Course</h3>
                                <p>Here are some tips to help you get the most out of this course:</p>
                                <ul>
                                    <li>Complete the lessons in order, as each one builds on previous content</li>
                                    <li>Download and review the resources provided with each lesson</li>
                                    <li>Participate in the discussion forums to share experiences and ask questions</li>
                                    <li>Take notes as you go through the material</li>
                                    <li>Apply what you learn to your own board service</li>
                                </ul>
                                
                                <p>Remember, you can revisit any lesson at any time, and you have lifetime access to all course materials.</p>
                                
                                <h3>About Your Instructor</h3>
                                <p>As mentioned, I'm Jennifer Wilson, and I've been involved in community association management and governance for over two decades. I've served as a board member myself, worked as a community manager, and now I train and consult with associations across the country.</p>
                                
                                <p>I hold the CMCA, AMS, and PCAM designations from the Community Associations Institute (CAI) and am passionate about helping board members develop the skills they need to serve their communities effectively.</p>
                                
                                <p>Throughout this course, I'll be sharing real-world examples and practical tips based on my experience. I'm excited to be your guide on this journey!</p>
                                
                                <h3>Let's Get Started!</h3>
                                <p>Now that you know what to expect, let's dive into the course material. In the next lesson, we'll explore the role of the board in community associations and the different responsibilities board members have.</p>
                                
                                <p>If you have any questions along the way, please don't hesitate to post them in the discussion forum. I check in regularly and am here to help you succeed.</p>
                                
                                <p>Thank you for enrolling in Board Member Essentials. I look forward to helping you become a more effective and confident board member!</p>
                            </div>
                            
                            <div class="lesson-complete-container">
                                <div class="lesson-complete-checkbox">
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="lesson-complete">
                                        <span class="checkmark"></span>
                                        Mark as complete
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div id="resources" class="tab-pane">
                            <h2>Lesson Resources</h2>
                            <div class="resources-list">
                                <div class="resource-item">
                                    <div class="resource-icon"><i class="fa fa-file-pdf-o"></i></div>
                                    <div class="resource-details">
                                        <h3 class="resource-title">Course Syllabus</h3>
                                        <div class="resource-description">
                                            <p>Complete course outline with learning objectives for each lesson.</p>
                                        </div>
                                    </div>
                                    <div class="resource-actions">
                                        <a href="#" class="btn btn-sm btn-outline"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                                
                                <div class="resource-item">
                                    <div class="resource-icon"><i class="fa fa-file-powerpoint-o"></i></div>
                                    <div class="resource-details">
                                        <h3 class="resource-title">Lesson Slides</h3>
                                        <div class="resource-description">
                                            <p>Presentation slides from the welcome video.</p>
                                        </div>
                                    </div>
                                    <div class="resource-actions">
                                        <a href="#" class="btn btn-sm btn-outline"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                                
                                <div class="resource-item">
                                    <div class="resource-icon"><i class="fa fa-file-word-o"></i></div>
                                    <div class="resource-details">
                                        <h3 class="resource-title">Board Member Handbook Template</h3>
                                        <div class="resource-description">
                                            <p>Customizable template for creating a handbook for your association's board members.</p>
                                        </div>
                                    </div>
                                    <div class="resource-actions">
                                        <a href="#" class="btn btn-sm btn-outline"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                                
                                <div class="resource-item">
                                    <div class="resource-icon"><i class="fa fa-file-excel-o"></i></div>
                                    <div class="resource-details">
                                        <h3 class="resource-title">Board Member Skills Assessment</h3>
                                        <div class="resource-description">
                                            <p>Self-assessment tool to identify your strengths and areas for growth as a board member.</p>
                                        </div>
                                    </div>
                                    <div class="resource-actions">
                                        <a href="#" class="btn btn-sm btn-outline"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="discussion" class="tab-pane">
                            <div class="discussion-container">
                                <h2>Lesson Discussion</h2>
                                
                                <div class="discussion-form">
                                    <h3>Join the Conversation</h3>
                                    <form>
                                        <div class="form-field">
                                            <textarea placeholder="Share your thoughts or ask a question about this lesson..." rows="4"></textarea>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Post Comment</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="discussion-list">
                                    <div class="discussion-item">
                                        <div class="discussion-avatar">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                                        </div>
                                        <div class="discussion-content">
                                            <div class="discussion-header">
                                                <div class="discussion-author">Sarah Johnson</div>
                                                <div class="discussion-meta">
                                                    <span class="discussion-date">2 days ago</span>
                                                </div>
                                            </div>
                                            <div class="discussion-text">
                                                <p>I'm excited to start this course! As a new board member, I'm feeling a bit overwhelmed with all the responsibilities. I'm hoping this course will help me get up to speed quickly.</p>
                                            </div>
                                            <div class="discussion-actions">
                                                <a href="#" class="discussion-reply-link">Reply</a>
                                            </div>
                                            
                                            <div class="discussion-replies">
                                                <div class="discussion-item reply">
                                                    <div class="discussion-avatar">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instructor-placeholder.jpg" alt="Instructor Avatar">
                                                    </div>
                                                    <div class="discussion-content">
                                                        <div class="discussion-header">
                                                            <div class="discussion-author">Jennifer Wilson <span class="badge badge-instructor">Instructor</span></div>
                                                            <div class="discussion-meta">
                                                                <span class="discussion-date">1 day ago</span>
                                                            </div>
                                                        </div>
                                                        <div class="discussion-text">
                                                            <p>Welcome, Sarah! It's completely normal to feel overwhelmed at first. The good news is that board service is a skill that can be learned, and this course will give you a solid foundation. Don't hesitate to ask questions along the way!</p>
                                                        </div>
                                                        <div class="discussion-actions">
                                                            <a href="#" class="discussion-reply-link">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="discussion-item reply">
                                                    <div class="discussion-avatar">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                                                    </div>
                                                    <div class="discussion-content">
                                                        <div class="discussion-header">
                                                            <div class="discussion-author">Robert Chen</div>
                                                            <div class="discussion-meta">
                                                                <span class="discussion-date">12 hours ago</span>
                                                            </div>
                                                        </div>
                                                        <div class="discussion-text">
                                                            <p>I felt the same way when I started, Sarah! I've been on my board for about a year now, and it definitely gets easier with time and education. This course has already helped me fill in some knowledge gaps.</p>
                                                        </div>
                                                        <div class="discussion-actions">
                                                            <a href="#" class="discussion-reply-link">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="discussion-item">
                                        <div class="discussion-avatar">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/avatar-placeholder.png" alt="User Avatar">
                                        </div>
                                        <div class="discussion-content">
                                            <div class="discussion-header">
                                                <div class="discussion-author">Michael Brown</div>
                                                <div class="discussion-meta">
                                                    <span class="discussion-date">3 days ago</span>
                                                </div>
                                            </div>
                                            <div class="discussion-text">
                                                <p>Question for Jennifer: Our board is struggling with member participation. We have trouble getting people to volunteer for committees or even attend meetings. Will this course cover strategies for increasing community engagement?</p>
                                            </div>
                                            <div class="discussion-actions">
                                                <a href="#" class="discussion-reply-link">Reply</a>
                                            </div>
                                            
                                            <div class="discussion-replies">
                                                <div class="discussion-item reply">
                                                    <div class="discussion-avatar">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instructor-placeholder.jpg" alt="Instructor Avatar">
                                                    </div>
                                                    <div class="discussion-content">
                                                        <div class="discussion-header">
                                                            <div class="discussion-author">Jennifer Wilson <span class="badge badge-instructor">Instructor</span></div>
                                                            <div class="discussion-meta">
                                                                <span class="discussion-date">2 days ago</span>
                                                            </div>
                                                        </div>
                                                        <div class="discussion-text">
                                                            <p>Great question, Michael! We'll touch on community engagement strategies in Lesson 7 (Communication and Conflict Resolution). However, for a deeper dive into this topic, you might also be interested in my course "Community Engagement Strategies for Associations" which focuses specifically on increasing participation and building community spirit.</p>
                                                        </div>
                                                        <div class="discussion-actions">
                                                            <a href="#" class="discussion-reply-link">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="discussion-pagination">
                                    <a href="#" class="pagination-prev disabled">&laquo; Previous</a>
                                    <span class="pagination-current">Page 1 of 3</span>
                                    <a href="#" class="pagination-next">Next &raquo;</a>
                                </div>
                            </div>
                        </div>
                        
                        <div id="notes" class="tab-pane">
                            <div class="notes-container">
                                <h2>My Notes</h2>
                                <div class="notes-editor">
                                    <textarea id="lesson-notes" placeholder="Take notes on this lesson here..." rows="10"></textarea>
                                    <div class="notes-actions">
                                        <button id="save-notes" class="btn btn-primary">Save Notes</button>
                                    </div>
                                </div>
                                <div class="notes-tips">
                                    <h3>Note-Taking Tips</h3>
                                    <ul>
                                        <li>Focus on key concepts and ideas that are new to you</li>
                                        <li>Write down questions you have about the material</li>
                                        <li>Note how you might apply these concepts in your association</li>
                                        <li>Your notes are private and only visible to you</li>
                                        <li>Notes are automatically saved as you type</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lesson-sidebar">
                <div class="sidebar-card course-navigation">
                    <h3>Course Navigation</h3>
                    <div class="course-progress-container">
                        <div class="course-progress">
                            <div class="progress-text">12.5% Complete</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 12.5%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lesson-navigation">
                        <div class="lesson-list">
                            <div class="section-header">
                                <h4>Section 1: Introduction to Board Service</h4>
                            </div>
                            <div class="lesson-item current">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-circle-o"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Welcome and Course Overview</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">10 min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">The Role of the Board in Community Associations</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">20 min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="section-header">
                                <h4>Section 2: Legal Responsibilities</h4>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Fiduciary Duties of Board Members</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">15 min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Understanding Governing Documents</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">20 min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="section-header">
                                <h4>Section 3: Effective Governance</h4>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Meeting Management and Parliamentary Procedure</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">15 min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Decision-Making and Policy Development</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">15 min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="section-header">
                                <h4>Section 4: Practical Skills</h4>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Financial Oversight and Budgeting</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">15 min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Communication and Conflict Resolution</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">10 min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="section-header">
                                <h4>Final Assessment</h4>
                            </div>
                            <div class="lesson-item locked">
                                <div class="lesson-status">
                                    <span class="status-icon"><i class="fa fa-lock"></i></span>
                                </div>
                                <div class="lesson-details">
                                    <a href="#" class="lesson-title">Comprehensive Assessment</a>
                                    <div class="lesson-meta">
                                        <span class="lesson-duration">20 min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card lesson-actions">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-outline btn-block disabled"><i class="fa fa-arrow-left"></i> Previous Lesson</a>
                        <a href="#" class="btn btn-primary btn-block">Next Lesson <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="sidebar-card course-info">
                    <h3>About This Course</h3>
                    <div class="course-details">
                        <h4><a href="<?php echo esc_url(home_url('/learning-hub/board-member-essentials/')); ?>">Board Member Essentials</a></h4>
                        <div class="course-meta">
                            <div class="course-category">Board Governance</div>
                            <div class="course-stats">
                                <span class="course-lessons"><i class="fa fa-list"></i> 8 lessons</span>
                                <span class="course-duration"><i class="fa fa-clock-o"></i> 2 hours</span>
                            </div>
                        </div>
                        <div class="course-instructor">
                            <div class="instructor-avatar">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instructor-placeholder.jpg" alt="Instructor Avatar">
                            </div>
                            <div class="instructor-name">Jennifer Wilson</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// PHP 8.4 compatible JavaScript for tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabLinks = document.querySelectorAll('.tabs-nav a');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            tabLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
            });
            
            // Hide all tab panes
            tabPanes.forEach(function(pane) {
                pane.classList.remove('active');
            });
            
            // Add active class to clicked tab
            this.parentElement.classList.add('active');
            
            // Show corresponding tab pane
            const targetId = this.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('active');
        });
    });
    
    // Video placeholder click to simulate video play
    const videoPlaceholder = document.querySelector('.video-placeholder');
    if (videoPlaceholder) {
        videoPlaceholder.addEventListener('click', function() {
            this.innerHTML = '<div class="video-message">Video would play here in production environment</div>';
            this.classList.add('video-playing');
        });
    }
    
    // Mark lesson as complete functionality
    const lessonCompleteCheckbox = document.getElementById('lesson-complete');
    if (lessonCompleteCheckbox) {
        lessonCompleteCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // In production, this would update the database
                const statusIcon = document.querySelector('.lesson-item.current .status-icon i');
                if (statusIcon) {
                    statusIcon.classList.remove('fa-circle-o');
                    statusIcon.classList.add('fa-check-circle');
                }
                
                // Enable next lesson button
                const nextLessonBtn = document.querySelector('.lesson-actions .btn-primary');
                if (nextLessonBtn) {
                    nextLessonBtn.classList.remove('disabled');
                }
                
                // Show completion message
                const completeContainer = document.querySelector('.lesson-complete-container');
                if (completeContainer) {
                    completeContainer.innerHTML = '<div class="lesson-complete-message">Lesson marked as complete! You can now proceed to the next lesson.</div>';
                }
            }
        });
    }
    
    // Notes autosave simulation
    const lessonNotes = document.getElementById('lesson-notes');
    const saveNotesBtn = document.getElementById('save-notes');
    
    if (lessonNotes && saveNotesBtn) {
        saveNotesBtn.addEventListener('click', function() {
            // In production, this would save to the database
            this.innerHTML = 'Notes Saved!';
            setTimeout(() => {
                this.innerHTML = 'Save Notes';
            }, 2000);
        });
        
        // Simulate autosave
        let typingTimer;
        lessonNotes.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                // In production, this would autosave to the database
                const saveStatus = document.createElement('div');
                saveStatus.className = 'notes-save-status';
                saveStatus.textContent = 'Autosaved';
                
                const existingStatus = document.querySelector('.notes-save-status');
                if (existingStatus) {
                    existingStatus.remove();
                }
                
                document.querySelector('.notes-actions').appendChild(saveStatus);
                
                setTimeout(() => {
                    saveStatus.remove();
                }, 2000);
            }, 1000);
        });
    }
});
</script>

<?php
get_footer();
