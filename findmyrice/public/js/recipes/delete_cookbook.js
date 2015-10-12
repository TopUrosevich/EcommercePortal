$('document').ready(function(){
	window.deleteCookbook = function(id) {
		$.ajax('/recipes/deleteCookbookAjax/'+id, {
			type: 'GET',
			complete: function(xhr){
				var statusCode = xhr.status;

				if (statusCode == 200) {
					$('#'+id).remove();
				} else if (statusCode == 401) {
					window.location.replace(xhr.getResponseHeader('Redirect'));
				}
			}
		});
	};
});
