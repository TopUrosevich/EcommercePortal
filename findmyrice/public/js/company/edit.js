(function($) {


    function allowDrop(ev) {
        ev.preventDefault();
    }

    function uploadData_image(formData){
        //var form = $("#company-profile");
        $("#logoToUpload").prop('disabled', true);
        $("#loading-image").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                $('#profile_image').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#profile_image').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#profile_image').attr('src', '').attr('src', response.original_image);
            }else{
                $('#profile_image').attr('src', '').attr('src', '../images/gallery-img.jpg');
            }
            $("#logoToUpload").prop('disabled', false);
            $("#loading-image").hide();
        });
    }

    function uploadData_logo(formData){
        $("#imageToUpload").prop('disabled', true);
        $("#loading-logo").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                $('#logo').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#logo').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#logo').attr('src', '').attr('src', response.original_image);
            }else{
                $('#logo').attr('src', '').attr('src', '../images/NoLogoImage.jpg');
            }
            $("#imageToUpload").prop('disabled', false);
            $("#loading-logo").hide();
        });
    }

    $(".profile_image").on("dragover", function(event){
        allowDrop(event);
    });
    $(".profile_image").on("drop", function(event){
        var files = event.originalEvent.dataTransfer.files;
        var selected_file = files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#profile_image').attr('src' , selected_file);
        var uploadFormData = new FormData($("#company-profile")[0]);
        uploadFormData.append("imageToUpload",files[0]);
        uploadData_image(uploadFormData);
        return false;
    });

    $('.profile_image').bind('click', function(e){
        if(e.target.className != "close_btn"){
            $('#imageToUpload').click();
        }
    });

    //logo
    $(".profile_logo").on("dragover", function(event){
        allowDrop(event);
    });
    $(".profile_logo").on("drop", function(event){
        var files = event.originalEvent.dataTransfer.files;
        var selected_file = files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#logo').attr('src' , selected_file);
        var uploadFormData = new FormData($("#company-profile")[0]);
        uploadFormData.append("logoToUpload",files[0]);
        uploadData_logo(uploadFormData);
        return false;
    });

    $('#imageToUpload').bind('change', function(event){
        var selected_file = $('#imageToUpload').get(0).files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#profile_image').attr('src' , selected_file);
    });

    $('.profile_logo').bind('click', function(e){
        if(e.target.className != "close_btn"){
            $('#logoToUpload').click();
        }
    });

    $('#logoToUpload').bind('change', function(event){
        var selected_file = $('#logoToUpload').get(0).files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#logo').attr('src' , selected_file);
    });


    $("#imageToUpload").on("change", function(event){
        var form = $("#company-profile");
        $("#logoToUpload").prop('disabled', true);
        $("#loading-image").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: new FormData( form[0] ),
            processData: false,
            contentType: false
        }).done(function(data) {
           var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                    $('#profile_image').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#profile_image').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#profile_image').attr('src', '').attr('src', response.original_image);
            }else{
                $('#profile_image').attr('src', '').attr('src', '../images/gallery-img.jpg');
            }
            $("#logoToUpload").prop('disabled', false);
            $("#loading-image").hide();
        });
        event.preventDefault();
    });
    $("#logoToUpload").on("change", function(event){
        var form = $("#company-profile");
        $("#imageToUpload").prop('disabled', true);
        $("#loading-logo").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: new FormData( form[0] ),
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                $('#logo').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#logo').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#logo').attr('src', '').attr('src', response.original_image);
            }else{
                $('#logo').attr('src', '').attr('src', '../images/NoLogoImage.jpg');
            }
            $("#imageToUpload").prop('disabled', false);
            $("#loading-logo").hide();
        });
        event.preventDefault();
    });

    $("#add_keywords").on("click", function(){
        var key_words = $("#key_words").val();
        if(key_words !=''){
            var old_key_words_area_val = $("#keywords").val();
            if(old_key_words_area_val == ''){
                $("#keywords").val( key_words);
            }else{
                $("#keywords").val(old_key_words_area_val+', ' + key_words);
            }
        }
    });

    $(".close_btn").click(function(event){

        var close_id = $(this)[0].id;
        var str = $(this)[0].nextElementSibling.src;
        if(str.indexOf("NoLogoImage.jpg") > -1 || str.indexOf("gallery-img.jpg") > -1) { } else {
            if(confirm('Are you sure you want delete.')){
                $.ajax({
                    url: '/ajax/removeImage',
                    type: 'POST',
                    data: { close_id: close_id}
                }).done(function(data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    if(response == 'profile_image'){
                        $('#profile_image').attr('src' , '../images/gallery-img.jpg');
                    }else if(response == 'logo'){
                        $('#logo').attr('src' , '../images/NoLogoImage.jpg');
                    }
                });
            }
        }
        event.preventDefault();

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
        address: 'long_name',
        city: 'long_name',
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
                addressType = 'city';
            }else if(addressType == 'administrative_area_level_1'){
                addressType = 'state';
            }else if(addressType == 'route'){
                addressType = 'address';
            }else if(addressType == 'postal_code'){
                addressType = 'postcode';
            }
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
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

    //textArea limiter
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });

    var elem_sd = $("#charNum_sd");
    $("#short_description").limiter(250, elem_sd);

    var elem_ld = $("#charNum_ld");
    $("#long_description").limiter(1000, elem_ld);

    $("#lookUpAddKeyWords").click(function(event){
        var select_val = $("#lookUpKeyWords").val();
        select_val = select_val.toString().replace(/,/g , ", ");
        if(select_val != "null" ){
                var old_key_words_area_val = $("#keywords").val();
                if(old_key_words_area_val == ''){
                    $("#keywords").val(select_val);
                }else{
                    $("#keywords").val(old_key_words_area_val+', ' + select_val);
                }
            $(".glyphicon-remove-circle").trigger("click");
        }
    });
})(jQuery);