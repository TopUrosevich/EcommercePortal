$('.image_uploader_origin').bind('click', function(e){
	$('#image_origin').click();
});

$('#image_origin').bind('change', function(event){
	var reader = new FileReader();
	reader.onload = function(e) {
		$('.image_uploader_origin img').attr('src',e.target.result);
	};
	reader.readAsDataURL(event.target.files[0]);
});

$('.image_uploader_preview').bind('click', function(e){
	$('#image_preview').click();
});

$('#image_preview').bind('change', function(event){
	var reader = new FileReader();
	reader.onload = function(e) {
		$('.image_uploader_preview img').attr('src',e.target.result);
	};
	reader.readAsDataURL(event.target.files[0]);
});
