$('document').ready(function(){
	var share = $('#share_cookbook');
	var email = $('#share_email');
	var recipeId = share.attr('cookbook-id');

	var error = $('#cookbook_share_error');
	var success = $('#cookbook_share_success');

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
			$.ajax('/recipes/shareCookbookWithContactAjax', {
				type: 'POST',
				data: {
					cookbook_id: recipeId,
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
