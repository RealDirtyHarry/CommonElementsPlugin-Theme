/**
 * Learning Hub JavaScript
 * 
 * Handles course navigation, progress tracking, and quiz functionality.
 */
(function($) {
    'use strict';
    
    const CE_Learning = {
        init: function() {
            this.initCourseNavigation();
            this.initProgressTracking();
            this.initQuizFunctionality();
        },
        
        initCourseNavigation: function() {
            $('.ce-course-navigation-item').on('click', function(e) {
                e.preventDefault();
                
                const $item = $(this);
                const lessonId = $item.data('lesson-id');
                
                $('.ce-course-navigation-item').removeClass('active');
                $item.addClass('active');
                
                CE_Learning.loadLessonContent(lessonId);
            });
            
            $('.ce-lesson-navigation-button').on('click', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const lessonId = $button.data('lesson-id');
                
                if (lessonId) {
                    CE_Learning.loadLessonContent(lessonId);
                    
                    $('.ce-course-navigation-item').removeClass('active');
                    $('.ce-course-navigation-item[data-lesson-id="' + lessonId + '"]').addClass('active');
                }
            });
        },
        
        loadLessonContent: function(lessonId) {
            const $contentContainer = $('.ce-lesson-content');
            
            $contentContainer.addClass('ce-loading');
            
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_load_lesson',
                    nonce: common_elements_platform.nonce,
                    lesson_id: lessonId
                },
                success: function(response) {
                    if (response.success) {
                        $contentContainer.html(response.data.html);
                        
                        if (history.pushState) {
                            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?lesson=' + lessonId;
                            window.history.pushState({path: newUrl}, '', newUrl);
                        }
                        
                        CE_Learning.markLessonViewed(lessonId);
                    } else {
                        console.error('Failed to load lesson content');
                    }
                    $contentContainer.removeClass('ce-loading');
                },
                error: function() {
                    console.error('AJAX error');
                    $contentContainer.removeClass('ce-loading');
                }
            });
        },
        
        initProgressTracking: function() {
            $(document).on('click', '.ce-mark-complete-button', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const lessonId = $button.data('lesson-id');
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ce_ajax_mark_lesson_complete',
                        nonce: common_elements_platform.nonce,
                        lesson_id: lessonId
                    },
                    success: function(response) {
                        if (response.success) {
                            $button.text('Completed').addClass('ce-completed').prop('disabled', true);
                            
                            $('.ce-course-navigation-item[data-lesson-id="' + lessonId + '"]').addClass('ce-completed');
                            
                            const progress = response.data.progress;
                            $('.ce-course-progress-bar-inner').css('width', progress + '%');
                            $('.ce-course-progress-percentage').text(progress + '%');
                            
                            if (response.data.next_lesson_id) {
                                $('.ce-next-lesson-button').data('lesson-id', response.data.next_lesson_id).show();
                            }
                        }
                    }
                });
            });
        },
        
        markLessonViewed: function(lessonId) {
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_mark_lesson_viewed',
                    nonce: common_elements_platform.nonce,
                    lesson_id: lessonId
                }
            });
        },
        
        initQuizFunctionality: function() {
            $(document).on('submit', '.ce-quiz-form', function(e) {
                e.preventDefault();
                
                const $form = $(this);
                const $submitButton = $form.find('button[type="submit"]');
                const quizId = $form.data('quiz-id');
                
                $submitButton.prop('disabled', true);
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: $form.serialize() + '&action=ce_ajax_submit_quiz&nonce=' + common_elements_platform.nonce,
                    success: function(response) {
                        if (response.success) {
                            $('.ce-quiz-questions').hide();
                            $('.ce-quiz-results').html(response.data.html).show();
                            
                            if (response.data.passed) {
                                const progress = response.data.progress;
                                $('.ce-course-progress-bar-inner').css('width', progress + '%');
                                $('.ce-course-progress-percentage').text(progress + '%');
                                
                                if (response.data.next_lesson_id) {
                                    $('.ce-next-lesson-button').data('lesson-id', response.data.next_lesson_id).show();
                                }
                            }
                        } else {
                            alert('Failed to submit quiz. Please try again.');
                            $submitButton.prop('disabled', false);
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                        $submitButton.prop('disabled', false);
                    }
                });
            });
            
            $(document).on('click', '.ce-retake-quiz-button', function(e) {
                e.preventDefault();
                
                $('.ce-quiz-results').hide();
                $('.ce-quiz-questions').show();
                $('.ce-quiz-form')[0].reset();
                $('.ce-quiz-form button[type="submit"]').prop('disabled', false);
            });
        }
    };
    
    $(document).ready(function() {
        CE_Learning.init();
    });
    
})(jQuery);
