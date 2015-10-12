$('document').ready(function(){
	window.deleteRecipeComment = function(recipeId, commentId){
		$.ajax('/recipes/deleteCommentAjax', {
			type: 'GET',
			data: {
				comment_id: commentId,
				recipe_id: recipeId
			},
			complete: function(xhr){
				var statusCode = xhr.status;

				if (statusCode == 200) {
					$('div[remove-comment-id='+commentId+']').remove();
				} else if (statusCode == 401) {
					window.location.replace(xhr.getResponseHeader('Redirect'));
				}
			}
		});
	};
});