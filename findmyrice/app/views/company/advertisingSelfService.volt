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
                        <h4>Create a self-service ad</h4>
                        <p class="advertisingBox_info">
                            You can begin advertising on Find My Rice in just a few minutes. Whether you are looking to promote a new product or service, communicate with exisiting or new customers through our newsletters or have a prepared banner ad of your own we have a number of different low cost options to get you started.
                        </p>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" id="self_service_ad">
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
                                    <label for="upl_image" class="no_important">Image</label>
                                    {{ form.render("upl_image") }}
                                    {{ form.messages("upl_image") }}
                                </div>
                                <div class="row fileUpload_box">
                                    <div class="col-lg-5 col-md-5 col-sm-6">
                                        <div class="fileUpload red_btn text-center">
                                            <span>Upload Image</span>
                                            {{ form.render("upl_image_upload") }}
                                        </div>
                                        {{ form.messages("upl_image_upload") }}
                                    </div>
                                </div>
                                <div class="separate"></div>
                                <div class="form-group">
                                    <label for="headline" class="no_important">Headline</label>
                                    {{ form.render("headline") }}
                                    {{ form.messages("headline") }}
                                </div>
                                <div class="separate"></div>
                                <div class="form-group mb15">
                                    <label for="text" class="no_important">Text</label>
                                    {{ form.render("text") }}
                                    {{ form.messages("text") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 preview_ad_container">
                            <h3 class="preview_add_txt">Preview Ad</h3>
                            <div class="preview_ad_box_outer">
                                <div class="preview_ad_box">
                                    <a href="#" class="gray_txt">Sponsored Link</a>
                                    <a href="#" class="pull-right blue_txt">Create Advert</a>
                                    <div class="advertising_img">
                                        <img id="preview_advertising_img" src="<?php echo SITE_URL; ?>/images/advertising.png" alt="advertising iamge" />
                                    </div>
                                    <h2 id="preview_advertising_headline">
                                        Brighten up your food display
                                        Priestleys Gourmet Delights
                                    </h2>
                                    <p id="preview_advertising_text">Committed to providing the best tasting dessert   products to Australia and overseas.</p>
                                </div>
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