(function($) {
    var href = window.location.href;
    if(href.indexOf("save-assa") > -1 || href.indexOf("edit") > -1){
        $("#service_area").show();
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
    $(".add_single_btn").on("click", function(event){
        $("#service_area").toggle('400');
    });
    $(".exit_btn").on("click", function(event){
        $("#service_area").toggle('400');
    });
})(jQuery);