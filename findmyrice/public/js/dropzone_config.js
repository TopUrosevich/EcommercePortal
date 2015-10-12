$(document).ready(function(){
	Dropzone.autoDiscover = false;
	$("#images_dropzone").dropzone({
		addRemoveLinks: true,
		init: function(){
			this.on("success", function(file, response){
				if (response) {
					console.log(response);
					response = JSON.parse(response);
					$(file.previewTemplate).append(
						"<a class='dz-remove' target='_blank' href='"+response.image.url+"'>URL</a>");
				}
			});
		}
	});
});