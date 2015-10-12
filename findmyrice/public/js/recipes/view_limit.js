$('document').ready(function(){
	function getUrlParameter(param){
		var pageURL = window.location.search.substring(1);
		var urlVariables = pageURL.split('&');
		for (var i = 0; i < urlVariables.length; i++)
		{
			var parameterName = urlVariables[i].split('=');
			if (parameterName[0] == param)
			{
				return parameterName[1];
			}
		}
	}

	var limit = $('#view_limit');
	var param = getUrlParameter('limit');

	limit.val(param ? param : 10);

	limit.change(function(){
		var param = getUrlParameter('limit');

		if (param) {
			window.location.href =
				window.location.href.replace('limit='+param, 'limit='+limit.val());
		} else {
			var url = window.location.href;
			url = url.indexOf('?') == -1 ? url+'?limit='+limit.val() : url+'&limit='+limit.val();
			window.location.href = url;
		}
	});
});