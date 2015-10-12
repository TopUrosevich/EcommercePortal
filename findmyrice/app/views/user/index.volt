{{ content() }}
<div class="user_profile_box">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8">
                {% include 'user/partials/headerBanner.volt' %}
                {% include 'user/partials/headerMenu.volt' %}
                {% include 'user/partials/simpleSearch.volt' %}
                {% include 'user/partials/advancedSearch.volt' %}
                <div class="row mt10">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="new_company_box">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h2 class="red_txt mt10 mb10">New Companies in Your Area</h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                                        {% if page %}
                                            {%  for index, item in page.items %}
                                                {% if ( ( index + 1 ) % 4 ) == 0  %}
                                                    <div class="row">
                                                {% endif %}
                                                <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <div class="company_img_box">
                                                        <a href="/companies/{{ item['_source']['user_id'] }}" class="red_txt">
                                                            <img src="{{ item['_source']['logo'] }}" class="logo_company" alt="logo anzco" />
                                                        </a>
                                                    </div>
                                                </div>
                                                {% if ( ( index + 1 ) % 4 ) == 0  %}
                                                    </div>
                                                {% endif %}
                                            {%  endfor %}
                                        {% endif %}
                                </div>
                            </div>
                            <div class="text-center mt20">
                                <a href="#" class="red_txt show_more_txt">+ Show More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt10">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="new_company_box">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h2 class="red_txt mt10 mb10">Inspiration</h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                    <div id="images_box" class="clearfix">
                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration1.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration1.png" alt="Inspiration photo" /></a>
                                        </div>

                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration2.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration2.png" alt="Inspiration photo" /></a>
                                        </div>

                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration3.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration3.png" alt="Inspiration photo" /></a>
                                        </div>

                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration4.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration4.png" alt="Inspiration photo" /></a>
                                        </div>

                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration5.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration5.png" alt="Inspiration photo" /></a>
                                        </div>
s
                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration6.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration6.png" alt="Inspiration photo" /></a>
                                        </div>

                                        <div class="box photo inspiration_images">
                                            <a href="/images/inspiration7.png" class="fancybox" data-fancybox-group="gallery" title="Inspiration photo"><img src="/images/inspiration7.png"   alt="Inspiration photo" /></a>
                                        </div>
                                    </div> <!-- #images_box -->
                                </div>
                            </div>
                            <div class="text-center mt20">
                                <a href="#" class="red_txt show_more_txt">+ Show More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {% include 'user/partials/rightBanner.volt' %}
        </div>
    </div>
</div>