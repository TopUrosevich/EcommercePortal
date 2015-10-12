(function($) {

    $(".advanced_search_btn").click(function(event){
        $("#advanced_search").toggle();
        event.preventDefault();
    });
    $(".select_btn").chosen({
        no_results_text: "Oops, nothing found!"
    });

    $("#country").on("change",function(){
        var country = $("#country").val();
        $.ajax({
            url: '/ajax/getStates',
            type: 'POST',
            data: {ajax_country: country}
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response != "null" && response.length != 0) {
                $("#state").prop("disabled", false);
                var html = '';
                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        html+='<option value="'+key+'">'+response[key]+'</option>';
                    }
                }
                $("#state").html('<option value="">State</option>');
                $("#city").html('<option value="">City</option>');
                $("#city").prop("disabled", true);
                $("#state").append(html);
                $('#city').trigger('chosen:updated');
                $('#state').trigger('chosen:updated');
            }else{

            }
        });

    });


    $("#state").on("change",function(){
        var country = $("#country").val();
        var state = $("#state").val();
        $.ajax({
            url: '/ajax/getCities',
            type: 'POST',
            data: {ajax_country: country, ajax_state: state}
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response != "null" && response.length != 0) {
                $("#city").prop("disabled", false);
                var html = '';
                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        html+='<option value="'+key+'">'+response[key]+'</option>';
                    }
                }
                $("#city").html('<option value="">City</option>');
                $("#city").append(html);
                $('#city').trigger('chosen:updated');
            }else{

            }
        });

    });
})(jQuery);