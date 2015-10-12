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

    var QueryString = function () {
        // This function is anonymous, is executed immediately and
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = pair[1];
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [ query_string[pair[0]], pair[1] ];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(pair[1]);
            }
        }
        return query_string;
    }();

    function addOrUpdateUrlParam(name, value)
    {
        var href = window.location.href;
        var regex = new RegExp("[&\\?]" + name + "=");
        if(regex.test(href))
        {
            regex = new RegExp("([&\\?])" + name + "=[\\w\\,]+");
            window.location.href = href.replace(regex, "$1" + name + "=" + value);
        }
        else
        {
            if(href.indexOf("?") > -1)
                window.location.href = href + "&" + name + "=" + value;
            else
                window.location.href = href + "?" + name + "=" + value;
        }
    }

    $('.lf_filter').on('click', function(event){
        event.preventDefault();
        var index_name = $(this).attr("data-index");
        var type_name = $(this).attr("data-type");
        var old_url_obj = QueryString;
        var new_val = '';
        if(typeof old_url_obj[type_name] === "undefined"){
            new_val = index_name;
        }else if(old_url_obj[type_name] == ""){
            new_val = index_name;
        }else{
            if(old_url_obj[type_name].indexOf(index_name) > -1){
                new_val =  old_url_obj[type_name].replace(','+index_name,'');
                if(new_val == old_url_obj[type_name]){
                    new_val =  old_url_obj[type_name].replace(index_name+',','');
                    if(new_val == old_url_obj[type_name]){
                        var href = window.location.href;
                        var regex = new RegExp("\\&" + type_name + "=\\w+");
                        window.location.href = href.replace(regex, '');
                        return;
                    }
                }
            }else{
                new_val = old_url_obj[type_name] +','+ index_name;
            }
        }
        addOrUpdateUrlParam(type_name, new_val);
    });

    //$('#clear_filters').on('click', function(){
    //    category.val('');
    //    country.val('');
    //    city.val('');
    //    window.location.replace(getUri());
    //});
    var href = window.location.href;
    if(href.indexOf("advanced_search") > -1){
        $("#advanced_search").toggle();
    }


    $(".view_products").on("click",function(event){
        event.preventDefault();
        var view = $(this);

        if(view.attr("not_click")){
            view.closest("tr").next("tr").toggle();
            return false;
        }

        var parent_class = view.parents('tr').attr('class');
        var company_id = view.attr("data-companyId");
        var search = window.location.search;
        $.ajax({
            url: '/ajax/getProductsBySearch',
            type: 'POST',
            async: false,
            data: {ajax_company_id: company_id, ajax_search: search}
        }).done(function(data) {
            var response = JSON.parse(data);

            for (var key in response) {
                if(key != "totalProducts"){
                    if (response.hasOwnProperty(key)) {
                        view.parents("tr").after(
                            '<tr><td colspan="3"><div class="product_list" id="'+company_id+'">' +
                            '<table class="view_table_products" id="table_'+company_id+'">' +
                            '<tr class="'+parent_class+'">' +
                            '<td>Product Name</td>' +
                            '<td>Unit/Qty</td>' +
                            '<td>Brand</td>' +
                            '</tr>' +
                            '</table>'+
                            '</td></div></tr>'
                        );
                        for (var key_item in response[key]) {
                            if (typeof response[key][key_item]._source !== 'undefined') {
                                view.parents("tr").next().find(".view_table_products>tbody").append('<tr class="'+parent_class+' small_td">' +
                                '<td>'+response[key][key_item]._source.product_name +'</td>' +
                                '<td>'+response[key][key_item]._source.unit_qty +'</td>' +
                                '<td>'+response[key][key_item]._source.brand+'</td>' +
                                '</tr>');
                            }
                        }
                    }
                }
            }
            view.attr("not_click", true);
        });

        var processing;
        var count = 1;
        $("#"+company_id).scroll(function(e){

            if (processing)
                return false;

            var abs = Math.abs($(document).height() - $("#table_"+company_id).height());

            if ($("#"+company_id).scrollTop() >= abs){
                processing = true;
                $.ajax({
                    url: '/ajax/getProductsBySearch',
                    type: 'POST',
                    data: {ajax_company_id: company_id, ajax_search: search, ajax_more_plus_products: count + 1 }
                }).done(function(data) {
                    var table = $("#table_"+company_id);
                    var response = JSON.parse(data);
                    var count_response_company_id = Object.keys(response[company_id]).length;
                    if(parseInt(count_response_company_id) > 1 ){
                        processing = false;
                    }else{
                        processing = true;
                        return false;
                    }
                    for (var key in response) {
                        if(key != "totalProducts"){
                            if (response.hasOwnProperty(key)) {
                                for (var key_item in response[key]) {
                                    if (typeof response[key][key_item]._source !== 'undefined') {
                                        table.append('<tr class="'+parent_class+' small_td">' +
                                        '<td>'+response[key][key_item]._source.product_name +'</td>' +
                                        '<td>'+response[key][key_item]._source.unit_qty +'</td>' +
                                        '<td>'+response[key][key_item]._source.brand+'</td>' +
                                        '</tr>');
                                    }
                                }
                            }
                        }
                    }
                    count++;
                });

            }
        });
    });

})(jQuery);