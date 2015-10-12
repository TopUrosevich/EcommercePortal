{{ content() }}
 {% for type, messages in flashSession.getMessages() %}
     {% for message in messages %}
         <div class="alert alert-{{ type }}">
             <button type="button" class="close" data-dismiss="alert">&times;</button>
             {{ message }}
         </div>
     {% endfor%}
 {% endfor %}
{#{{ flashSession.output() }}#}

<div class="container wallaper profile_box">
    <div class="row title_my_account">
        <div class="col-lg-7 col-lg-offset-2 col-md-7 col-md-offset-2 col-xs-12"><h2>Advertising</h2></div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="advertising_box">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        {{ link_to('company/advertising','<button type="button" class="white_btn advertising_box_btn">Advertising Options</button>') }}
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        {{ link_to('company/advertising-my-campaigns','<button type="button" class="red_btn">My Campaigns</button>') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Banner ad</h4>
                        <p class="advertisingBox_info">
                            If you have already created a banner ad you can upload it here and begin advertising your product or service on Find My Rice. Banner ads are great for building brand recognition or promoting a specific product or service. Banner ads do not require a lot of text to get your message across and are located in prime positions on the site.
                        </p>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" id="banner_ad">
                <div class="row">
                    <div class="service_ad_container">
                        <div class="col-lg-7 col-md-7 service_ad_container_inner">
                            <div class="service_ad_box">
                                <div class="form-group">
                                    <label for="profile_link" class="no_important">Profile Link</label>
                                    {{ text_field('profile_link', 'class':'form-control', 'placeholder':'https://www.findmyrice.com/companies/'~user_id, 'disabled':'disabled') }}
                                </div>
                                <div class="separate"></div>
                                <div class="form-group">
                                    <label for="ad_file" class="no_important">Banner Ad File</label>
                                    {{ form.render("ad_file") }}
                                    {{ form.messages("ad_file") }}
                                </div>
                                <div class="row fileUpload_box">
                                    <div class="col-lg-5 col-md-5 col-sm-6">
                                        <div class="fileUpload red_btn text-center">
                                            <span>Upload Banner</span>
                                            {{ form.render("upl_image_upload") }}
                                        </div>
                                        {{ form.messages("upl_image_upload") }}
                                    </div>
                                </div>
                                <div class="separate"></div>
                                <div class="form-group">
                                    <label for="alt_text" class="no_important">Alt Text (Ad name)</label>
                                    {{ form.render("alt_text") }}
                                    {{ form.messages("alt_text") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 preview_ad_container">
                            <h3 class="preview_add_txt">Preview Ad</h3>
                            <div class="preview_ad_box_outer">
                                <img id="preview_banner_img" src="<?php echo SITE_URL; ?>/images/no-banner.jpg" alt="advertising image" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5 mt10">
                        <button type="submit" class="red_btn place_order ml15">Place order</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>