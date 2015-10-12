$('document').ready(function(){
	var eventName = $('#event_name');
	var venue = $('#venue');
	var organiser = $('#organiser_id');
	var category = $('#category_id');
	var startDate = $('#start_date');
	var endDate = $('#end_date');
	var enquiryEmail = $('#enquiry_email');
	var website = $('#website');
	var image = $('#image_origin');

	image.on('change', function(){
		setTimeout(function(){
			console.log($('.image_uploader_origin img').attr('src'));
			$('#preview_image img').attr('src', $('.image_uploader_origin img').attr('src'));
		}, 1000);
	});
	eventName.on('keyup', function(){
		$('#preview_event_name').text(eventName.val());
	});
	venue.on('keyup', function(){
		$('#preview_venue').text(venue.val());
	});
	organiser.on('change', function(){
		$('#preview_organiser').text(
			$('#organiser_id option[value='+organiser.val()+']').attr('selected', true).text());
	});
	category.on('change', function(){
		$('#preview_category').text(
			$('#category_id option[value='+category.val()+']').attr('selected', true).text());
	});
	startDate.on('change', function(){
		$('#preview_start_date').text(startDate.val());
	});
	endDate.on('change', function(){
		$('#preview_end_date').text(endDate.val());
	});
	enquiryEmail.on('keyup', function(){
		$('#preview_enquiry_email').text(enquiryEmail.val());
	});
	website.on('keyup', function(){
		$('#preview_website').text(website.val());
	});
});
