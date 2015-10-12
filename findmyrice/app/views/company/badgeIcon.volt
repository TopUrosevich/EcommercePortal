{{ content() }}
<div class="container wallaper profile_box">
    <div class="row title_my_account">
        <div class="col-lg-7 col-lg-offset-2 col-md-7 col-md-offset-2 col-xs-7"><h2>Badges & Icons</h2></div>
        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 text-right back_my_account">{{ link_to('company', 'Back to My Account page') }}</div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Promote your profile by adding a badge or icon to your website, email or blog
                </div>
            </div>
            <div class="copy_box">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb15">
                                Choose a badge or Icon
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a href="#"><img src="/images/badges_small.png" alt="badges_small" class="badges_img"/> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a href="#"><img src="/images/badges_medium.png" alt="badges_medium" class="badges_img"/> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <a href="#"><img src="/images/badges_big.png" alt="badges_big" class="badges_img"/> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a href="#"><img src="/images/icon1.png" alt="badges_big" class="badges_img"/> </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a href="#"><img src="/images/icon2.png" alt="badges_big" class="badges_img"/> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a href="#"><img src="/images/icon3.png" alt="badges_big" class="badges_img"/> </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a href="#"><img src="/images/icon4.png" alt="badges_big" class="badges_img"/> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb15">
                                Copy your profile link
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {{ text_field('preview-profile', 'class':'form-control','value':siteUrl ~'/companies/'~user_id, 'placeholder':siteUrl ~'/companies/'~user_id) }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>