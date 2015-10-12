(function($) {
    $("#feedback_type").on("change", function(){
        var feedback_type_val = $("#feedback_type").val();
        if(feedback_type_val == ''){
            $("#label_feedback_type").show();
        }
        if(feedback_type_val != ''){
            $("#label_feedback_type").hide();
        }
    });

})(jQuery);