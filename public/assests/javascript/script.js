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
      $(".comment-container" + postId).toggle();
  });
});
function loadPosts(offset) {
  $.ajax({
      url: '../app/core/load-more.php',
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
                          <div class="edit-btn-div">
                              <button class="edit-post-btn">Edit Post</button>
                          </div>
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
                              <h1>this is my comment</h1>
                          </div>
                      </div>
                  </div>`;
              $('.posts-container').append(postHTML);
          });
          
          if (posts.length >= 10) {
              $('.button-container').show();
          }
          else{
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
      url: '../app/core/like.php',
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