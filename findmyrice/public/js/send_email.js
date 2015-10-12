$('document').ready(function(){
	var email = $('#email_for_sent');
	var message = $('#message_for_sent');
	var subject = $('#subject_for_sent');

	$('#send_email').on('click', function(){
		var link = "mailto:"+email.val()
				+ "&subject=" + subject.val()
				+ "&body=" + message.val();

		window.location.href = link;
	});
});