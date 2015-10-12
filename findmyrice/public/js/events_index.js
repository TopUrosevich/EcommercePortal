(function($) {
    $(".select_btn").chosen({
        no_results_text: "Oops, nothing found!"
    });

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

    if(getCookie("ajax_page_int")){
        eraseCookie("ajax_page_int");
    }

    $("#more_ln").click(function(event){
        event.preventDefault();
        var ajax_page_int = 2;
        if(getCookie("ajax_page_int")){
           ajax_page_int  = parseInt(getCookie("ajax_page_int")) + 1;
        }
        setCookie("ajax_page_int", ajax_page_int);

        var ajax_category = $('#category').val();
        var ajax_country = $('#country').val();
        var ajax_city = $('#city').val();
        $.ajax({
            url: '/events/index',
            type: 'POST',
            data: {ajax_page_int: ajax_page_int, ajax_category: ajax_category, ajax_country: ajax_country, ajax_city: ajax_city }
        }).done(function(data) {
           var response = JSON.parse(data);
           if (response != "null" && response.length != 0) {
            for (var i = 0; i < response.length; i++) {
                var events = response;
                var event = events[i];
                var start_date_date = new Date(event.start_date * 1000);
                var start_date_day = start_date_date.getUTCDate();
                var start_date_year = start_date_date.getUTCFullYear();
                //var start_date_month= start_date_date.getUTCMonth() + 1;

                var end_date_date = new Date(event.end_date * 1000);
                var end_date_day = end_date_date.getUTCDate();
                var end_date_year = end_date_date.getUTCFullYear();
                //var end_date_month= end_date_date.getUTCMonth() + 1;
                var locale = "en-us";
                var end_date_month = end_date_date.toLocaleString(locale, {month: "short"});
                $("#data_events").append(
                    '<div class="col-lg-4 col-md-4 col-sm-6">' +
                    '<div class="events_preview">' +
                    '<a href="/events/' + event.category.alias + '/"' + event._id.$id + '">' +
                    '<div class="events_preview_top">' +
                    '<div class="venue">' + event.event_name + '</div>' +
                    '<div class="date">' + start_date_day + ' - ' + end_date_day + ' ' + end_date_month + ' ' + end_date_year + '</div>' +
                    '<div class="location">' + event.city + ',' + event.country + '</div>' +
                    '<div class="category">' + event.category.title + '</div>' +
                    '<div class="description">' + event.description.substr(0, 110) + '...</div>' +
                    '</div></a>' +
                    '<div class="events_preview_bootom">' +
                    '<a href="/events/' + event.category.alias + '/' + event._id.$id + '">' +
                    '<button type="button" class="primary_btn">View Details</button>' +
                    '</a></div></div></div>'
                );
            }
            }else{
                $("#more_ln").hide("400");
                $(".events_pagination").html('<span class="red_txt">No more events...</span>');
            }
        });
    });

})(jQuery);