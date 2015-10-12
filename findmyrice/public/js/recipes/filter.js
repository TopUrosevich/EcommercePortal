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

	var sort = $('#sort_by');
	var param = getUrlParameter('sort');

	sort.val(param ? param : 'newest');

	sort.change(function(){
		var param = getUrlParameter('sort');

		if (param) {
			window.location.href =
				window.location.href.replace('sort='+param, 'sort='+sort.val());
		} else {
			var url = window.location.href;
			url = url.indexOf('?') == -1 ? url+'?sort='+sort.val() : url+'&sort='+sort.val();
			window.location.href = url;
		}
	});
});
