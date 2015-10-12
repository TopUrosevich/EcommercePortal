{{ content() }}
<div class="user_profile_box">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9">
                {% include 'user/partials/headerBanner.volt' %}
                {% include 'user/partials/headerMenu.volt' %}
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="edit_profile_txt">Edit Profile</h2>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" id="user-details" class="user_form">
                    {{ form.render("id") }}
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" profile_logo">
                                        <a href="#" class="close_btn" id="logo_remove">X</a>
                                        {% if userLogo_thumb %}
                                            {{ image(userLogo_thumb, "alt": "user logo", "id":"logo", 'width':'100%', 'class': 'user_photo') }}
                                        {% elseif userLogo %}
                                            {{ image(userLogo, "alt": "user logo", "id":"logo", 'width':'100%', 'class': 'user_photo') }}
                                        {% else %}
                                            {{ image("../images/no_photo.png", "alt": "user no logo", "id":"logo", 'width':'100%', 'class': 'user_photo') }}
                                        {% endif %}
                                        <div id="loading-logo" style="display: none; position: absolute; top:0; left: 40%;">
                                            <img src="../../img/ajax-loader.gif">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                                    <div class="fileUpload red_btn text-center mb20">
                                        <span>Add Photo</span>
                                        <input type="file" class="file_upload_btn" name="logoToUpload" id="logoToUpload" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <label for="user_name">Name</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    {{ form.render("first_name") }}
                                    {{ form.messages("first_name") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <label for="user_email">Email</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    {{ form.render("email") }}
                                    {{ form.messages("email") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <label for="user_position" class="no_important">Position</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    {{ form.render("position") }}
                                    {{ form.messages("position") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <label for="user_state" class="no_important">State</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    {{ form.render("state") }}
                                    {{ form.messages("state") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <label for="user_country" class="no_important">Country</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    {{ form.render("country") }}
                                    {{ form.messages("country") }}
                                </div>
                            </div>
                            <div class="row password_box">
                                <div class="col-lg-12">
                                    <label class="no_important">Change Password</label>
                                </div>
                                <div class="col-lg-12">
                                    <span class="change_pass_txt">If you would like to change the password type a new one. Otherwise leave this blank</span>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{ form.render("password") }}
                                    {{ form.messages("password") }}
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{ form.render("confirmPassword") }}
                                    {{ form.messages("confirmPassword") }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    {{ submit_button("Save", "class": "red_btn save_btn mb20") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {% include 'user/partials/rightBanner.volt' %}
        </div>
    </div>
</div>