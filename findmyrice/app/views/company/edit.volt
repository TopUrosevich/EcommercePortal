{{ content() }}
    <div class="container wallaper profile_box">
        <div class="row">
            <form method="post" enctype="multipart/form-data" id="company-profile">
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
                {% include 'company/partials/leftMenu.volt' %}
            </div>
            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                <div class="row title_my_account">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>Profile</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 profile_form profile_form_cont">

                        {{ form.render("id") }}
                        {{ form.render("user_id") }}
                        <div class="form-group">
                            <label for="profile_title">Title</label>
                            {{ form.render("title") }}
                            {{ form.messages("title") }}
                        </div>
                        <div class="form-group">
                            <label for="profile_tagline" class="no_important">Tagline</label>
                            {{ form.render("tagline") }}
                            {{ form.messages("tagline") }}
                        </div>
                        <div class="form-group">
                            <label for="profile_short_description">Short Description (<span id="charNum_sd"></span> characters)</label>
                            {{ form.render("short_description") }}
                            {{ form.messages("short_description") }}
                        </div>
                        <div class="form-group">
                            <label for="profile_profile">About Us (<span id="charNum_ld"></span> characters)</label>
                            {{ form.render("long_description") }}
                            {{ form.messages("long_description") }}
                        </div>
                        <div class="form-group">
                            <label for="profile_website_name" class="no_important">Website</label>
                            {{ form.render("web_site") }}
                            {{ form.messages("web_site") }}
                        </div>
                        <div class="form-group">
                            <label for="profile_email">Email</label>
                            {{ form.render("email") }}
                            {{ form.messages("email") }}
                        </div>
                        <div class="profile_social_media">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="profile_title_bg">Social Media</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_linkedin" class="no_important">Linkedin</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("linkdin") }}
                                    {{ form.messages("linkdin") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_facebook" class="no_important">Facebook</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("facebook") }}
                                    {{ form.messages("facebook") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_google+" class="no_important">Google+</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("google_plus") }}
                                    {{ form.messages("google_plus") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_twitter" class="no_important">Twitter</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("twitter") }}
                                    {{ form.messages("twitter") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_pinterest" class="no_important">Pinterest</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("pinterest") }}
                                    {{ form.messages("pinterest") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_instagram" class="no_important">Instagram</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("instagram") }}
                                    {{ form.messages("instagram") }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="profile_title_bg">Address</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    {#<label for="profile_type_address">---</label>#}
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("type_address") }}
                                    {{ form.messages("type_address") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_address">Address</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("address") }}
                                    {{ form.messages("address") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_city" class="no_important">City</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("city") }}
                                    {{ form.messages("city") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_state" class="no_important">State</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("state") }}
                                    {{ form.messages("state") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label class="no_important">Country</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("country") }}
                                    {{ form.messages("country") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label class="no_important">Post Code</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("postcode") }}
                                    {{ form.messages("postcode") }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="profile_title_bg">Contact Detail</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_phone">Phone</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render("phone") }}
                                    {{ form.messages("phone") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label for="profile_fax" class="no_important">Fax</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    {{ form.render('fax') }}
                                    {{ form.messages('fax') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 profile_form">
                    <div class="profile_form_cont">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3 class="profile_title_bg">Profile image (1170 * 420px)</h3>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-7 col-xs-9">
                                <div class="profile_image">
                                    <a href="#" class="close_btn" id="image_remove">X</a>
                                    {% if profileImage_thumb %}
                                        {{ image(profileImage_thumb, "alt": "company no image", "id":"profile_image", 'width':'100%') }}
                                    {% elseif profileImage %}
                                        {{ image(profileImage, "alt": "company no image", "id":"profile_image", 'width':'100%') }}
                                    {% else %}
                                        {{ image("../images/gallery-img.jpg", "alt": "company no image", "id":"profile_image", 'width':'100%') }}
                                    {% endif %}
                                    <div id="loading-image" style="display: none; position: absolute; top:0; left: 40%;">
                                        <img src="../../img/ajax-loader.gif">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <span class="red_btn profile_edit_btn">Edit</span>
                                <input type="file" class="profile_upload" name="imageToUpload" id="imageToUpload" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3 class="profile_title_bg">Logo (400 * 400px)</h3>
                            </div>
                            <div class="col-lg-5 col-md-7 col-sm-4 col-xs-6">
                                <div class="profile_logo">
                                    <a href="#" class="close_btn" id="logo_remove">X</a>
                                    {% if userLogo_thumb %}
                                        {{ image(userLogo_thumb, "alt": "company logo", "id":"logo", 'width':'100%') }}
                                    {% elseif userLogo %}
                                        {{ image(userLogo, "alt": "company logo", "id":"logo", 'width':'100%') }}
                                    {% else %}
                                        {{ image("../images/NoLogoImage.jpg", "alt": "company no logo", "id":"logo", 'width':'100%') }}
                                    {% endif %}
                                    <div id="loading-logo" style="display: none; position: absolute; top:0; left: 40%;">
                                        <img src="../../img/ajax-loader.gif">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-6">
                                <span class="red_btn profile_edit_btn">Add Logo</span>
                                <input type="file" class="profile_upload" name="logoToUpload" id="logoToUpload" />
                            </div>
                        </div>
                        <div class="profile_hours">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="profile_title_bg">Hours Open*</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Monday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_mon_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_mon_2") }}
                                </div>
                                {{ form.messages("ho_mon_1") }}
                                {{ form.messages("ho_mon_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Tuesday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_tu_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_tu_2") }}
                                </div>
                                {{ form.messages("ho_tu_1") }}
                                {{ form.messages("ho_tu_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Wednesday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_wed_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_wed_2") }}
                                </div>
                                {{ form.messages("ho_wed_1") }}
                                {{ form.messages("ho_wed_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Thursday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_thu_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_thu_2") }}
                                </div>
                                {{ form.messages("ho_thu_1") }}
                                {{ form.messages("ho_thu_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Friday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_fri_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_fri_2") }}
                                </div>
                                {{ form.messages("ho_fri_1") }}
                                {{ form.messages("ho_fri_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Saturday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_sat_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_sat_2") }}
                                </div>
                                {{ form.messages("ho_sat_1") }}
                                {{ form.messages("ho_sat_2") }}
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Sunday</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_sun_1") }}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                    {{ form.render("ho_sun_2") }}
                                </div>
                                {{ form.messages("ho_sun_1") }}
                                {{ form.messages("ho_sun_2") }}
                            </div>
                        </div>
                    </div>


                    <div class="profile_form_bottom">
                        <h3 class="profile_title_bg key_words">Key Words - Enter key words that describe your products or services</h3>
                        <div class="row profile_box_form">
                            <div class="col-lg-4">
                                <input type="text" class="form-control" placeholder="Enter Key Words" id="key_words" />
                            </div>
                            <div class="col-lg-2 col-sm-5 col-xs-3">
                                <button type="button" class="red_btn" id="add_keywords">Add</button>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-2 text-center">
                                <span>OR</span>
                            </div>
                            <div class="col-lg-5 col-sm-5 col-xs-6">
                                <button type="button" data-toggle="modal" data-target="#lookUpKeyWordsModal" class="red_btn" id="look-up-key-words">Look Up Key Words</button>
                            </div>
                            <div class="col-lg-12">
                                {{ form.render("keywords") }}
                                {{ form.messages("keywords") }}
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="profile_title_bg">Public Profile URL</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{ text_field('preview-profile', 'class':'form-control', 'value': siteUrl ~ '/companies/'~user._id, 'placeholder':siteUrl ~ '/companies/'~user._id) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-6">
                                {{ link_to('companies/'~user._id, '<button type="button" class="red_btn">Preview Profile</button>', 'target':'_blank') }}
                            </div>
                            <div class="col-lg-4 col-lg-offset-4 col-md-5 col-md-offset-2 col-sm-4 col-sm-offset-4 col-xs-6">
                                {{ submit_button("Save & Publish", "class": "red_btn") }}
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>

<div class="modal fade" id="lookUpKeyWordsModal" tabindex="-1" role="dialog"
     aria-labelledby="attendModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <div class="modal-title">
                            <div class="keywords_separate">
                                <p class="red_txt">Browse the categories to find common key words to describe your products & services</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 keywords_popup_box">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body_keywords">
                                    <select name="lookUpKeyWords" id="lookUpKeyWords" multiple>
                                        <option value="Bakery">Bakery</option>
                                        <option value="Beverage - Non-alcoholic">Beverage - Non-alcoholic</option>
                                        <option value="Butcher">Butcher</option>
                                        <option value="Cleaning Supplies">Cleaning Supplies</option>
                                        <option value="Coffee & Tea">Coffee & Tea</option>
                                        <option value="Dairy">Dairy</option>
                                        <option value="Dietary">Dietary</option>
                                        <option value="Equipment">Equipment</option>
                                        <option value="Foodservice">Foodservice</option>
                                        <option value="Grocery">Grocery</option>
                                        <option value="Packaging">Packaging</option>
                                        <option value="Produce">Produce</option>
                                        <option value="Seafood">Seafood</option>
                                        <option value="Smallgoods">Smallgoods</option>
                                        <option value="Technology">Technology</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row modal-footer">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body_keywords text-right">
                                    <button type="button" class="red_btn mb15" id="lookUpAddKeyWords">Add Key Words</button>
                                </div>
                            </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
</div>