$('document').ready(function(){
	var add = $('#add_to_cookbook');
	var recipeId = add.attr('recipe-id');
	var cookbooksList = $('#cookbooks_list');

	$('#cookbook_add_success').hide();

	add.click(function(){
		var ids = cookbooksList.find('input:checkbox:checked').map(function(){
			return this.value;
		}).get();

		if (ids.length > 0) {
			$.ajax('/recipes/addToCookbookAjax', {
				type: 'POST',
				data: {
					recipe_id: recipeId,
					cookbooks: ids
				},
				complete: function(xhr) {
					var statusCode = xhr.status;

					if (statusCode == 201) {
						$('#cookbook_add_success').show();
						setTimeout(function(){
							$('#addToCookbookModal').modal('toggle');
						}, 3000);
					} else if (statusCode == 401) {
						window.location.replace(xhr.getResponseHeader('Redirect'));
					}
				}
			});
		}
	});
});
