(function($) {

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function uploadData_logo(formData){
        $("#imageToUpload").prop('disabled', true);
        $("#loading-logo").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                $('#logo').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#logo').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#logo').attr('src', '').attr('src', response.original_image);
            }else{
                $('#logo').attr('src', '').attr('src', '../images/no_photo.png');
            }
            $("#imageToUpload").prop('disabled', false);
            $("#loading-logo").hide();
        });
    }

    //logo
    $(".profile_logo").on("dragover", function(event){
        allowDrop(event);
    });
    $(".profile_logo").on("drop", function(event){
        var files = event.originalEvent.dataTransfer.files;
        var selected_file = files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#logo').attr('src' , selected_file);
        var uploadFormData = new FormData($("#user-details")[0]);
        uploadFormData.append("logoToUpload",files[0]);
        uploadData_logo(uploadFormData);
        return false;
    });

    $('.profile_logo').bind('click', function(e){
        if(e.target.className != "close_btn"){
            $('#logoToUpload').click();
        }
    });

    $('#logoToUpload').bind('change', function(event){
        var selected_file = $('#logoToUpload').get(0).files[0];
        selected_file = window.URL.createObjectURL(selected_file);
        $('#logo').attr('src' , selected_file);
    });

    $("#logoToUpload").on("change", function(event){
        var form = $("#user-details");
        $("#imageToUpload").prop('disabled', true);
        $("#loading-logo").show();
        $.ajax({
            url: '/ajax/logoUpload',
            type: 'POST',
            data: new FormData( form[0] ),
            processData: false,
            contentType: false
        }).done(function(data) {
            var response = JSON.parse(data);
            if (response.tumb_image_290x190) {
                $('#logo').attr('src', '').attr('src', response.tumb_image_290x190);
            }else if(response.tumb_image_266x300){
                $('#logo').attr('src', '').attr('src', response.tumb_image_266x300);
            }else if(response.original_image){
                $('#logo').attr('src', '').attr('src', response.original_image);
            }else{
                $('#logo').attr('src', '').attr('src', '../images/no_photo.png');
            }
            $("#imageToUpload").prop('disabled', false);
            $("#loading-logo").hide();
        });
        event.preventDefault();
    });



    $(".close_btn").click(function(event){
        event.preventDefault();
        var close_id = $(this)[0].id;
        var str = $(this)[0].nextElementSibling.src;
        if(str.indexOf("no_photo.png") > -1) { } else {
            if(confirm('Are you sure you want delete.')){
                $.ajax({
                    url: '/ajax/removeImage',
                    type: 'POST',
                    data: { close_id: close_id}
                }).done(function(data) {
                    var response = JSON.parse(data);
                    if(response == 'logo'){
                        $('#logo').attr('src' , '../images/no_photo.png');
                    }
                });
            }
        }
    });
})(jQuery);