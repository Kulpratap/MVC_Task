$(document).ready(function () {
    loadPosts(0); // Load initial 10 posts on page load
  
    $('#load-more-btn').on('click', function () {
        var displayedPosts = $('.posts-container .post').length;
        loadPosts(displayedPosts); // Load more posts on button click
    });

    $(document).on("click", "[id^='like-btn']", function (event) {
        event.preventDefault();
        var postId = $(this).attr('id').replace('like-btn', '');
        likePost(postId);
    });

    $('.posts-container').on("click", "[id^='comment-btn']", function (event) {
        event.preventDefault();
        var postId = $(this).attr('id').replace('comment-btn', '');
        var commentContainer = $(".comment-container" + postId);
        if (!commentContainer.hasClass("loaded")) {
            loadComments(postId);
            commentContainer.addClass("loaded");
        }
        commentContainer.toggle();
    });

    $('.posts-container').on("click", ".share-icon", function (event) {
        event.preventDefault();
        var postId = $(this).closest('.reactions').find("[id^='comment-btn']").attr('id').replace('comment-btn', '');
        var commentText = $(this).closest('.reactions').find(".comment-container" + postId + " .comment-text").val();
        if(commentText==''){
            return;
        }
        insertComment(postId, commentText);
    });

});

function loadPosts(offset) {
    $.ajax({
        url: '../app/models/load-more.php',
        method: 'GET',
        data: { offset: offset },
        success: function (response) {
            var posts = JSON.parse(response);
            if (posts.error) {
                console.error(posts.error);
                return;
            }
            posts.forEach(function (post) {
                var postHTML = `
                    <div class="post">
                        <div class="img-div">
                            <div class="image-container">
                                <img class="profile-image" src="${post.profile_img}" alt="profile-img">
                            </div>
                            <p class="post_head">${post.user_name}</p>
                        </div>
                        <div class="post_content">
                            <img class="post-image" src="${post.image_path}" alt="Post Image">
                            <p class="user_name">
                                <span class="user_name">${post.user_name}</span>
                                <span class="content">${post.content}</span>
                            </p>
                        </div>
                        <div class="reactions">
                            <a href='#' id="like-btn${post.post_id}">
                                <i class="fa-regular fa-thumbs-up" id="like-button-i${post.post_id}"></i>
                            </a>
                            <span class="like-count-container">
                                <span class="like-count">${post.like_count}</span> Likes
                            </span>
                            <a href='#' id="comment-btn${post.post_id}">
                                <i class="fa-regular fa-comment"></i>
                            </a>
                            <div class="comment-container${post.post_id} commentbox">
                                <input type="text" class="comment-text" placeholder="Add a comment..." required>
                                <i class="fa-solid fa-arrow-up-from-bracket share-icon"></i>
                                <p class="bold">Comments</p>
                                <div class="comments-all${post.post_id} all-comments-div">
                                </div>
                            </div>
                        </div>
                    </div>`;
                $('.posts-container').append(postHTML);
            });

            if (posts.length >= 10) {
                $('.button-container').show();
            } else {
                $('.button-container').hide();
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function likePost(postId) {
    $.ajax({
        url: '../app/models/like.php',
        type: 'POST',
        data: { post_id: postId },
        dataType: 'json',
        success: function (response) {
            if (response && response.likes !== undefined) {
                var likeCount = response.likes;
                var isLiked = response.like_status;
                $('#like-btn' + postId).siblings('.like-count-container').find('.like-count').text(likeCount);
                var likeButton = $('#like-button-i' + postId);

                if (isLiked) {
                    likeButton.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    likeButton.removeClass('fa-solid').addClass('fa-regular');
                }
            } else {
                console.error('Invalid response format:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function insertComment(postId, commentText) {
    $.ajax({
        url: '../app/models/insert-comment.php',
        method: 'POST',
        data: { postId: postId, commentText: commentText },
        success: function (response) {
            // On successful insertion, call the function to load all comments for the post
            loadComments(postId);
            $(".comment-container" + postId + " .comment-text").val(''); // Clear the input field
            console.log("Inserted Successfully");
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function loadComments(postId) {
    $.ajax({
        url: '../app/models/load-comments.php',
        method: 'GET',
        data: { postId: postId },
        success: function (response) {
            var comments = JSON.parse(response);
            var commentContainer = $(".comments-all" + postId);
            commentContainer.empty(); // Clear existing comments
            comments.forEach(function (comment) {
                commentContainer.prepend(`<div class="comment"><p class="commentor">${comment.commenter_name}<p><p>${comment.comment_content}<p></div>`);
            });
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}
