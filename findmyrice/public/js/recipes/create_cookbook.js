$('document').ready(function(){
	var create = $('#cookbook_create');
	var name = $('#cookbook_name');
	var cookbooksList = $('#cookbooks_list');
	var location = create.attr('location'); // recipes ar cookbooks

	function addCookbook(id, name, location) {
		if (location == 'recipes') {
			cookbooksList.prepend(
				'<div class="cookbook_item">'
				+	'<input type="checkbox" id="'+id+'" value="'+id+'"> '
				+	name
				+'</div>'
			);

			var item = $('#'+id).parent();

			item.animate({
				color: '#00aa00'
			}, 500);

			setTimeout(function(){
				item.animate({
					color: '#000000'
				}, 500);
			}, 2000);
		}
	}

	create.attr('disabled', 'disabled');

	name.keyup(function(){
		if (name.val()) {
			create.removeAttr('disabled');
		} else {
			create.attr('disabled', 'disabled');
		}
	});

	create.click(function(){
		var cookbookName = name.val();

		if (cookbookName) {
			var response = null;

			$.ajax('/recipes/createCookbookAjax', {
				type: 'POST',
				data: {
					cookbook_name: cookbookName
				},
				success: function(data){
					response = (JSON.parse(data)).response;
				},
				complete: function(xhr) {
					var statusCode = xhr.status;

					if (statusCode == 201) {
						addCookbook(response._id, response.name, 'recipes');
					} else if (statusCode == 401) {
						window.location.replace(xhr.getResponseHeader('Redirect'));
					}
				}
			});
		}
	});
});