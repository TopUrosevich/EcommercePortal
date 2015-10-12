$('document').ready(function(){
	var like = $('#like');
	var count = $('#like_count');
	var eventId = count.attr('event-id');

	like.on('click', function(){
		$.ajax('/events/likeAjax', {
			data: {
				id: eventId
			},
			complete: function(xhr){
				var statusCode = xhr.status;

				if (statusCode == 201) {
					count.text(!parseInt(count.text()) ? 1 : parseInt(count.text()) + 1);
				} else if (statusCode == 401) {
					window.location.replace(xhr.getResponseHeader('Redirect'));
				}
			}
		});
	});
});
