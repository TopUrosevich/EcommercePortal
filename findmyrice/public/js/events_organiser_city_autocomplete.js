$('document').ready(function(){
	var cityAutocomplete = $('#cityAutocomplete');
	var country = $("#country");
	var state = $('#state');
	var city = $('#city');

	cityAutocomplete.jeoCityAutoComplete({callback: function(response){
		country.val(response.countryName);
		country.removeAttr('disabled');
		country.trigger('keyup');

		state.val(response.adminName1);
		state.removeAttr('disabled');

		city.val(response.name);
		city.removeAttr('disabled');
		city.trigger('keyup');

		$.ajax('https://restcountries-v1.p.mashape.com/alpha/'+response.countryCode, {
			headers: {
				'X-Mashape-Key': 'BiIjzSksCNmshsh2cafYOnjzfpZLp14PWDFjsnGMB2ZGhvifrc'
			},
			success: function(response) {
				var countryCode = $('#country_code');
				var code = $.map(response.callingCodes, function(c) {
					return '+'+c;
				});
				countryCode.val(code);
				countryCode.removeAttr('disabled');
				countryCode.trigger('keyup');

				var timezone = $('#timezone');
				timezone.val(response.region+'/'+response.capital);
				console.log(response.region+'/'+response.capital);
			}
		});
	}});
});


