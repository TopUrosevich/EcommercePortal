(function($) {
    $("#upl_image_upload").on('change',function(event){
        var selected_file = $('#upl_image_upload').get(0).files[0];
        var image_name = selected_file.name;
        selected_file = window.URL.createObjectURL(selected_file);
        $('#ad_file').val(image_name);
        $('#preview_banner_img').attr('src' , selected_file);
        $('#preview_banner_img').attr('alt' , 'banner iamge');
        $('#preview_banner_img').attr('height' , '265px');
        event.preventDefault();
    });
})(jQuery);