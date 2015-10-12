$('.photo_uploader').bind('click', function(e){
	$('#photo').click();
});

$('#photo').bind('change', function(event){
	var reader = new FileReader();
	reader.onload = function(e) {
		$('.photo_uploader img').attr('src',e.target.result);
	};
	reader.readAsDataURL(event.target.files[0]);

});