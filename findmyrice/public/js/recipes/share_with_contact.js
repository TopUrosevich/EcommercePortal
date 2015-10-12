$('document').ready(function(){
	var share = $('#share_recipe');
	var email = $('#share_email');
	var recipeId = share.attr('recipe-id');

	var error = $('#recipe_share_error');
	var success = $('#recipe_share_success');

	success.hide();
	error.hide();

	share.attr('disabled', 'disabled');

	email.keyup(function(){
		success.hide();
		error.hide();

		if (email.val()) {
			share.removeAttr('disabled');
		} else {
			share.attr('disabled', 'disabled');
		}
	});

	share.click(function(){
		var shareEmail = email.val();

		if (shareEmail) {
			$.ajax('/recipes/shareWithContactAjax', {
				type: 'POST',
				data: {
					recipe_id: recipeId,
					email: shareEmail
				},
				complete: function(xhr) {
					var statusCode = xhr.status;

					switch (statusCode) {
						case 201:
							error.hide();
							success.show();
							setTimeout(function(){
								$('#shareWithContactModal').modal('toggle');
							}, 3000);
							break;
						case 401:
							window.location.replace(xhr.getResponseHeader('Redirect'));
							break;
						default:
							error.show();
							success.hide();
					}
				}
			});
		}
	});
});
