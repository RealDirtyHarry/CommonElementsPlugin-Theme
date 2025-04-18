/**
 * Forum System JavaScript
 * 
 * Handles forum topics, replies, and user interactions.
 */
(function($) {
    'use strict';
    
    const CE_Forum = {
        init: function() {
            this.initReplyForms();
            this.initTopicActions();
            this.initForumSearch();
        },
        
        initReplyForms: function() {
            $(document).on('click', '.ce-forum-reply-button', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const $replyForm = $('#ce-forum-reply-form-container');
                
                if ($button.hasClass('ce-forum-reply-to-topic')) {
                    $replyForm.appendTo('.ce-forum-topic-replies');
                    $replyForm.find('input[name="parent_id"]').val(0);
                } else {
                    const $parent = $button.closest('.ce-forum-reply');
                    const parentId = $parent.data('reply-id');
                    
                    $replyForm.appendTo($parent.find('.ce-forum-nested-replies'));
                    $replyForm.find('input[name="parent_id"]').val(parentId);
                }
                
                $replyForm.show();
                $replyForm.find('textarea').focus();
            });
            
            $(document).on('submit', '#ce-forum-reply-form', function(e) {
                e.preventDefault();
                
                const $form = $(this);
                const $submitButton = $form.find('button[type="submit"]');
                
                if ($form.find('textarea').val().trim() === '') {
                    $form.find('.ce-form-error-message').show();
                    return;
                }
                
                $submitButton.prop('disabled', true);
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: $form.serialize() + '&action=ce_ajax_submit_reply&nonce=' + common_elements_platform.nonce,
                    success: function(response) {
                        if (response.success) {
                            if (response.data.parent_id == 0) {
                                $('.ce-forum-topic-replies').append(response.data.html);
                            } else {
                                $('.ce-forum-reply[data-reply-id="' + response.data.parent_id + '"] .ce-forum-nested-replies').append(response.data.html);
                            }
                            
                            $form[0].reset();
                            $form.closest('#ce-forum-reply-form-container').hide();
                        } else {
                            $form.find('.ce-form-error-message').text(response.data.error).show();
                        }
                        $submitButton.prop('disabled', false);
                    },
                    error: function() {
                        $form.find('.ce-form-error-message').text('An error occurred. Please try again.').show();
                        $submitButton.prop('disabled', false);
                    }
                });
            });
        },
        
        initTopicActions: function() {
            $(document).on('click', '.ce-forum-vote-button', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const direction = $button.hasClass('ce-forum-upvote') ? 'up' : 'down';
                const postId = $button.data('post-id');
                const postType = $button.closest('.ce-forum-topic').length ? 'topic' : 'reply';
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ce_ajax_vote_post',
                        nonce: common_elements_platform.nonce,
                        post_id: postId,
                        direction: direction,
                        post_type: postType
                    },
                    success: function(response) {
                        if (response.success) {
                            $button.siblings('.ce-forum-vote-count').text(response.data.votes);
                            
                            $button.parent().find('.ce-forum-vote-button').removeClass('active');
                            if (response.data.user_vote !== 0) {
                                $button.addClass('active');
                            }
                        }
                    }
                });
            });
            
            $(document).on('click', '.ce-forum-mark-solution', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const replyId = $button.data('reply-id');
                const topicId = $button.data('topic-id');
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ce_ajax_mark_solution',
                        nonce: common_elements_platform.nonce,
                        reply_id: replyId,
                        topic_id: topicId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.ce-forum-reply').removeClass('ce-forum-solution');
                            $('.ce-forum-solution-badge').remove();
                            
                            $('.ce-forum-reply[data-reply-id="' + replyId + '"]').addClass('ce-forum-solution').prepend('<div class="ce-forum-solution-badge"><i class="fas fa-check-circle"></i> Solution</div>');
                        }
                    }
                });
            });
        },
        
        initForumSearch: function() {
            $('#ce-forum-search-form').on('submit', function(e) {
                e.preventDefault();
                
                const $form = $(this);
                const searchTerm = $form.find('input[name="search"]').val();
                const boardId = $form.find('select[name="board_id"]').val();
                
                window.location.href = common_elements_platform.site_url + '/forums/?search=' + encodeURIComponent(searchTerm) + '&board_id=' + boardId;
            });
        }
    };
    
    $(document).ready(function() {
        CE_Forum.init();
    });
    
})(jQuery);
