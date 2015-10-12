{{ content() }}
<div class="user_profile_box search_page_box">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                {% include 'search/partials/headerBanner.volt' %}
                {% include 'search/partials/simpleSearch.volt' %}
                {% include 'search/partials/advancedSearch.volt' %}
                <div class="row user_search_box">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt20">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="search_company_box">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="red_txt">New Companies in Your Area</h2>
                                        </div>
                                    </div>
                                    <div class="company_preivew_box">
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
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                            <a href="#" class="show_more red_txt">+ Show More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {% include 'search/partials/rightSide.volt' %}
        </div>
    </div>
</div>
