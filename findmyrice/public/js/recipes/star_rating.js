$('document').ready(function(){
	var starRating = $('#star_rating');
	var recipeId = starRating.attr('recipe-id');
	var ratingAverage = $('#star_rating_average');
	var ratingTotal = $('#star_rating_total');

	starRating.raty({
		path: '/images/raty',
		starOff: 'star-off.png',
		starOn: 'star-on.png',
		cancelOn: 'cancel-on.png',
		cancelOff: 'cancel-off.png',
		starHalf: 'star-half.png',
		round : { down: .26, full: .6, up: .76 },
		click: function(score, evt){
			console.log(score);

			var response = null;

			$.ajax('/recipes/ratingAjax', {
				type: 'POST',
				data: {
					recipe_id: recipeId,
					score: score
				},
				success: function(data) {
					response = JSON.parse(data).response;
				},
				complete: function(xhr){
					var statusCode = xhr.status;

					if (statusCode == 201) {
						ratingAverage.text(response.average);
						ratingTotal.text(response.total);
						starRating.raty('set', {score: response.average});
					} else if (statusCode == 401) {
						window.location.replace(xhr.getResponseHeader('Redirect'));
					}
				}
			});
		}
	});

	$.ajax('/recipes/ratingAjax', {
		type: 'GET',
		data: {
			recipe_id: recipeId
		},
		success: function(data) {
			var response = JSON.parse(data).response;
			ratingAverage.text(response.average);
			ratingTotal.text(response.total);
			starRating.raty('set', {score: response.average});
		}
	});
});