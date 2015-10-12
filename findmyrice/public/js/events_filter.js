var category = $('#category');
var country = $('#country');
var city = $('#city');

function getUri(){
    return '/events'
        + (category.val() || country.val() ? '/filter' : '')
        + (category.val() ? '/category/'+category.val() : '')
        + (country.val() ? '/country/'+country.val() : '')
        + (country.val() && city.val() ? '/city/'+city.val() : '');
}

category.on('change', function(){
	window.location.replace(getUri());
});
country.on('change', function(){
	window.location.replace(getUri());
});
city.on('change', function(){
	window.location.replace(getUri());
});

$('#clear_filters').on('click', function(){
    category.val('');
    country.val('');
    city.val('');
    window.location.replace(getUri());
});
