$('document').ready(function(){
	var organiserName = $('#organiser_name');
	var contactName = $('#contact_name');
	var email = $('#email');
	var streetAddress = $('#street_address');
	var city = $('#city');
	var country = $('#country');
	var zipCode = $('#zip_code');
	var countryCode = $('#country_code');
	var areaCode = $('#area_code');
	var phone = $('#phone');

	organiserName.on('keyup', function(){
		$('#preview_organiser_name').text(organiserName.val());
	});
	contactName.on('keyup', function(){
		$('#preview_contact_name').text(contactName.val());
	});
	email.on('keyup', function(){
		$('#preview_email').text(email.val());
	});
	streetAddress.on('keyup', function(){
		$('#preview_street_address').text(streetAddress.val());
	});
	city.on('keyup', function(){
		$('#preview_city').text(city.val());
	});
	country.on('keyup', function(){
		$('#preview_country').text(country.val());
	});
	zipCode.on('keyup', function(){
		$('#preview_zip_code').text(zipCode.val());
	});
	areaCode.on('keyup', function(){
		$('#preview_area_code').text(areaCode.val());
	});
	countryCode.on('keyup', function(){
		$('#preview_country_code').text(countryCode.val());
	});
	phone.on('keyup', function(){
		$('#preview_phone').text(phone.val());
	});
});