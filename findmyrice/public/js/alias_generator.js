$('document').ready(function(){
	var titleField = $("input#title.form-control");
	var aliasField = $("input#alias.form-control");

	titleField.on('keyup', function(){
        var re1 = new RegExp(" ","g");
        var re2 = new RegExp("&","g");
		aliasField.val(titleField.val().toLowerCase().replace(
                re1, "-").replace(re2, "")
        );
	});

	var eventNameField = $("input#event_name.form-control");

	eventNameField.on('keyup', function(){
        var re1 = new RegExp(" ","g");
        var re2 = new RegExp("&","g");
        aliasField.val(eventNameField.val().toLowerCase().replace(
                re1, "-").replace(re2, "")
        );
	});
});