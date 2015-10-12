(function($) {

    $("#upl_image_upload").on('change',function(event){
        var selected_file = $('#upl_image_upload').get(0).files[0];
        var image_name = selected_file.name;
        selected_file = window.URL.createObjectURL(selected_file);
        $('#upl_image').val(image_name);
        $('#preview_advertising_img').attr('src' , selected_file);
        $('#preview_advertising_img').attr('alt' , 'advertising iamge');
        $('#preview_advertising_img').attr('height' , '145px');
        event.preventDefault();
    });


    var headline = $('#headline');
    headline.on('keyup',function(){
        $('#preview_advertising_headline').html(headline.val());
    });
    var textArea = $('#text');
    textArea.on('keyup',function(){
        $('#preview_advertising_text').html(textArea.val());
    });
    if(headline.val()){
        $('#preview_advertising_headline').html(headline.val());
    }
    if(textArea.val()){
      $('#preview_advertising_text').html(textArea.val());
    }

})(jQuery);