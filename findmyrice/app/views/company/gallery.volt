{{ content() }}
<div class="container wallaper profile_box">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12" id="upload_images_gal">
            <div class="row title_my_account">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Gallery</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-9">
                    Add photo’s to your profile up to 500kb each
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 text-right">
                    <form method="post" enctype="multipart/form-data" id="add_photos_form">
                    <div class="fileUpload text-center ">
                        <a href="#" class="red_txt">+ Add Photos</a>
                        <input type="file" class="file_upload_btn" id="add_photos" name="add_photos[]" multiple="">
                        <input type="hidden" name="add_photos_hidden" id="add_photos_hidden" value="1" />
                    </div>
                    <div style="display: none" id="ajax-loader-photos"><img src="../img/ajax-loader2.gif"></div>
                    <div style="display: none; color:#f40909" id="photos-message">Something went wrong.</div>
                    </form>
                </div>
                {% for type, messages in flashSession.getMessages() %}
                    {% for message in messages %}
                        <div class="alert alert-{{ type }}">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ message }}
                        </div>
                    {% endfor%}
                {% endfor %}
                {#{{ flashSession.output() }}#}
            </div>
            <div class="row drag_images gallery_photo_box">
                <p>Drag an image here </p>
                <p>or</p>
                <p> Click to upload</p>
            </div>
            {% if photos %}
                <div class="clearfix" id="images_box">
                {% for index, photo in photos %}
                            <div id="gallery_photo_{{ photo['_id'] }}" class="box photo col_images">
                                <a href="#" class="close_btn remove_image" id="{{ photo['_id'] }}">X</a>
                                <a href="{{ bucketUrl }}/companies/{{ photo['user_id'] }}/gallery/{{ photo['photo_name'] }}" class="fancybox" data-fancybox-group="gallery" title="gallery photo">
                                    <img src="{{ bucketUrl }}/companies/{{ photo['user_id'] }}/gallery/thumb_290x190_{{ photo['photo_name'] }}" />
                                </a>
                                <div class="loading-image_{{ photo['_id'] }}" style="display: none; position: absolute; top:0; left: 40%;">
                                    <img src="../../img/ajax-loader.gif">
                                </div>
                            </div>
                {% endfor %}
                </div>
            {% else %}
            <div class="row" id="images_box" class="clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 gallery_photo_container">
                    <div class="gallery_photo">

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 gallery_photo_container">
                    <div class="gallery_photo">

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 gallery_photo_container">
                    <div class="gallery_photo">

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 gallery_photo_container">
                    <div class="gallery_photo">

                    </div>
                </div>
            </div>
            {% endif %}
        </div>
    </div>
</div>