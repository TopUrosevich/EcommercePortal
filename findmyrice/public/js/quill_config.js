var quill;   // Expose as global so people can easily try out the API

$(document).ready(function() {
	quill = new Quill('#editor', {
		modules: {
			'toolbar': { container: '#toolbar' },
			'image-tooltip': true,
			'link-tooltip': true
		},
		theme: 'snow'
	});

	quill.once('selection-change', function(hasFocus) {
		var editor = $('#editor');
		editor.toggleClass('focus', hasFocus);
		// Hack for inability to scroll on mobile
		if (/mobile/i.test(navigator.userAgent)) {
			editor.css('height', quill.root.scrollHeight + 30);   // 30 for padding
		}
	});

	quill.on('text-change', function(delta, source){
		$('#content').val(quill.getHTML());
	});

	if ($('#content').val()) {
		quill.setHTML($('#content').val());
	}
});

