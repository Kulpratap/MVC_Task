$(document).ready(function () {
  $('.edit-btn').click(function () {
    var menu = $(this).siblings('.post-menu');
    menu.toggle();
  });

  $('.edit-post-btn').click(function () {
    var postId = $(this).data('postid');
    window.location.href = "/public/editpost/" + postId;
  });

  // Click event for delete post button
  $('.delete-post-btn').click(function () {
    var postId = $(this).data('postid');
    console.log('Deleting post with ID:', postId);
  });
// Click event for delete post button
$('.delete-post-btn').click(function() {
    var postId = $(this).data('postid');
    
    $.ajax({
        url: '../app/models/delete_post.php', 
        type: 'POST',
        data: { post_id: postId },
        success: function(response) {
            window.location.href = 'profile';
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
});