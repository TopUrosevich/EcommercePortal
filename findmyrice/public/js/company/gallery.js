(function($) {

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function uploadData_gallery(formData){

        $("#ajax-loader-photos").show();
        $.ajax({
            url: '/ajax/galleryUpload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if(response){
                window.location.reload();
            }else{
                $("#ajax-loader-photos").hide();
                $("#photos-message").show();
            }
        });
    }

    //gallery
    $(".gallery_photo_box").on("dragover", function(event){
        allowDrop(event);
    });
    $(".gallery_photo_box").on("drop", function(event){
        var files = event.originalEvent.dataTransfer.files;
        var uploadFormData = new FormData($("#add_photos_form")[0]);
        if(files.length > 0) { // checks if any files were dropped
            for(var f = 0; f < files.length; f++) { // for-loop for each file dropped
                uploadFormData.append("add_photos[]",files[f]);  // adding every file to the form so you could upload multiple files
            }
        }
        uploadData_gallery(uploadFormData);
        return false;
    });

    $('#add_photos').bind('change', function(event){
        //...
    });

    $('.gallery_photo_box').bind('click', function(e){
        if(e.target.className != "close_btn remove_image"){
            $('#add_photos').click();
        }
    });


    var href = window.location.href;

    $("#add_photos").on("change", function(event){

        var form = $("#add_photos_form");
        $("#ajax-loader-photos").show();
        $.ajax({
            url: '/ajax/galleryUpload',
            type: 'POST',
            data: new FormData( form[0] ),
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            console.log(response);
            if(response){
                //$("#photos-message").append('Some files have large size. And cannot upload to server.').show();
                window.location.reload();
            }else{
                $("#ajax-loader-photos").hide();
                $("#photos-message").show();
            }
        });
        event.preventDefault();
    });

    $(".close_btn").on('click',function(event){
        event.preventDefault();
        var remove_image_id = $(this)[0].id;
        var str = $(this)[0].nextElementSibling.src;
            if(confirm('Are you sure you want delete.')){
                $('#loading-image_' + remove_image_id).show();
                $.ajax({
                    url: '/ajax/removeGalleryImage',
                    type: 'POST',
                    data: { remove_image_id: remove_image_id}
                }).done(function(data) {
                    var response = JSON.parse(data);
                    if(response == 'removed'){
                        $('#gallery_photo_' + remove_image_id).hide();
                    }else{
                        $("#photos-message").append('<br />Cannot delete the image. Please try again latter.').show();
                        $('#loading-image_' + remove_image_id).hide();
                    }
                });
            }


    });
})(jQuery);