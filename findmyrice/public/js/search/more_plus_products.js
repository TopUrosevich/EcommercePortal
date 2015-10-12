(function($) {

    function setCookie(sName, sValue)
    {
        document.cookie = sName + "=" + escape(sValue);
        // Expires the cookie in one month
        var date = new Date();
        date.setMonth(date.getMonth()+1);
        document.cookie += ("; expires=" + date.toUTCString());
    }

    function getCookie(sName)
    {
        // cookies are separated by semicolons
        var aCookie = document.cookie.split("; ");
        for (var i=0; i < aCookie.length; i++)
        {
            // a name/value pair (a crumb) is separated by an equal sign
            var aCrumb = aCookie[i].split("=");
            if (sName == aCrumb[0])
                return unescape(aCrumb[1]);
        }
        // a cookie with the requested name does not exist
        return null;
    }

    function eraseCookie(cname) {
        setCookie(cname,"",-1);
    }

    if(getCookie("ajax_blog_page_int")){
        eraseCookie("ajax_blog_page_int");
    }

    // Get an array of all cookie names (the regex matches what we don't want)
    var cookieNames = document.cookie.split(/=[^;]*(?:;\s*|$)/);

    //// Remove any that match the pattern
    for (var i = 0; i < cookieNames.length; i++) {
        if(cookieNames[i].indexOf("ajax_more_plus_products_") > -1){
            eraseCookie(cookieNames[i]);
        }
    }

    $(".more_products").live("click",function(event){
        event.preventDefault();
        var more_plus = $(this);
        var company_id = more_plus.attr("data-companyId");
        var cookie_name = "ajax_more_plus_products_" + company_id;
        var ajax_more_plus_products = 2;

        if(getCookie(cookie_name)){
            ajax_more_plus_products  = parseInt(getCookie(cookie_name)) + 1;
        }
        setCookie(cookie_name, ajax_more_plus_products);

        var parent_class = more_plus.parent().prev("table").attr('class');
        var search = window.location.search;
        $.ajax({
            url: '/ajax/getProductsBySearch',
            type: 'POST',
            data: {ajax_company_id: company_id, ajax_search: search, ajax_more_plus_products: ajax_more_plus_products }
        }).done(function(data) {
            var table = more_plus.parent().prev("table");
            more_plus.parent().remove();
            var response = JSON.parse(data);
            for (var key in response) {
                if(key != "totalProducts"){
                    if (response.hasOwnProperty(key)) {
                        for (var key_item in response[key]) {
                            table.append('<tr class="'+parent_class+' small_td">' +
                            '<td>'+response[key][key_item]._source.product_name +'</td>' +
                            '<td>'+response[key][key_item]._source.unit_qty +'</td>' +
                            '<td>'+response[key][key_item]._source.brand+'</td>' +
                            '</tr>');
                        }
                        var count_resp = ajax_more_plus_products * response[key].length;
                        var count = parseInt($("#count_"+company_id).text()) + response[key].length;
                        $("#count_"+company_id).html(count);
                        //$("#count_"+company_id).html(response["totalProducts"]);
                        if(response["totalProducts"] > count_resp){
                            $("#"+company_id).append('<div class="product_list text-center"><a href="#" class="more_products red_txt" data-companyId='+company_id+'>+More</a></div>');
                        }
                    }
                }

            }
        });
    });

})(jQuery);