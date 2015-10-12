(function($) {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete;
    //var componentForm = {
    //    street_number: 'short_name',
    //    route: 'long_name',
    //    locality: 'long_name',
    //    administrative_area_level_1: 'short_name',
    //    country: 'long_name',
    //    postal_code: 'short_name'
    //};

    var componentForm = {
        street_address: 'long_name',
        suburb_town_city: 'long_name',
        state: 'short_name',
        country: 'long_name',
        postcode: 'short_name'
    };

    function initialize() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('type_address')),
            { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            fillInAddress();
        });
    }

// [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if(addressType == 'locality'){
                addressType = 'suburb_town_city';
            }else if(addressType == 'administrative_area_level_1'){
                addressType = 'state';
            }else if(addressType == 'route'){
                addressType = 'street_address';
            }else if(addressType == 'postal_code'){
                addressType = 'postcode';
            }
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
                if(addressType == 'country'){
                    $('#country_code option').filter(function() {
                        var t = new RegExp(val+'\\s\\+(\\d+)?');
                        return t.test(this.value);
                    }).prop('selected', 'selected');
                }
            }
        }
    }
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
// [END region_geolocation]
    $("#type_address").on("focus", function(event){
        geolocate();
    });
    initialize();
})(jQuery);