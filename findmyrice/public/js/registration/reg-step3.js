(function($) {
    $("#add_keywords").on("click", function(){
        var key_words = $("#key_words").val();
        if(key_words !=''){
            var old_key_words_area_val = $("#key_words_area").val();
            if(old_key_words_area_val == ''){
                $("#key_words_area").val( key_words);
            }else{
                $("#key_words_area").val(old_key_words_area_val+',' + key_words);
            }
        }
    });

    $("#register_btn_box").on("click", function(){
        //$("#register_btn_box").prop( "disabled", true );
        $("#please_wait").show();
    });

    $("#lookUpAddKeyWords").click(function(event){
        var select_val = $("#lookUpKeyWords").val();
        select_val = select_val.toString().replace(/,/g , ", ");
        if(select_val != "null" ){
            var old_key_words_area_val = $("#key_words_area").val();
            if(old_key_words_area_val == ''){
                $("#key_words_area").val(select_val);
            }else{
                $("#key_words_area").val(old_key_words_area_val+', ' + select_val);
            }
            $(".glyphicon-remove-circle").trigger("click");
        }
    });
})(jQuery);