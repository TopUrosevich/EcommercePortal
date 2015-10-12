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

    $("#more_ln").click(function(event){
        event.preventDefault();
        var ajax_blog_page_int = 2;
        if(getCookie("ajax_blog_page_int")){
            ajax_blog_page_int  = parseInt(getCookie("ajax_blog_page_int")) + 1;
        }
        setCookie("ajax_blog_page_int", ajax_blog_page_int);

        var query = window.location.href.substring(1);
        var vars = query.split("/");
        var ajax_category = vars[vars.length - 1];
        if(ajax_category == "blog"){
            ajax_category = "";
        }

        $.ajax({
            url: '/blog/index',
            type: 'POST',
            data: {ajax_blog_page_int: ajax_blog_page_int, ajax_category: ajax_category }
        }).done(function(data) {
            var response = JSON.parse(data);
            console.log(response);
            if (response != "null" && response.length != 0) {
                for (var i = 0; i < response.length; i++) {
                    var articles = response;
                    var article = articles[i];
                    $("#data_blogs").append(
                        '<div class="col-xs-4">'+
                        '<div class="news_preview">'+
                        '<a href="/blog/'+ article.category.alias +'/'+ article.alias +'">'+
                        '<img src="'+ article.images['h_120'] +'">'+
                        '<span>'+ article.title +'</span></a>'+
                        '<div class="content">'+ article.content.substr(0, 45) +
                        '</div></div></div>'
                    );
                }
            }else{
                $("#more_ln").hide("400");
                $(".news_pagination").html('<span class="red_txt">No more Articles...</span>');
            }
        });
    });

})(jQuery);