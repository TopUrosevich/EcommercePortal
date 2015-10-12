(function($) {
    var href = window.location.href;
    if(href.indexOf("area_details") > -1 || href.indexOf("profile") > -1 || href.indexOf("edit") > -1){
        $("#service_area").show('400');
        var val_type_address =  $("#type_address").val();
        if(val_type_address != ''){
            var componentForm = {
                street_address: 'long_name',
                suburb_town_city: 'long_name',
                state: 'short_name',
                country: 'long_name',
                postcode: 'short_name'
            };
            for (var component in componentForm) {
                document.getElementById(component).disabled = false;
            }
        }
    }
    if(href.indexOf("edit") > -1){
       $( "#area_details_tab" ).removeClass( "active" );
       $( "#area_details" ).removeClass( "active" );
       $( "#profile_tab" ).addClass( "active" );
       $( "#profile" ).addClass( "active" );
    }
    if(href.indexOf("profile") > -1){
        $( "#area_details_tab" ).removeClass( "active" );
        $( "#area_details" ).removeClass( "active" );
        $( "#profile_tab" ).addClass( "active" );
        $( "#profile" ).addClass( "active" );
    }
    $(".add_single_btn").on("click", function(event){
        $("#service_area").toggle('400');
    });
    $(".exit_btn").on("click", function(event){
        $("#service_area").toggle('400');
    });

    $("#upload_product_list").on("change", function(event){

        var form = $("#product-list");
        $("#ajax-loader-product").show();
        $.ajax({
            url: '/ajax/productUpload',
            type: 'POST',
            data: new FormData( form[0] ),
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if(response == 1){
                window.location.reload();
            }else if(response == 'extension'){
                $("#product-message").append("<br />Please use only .pdf, doc, .docx, .xls, .xlsx, .csv formats.").show();
                $("#ajax-loader-product").hide();
            }else{
                $("#ajax-loader-product").hide();
                $("#product-message").show();
            }
        });
        event.preventDefault();
    });
    //$(".for-chosen").chosen({
    //    no_results_text: "Oops, nothing found!"
    //});

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete, ad_autocomplete;
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
    var componentForm_ad = {
        ad_suburb_town_city: 'long_name',
        ad_state: 'short_name',
        ad_country: 'long_name'
    };

    function initialize() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('type_address')),
            { types: ['geocode'] });
        ad_autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('ad_type_address')),
            { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            fillInAddress(0);
        });
        google.maps.event.addListener(ad_autocomplete, 'place_changed', function() {
            fillInAddress(1);
        });
    }

// [START region_fillform]
    function fillInAddress(index) {
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        if(index == 0){
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

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
        } else {
            // Get the place details from the autocomplete object.
            var place_ad = ad_autocomplete.getPlace();
            for (var component_ad in componentForm_ad) {
                document.getElementById(component_ad).value = '';
                document.getElementById(component_ad).disabled = false;
            }
            for (var i = 0; i < place_ad.address_components.length; i++) {
                var addressType_ad = place_ad.address_components[i].types[0];
                if(addressType_ad == 'locality'){
                    addressType_ad = 'ad_suburb_town_city';
                }else if(addressType_ad == 'administrative_area_level_1'){
                    addressType_ad = 'ad_state';
                }else if(addressType_ad == 'country'){
                    addressType_ad = 'ad_country';
                }
                if (componentForm_ad[addressType_ad]) {
                    var val = place_ad.address_components[i][componentForm_ad[addressType_ad]];
                    document.getElementById(addressType_ad).value = val;
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