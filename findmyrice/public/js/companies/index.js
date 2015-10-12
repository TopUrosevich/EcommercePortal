(function($) {
    var $images_box = $('#images_box');
    $images_box.imagesLoaded( function(){
        $images_box.masonry({
            itemSelector : '.box',
            /*gutterWidth: 25,*/
            columnWidth: 5,
            isAnimated: true
        });
    });

    $("#aboute_more_link").click(function(ev){
        ev.preventDefault();
        //$("#short_desc").toggle();
        $("#long_desc").toggle();
    });

    $(".show_phone_number").click(function(ev){
        ev.preventDefault();
        var $this = $(this).next();
        $this.show();
        $(this).hide();
    });

    $(".show_web_site").click(function(ev){
        ev.preventDefault();
        var $this = $(this).next();
        $this.show();
        $(this).hide();
    });
    $("#contact_supplier").click(function(ev){
        ev.preventDefault();
        $("#contactSupplier").show();
    });

    $(".close").click(function(){
        $("#contactSupplier").hide();
    });

})(jQuery);