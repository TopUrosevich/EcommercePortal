//Login Popup

$(document).ready(function(){
    $(".log-in_menu").click(function(){
        if( $('.login_popup_box').hasClass('login_popup_box_show') ){
            $(".login_popup_box").removeClass("login_popup_box_show");
        } else {
            $(".login_popup_box").addClass("login_popup_box_show");
        }

    });
    $('html').click(function(e) {
        var container = $(".login_menu ");
        //login_popup_box_show

        if ( (!container.is(e.target) && container.has(e.target).length === 0) ) {
            $(".login_popup_box").removeClass("login_popup_box_show");
        }
    });

});


