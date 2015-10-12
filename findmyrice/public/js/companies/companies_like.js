(function($) {
	var like = $('#like');
	like.on('click', function(event){
        event.preventDefault();
        var count = $('#company-id');
        var count = $('#like_count');
        var companyId = count.attr('company-id');
        $.ajax({
            url: '/ajax/likeCompany',
            type: 'POST',
            data: {company_id: companyId}
        }).complete(function(xhr, textStatus){
            var statusCode = xhr.status;

            if (statusCode == 201) {
                count.text(!parseInt(count.text()) ? 1 : parseInt(count.text()) + 1);
            } else if (statusCode == 401) {
                window.location.replace(xhr.getResponseHeader('Redirect'));
            }
        });
	});
})(jQuery);
