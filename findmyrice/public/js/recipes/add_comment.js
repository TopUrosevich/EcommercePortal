$('document').ready(function(){
	var commentMessage = $('#comment_message');
	var addComment = $('#comment_add');
	var recipeId = addComment.attr('recipe-id');
	var commentsList = $('#comments_list');

	addComment.click(function(){
		var message = commentMessage.val();

		if (message) {
			var response = null;

			$.ajax('/recipes/addCommentAjax', {
				type: 'POST',
				data: {
					recipe_id: recipeId,
					message: message
				},
				success: function(data) {
					response = JSON.parse(data).response;
				},
				complete: function(xhr) {
					var statusCode = xhr.status;

					if (statusCode == 201) {
						commentsList.append(
							'<div class="col-lg-12 col-md-12" remove-comment-id="'+response._id+'">'
							+   '<div class="row">'
							+       '<div class="comment_item">'
							+           '<div class="col-lg-2 col-md-2">'
							+		        '<div class="row">'
							+		    	    '<img src="' + response.profile_image + '">'
							+		        '</div>'
							+	        '</div>'
							+	        '<div class="col-lg-10 col-md-10">'
							+		        '<div class="row">'
							+			        '<div class="comment_head">'
							+				        '<span class="comment_author_name">' + response.name + '</span> '
							+				        '<span class="comment_time">' + response.time + '</span>'
							+			            '<span class="glyphicon glyphicon-remove glyphicon_remove_comment" title="Delete comment"'
							+                               "onclick=\"deleteRecipeComment('" + recipeId + "','" + response._id + "')\"></span>"
							+	                '</div>'
							+                   '<hr>'
							+			        '<div class="comment_message">' + response.message + '</div>'
							+		        '</div>'
							+	        '</div>'
							+       '</div>'
							+   '</div>'
							+'</div>'
						);
						commentMessage.val('');
					} else if (statusCode == 401) {
						window.location.replace(xhr.getResponseHeader('Redirect'));
					}
				}
			});
		}
	});
});