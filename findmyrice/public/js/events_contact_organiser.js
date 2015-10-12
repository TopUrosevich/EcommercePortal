(function($) {
    $("#contact_organiser").on('click', function(){
        $("#contactOrganiser").show();
    });
    $(".close").on('click', function(){
        $("#contactOrganiser").hide('400');
    });
})(jQuery);
