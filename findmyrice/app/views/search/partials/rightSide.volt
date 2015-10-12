<div class="col-lg-2 col-md-2 col-sm-12 user_widgets_box ads_user_box">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
            <img src="/images/ads_user.png" alt="ads user" class="mb20"/>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12 search_ads_middle">
            <h2>Featured Suppliers</h2>
            {%  if featuredCompanies %}
                {% for index, featuredCompany in featuredCompanies %}
                    <div class="company_preview_ads">
                        {% if featuredCompany['profile']['_source']['premium'] is defined %}
                            <span class="premium_txt">Premium</span>
                        {% endif %}
                        <div class="company_img_box">
                            <img src="{{ featuredCompany['_source']['logo'] }}" class="logo_company" alt="logo anzco" />
                        </div>
                        <h3>{{ featuredCompany['_source']['title'] }}</h3>
                        <h4>{{ featuredCompany['_source']['business_type'] }}</h4>
                        <p>{{ featuredCompany['_source']['city'] }}, {{ featuredCompany['_source']['country'] }}</p>
                        <a href="companies/{{ featuredCompany['_source']['user_id'] }}" class="red_txt">View Profile</a>
                    </div>
                {% endfor %}
            {% endif %}
        </div>
        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12 search_ads_right">
            <div class="row">
                <div class="col-lg-12">
                    <img src="/images/ads_user4.png" alt="ads user"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <img src="/images/ads_user3.png" alt="ads user"/>
                </div>
            </div>
        </div>
    </div>
</div>