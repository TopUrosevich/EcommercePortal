<div class="col-lg-3 col-md-3 col-sm-4 user_widgets_box">
    <div class="ads_user_box">
        <div class="row mb20">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <img src="/images/ads_user1.png" alt="ads user"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb20">
                <img src="/images/ads_user2.png" alt="ads user"/>
            </div>
        </div>
    </div>
    <div class="widgets">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="pb20 mt10">Recent Searches</h2>
            </div>
        </div>
        <div class="row similarCompanies_line">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="/images/companies_icon.png" alt="companies icon" />
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <p>Bondi Chai Late</p>
                <a href="#" class="view_list red_txt"> View Profile</a>
            </div>
        </div>
        <div class="row similarCompanies_line">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="/images/companies_icon.png" alt="companies icon" />
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <p>Bondi Chai Late</p>
                <a href="#" class="view_list red_txt"> View Profile</a>
            </div>
        </div>
        <div class="row similarCompanies_line">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="/images/companies_icon.png" alt="companies icon" />
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <p>Bondi Chai Late</p>
                <a href="#" class="view_list red_txt"> View Profile</a>
            </div>
        </div>
        <div class="row similarCompanies_line">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="/images/companies_icon.png" alt="companies icon" />
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <p>Bondi Chai Late</p>
                <a href="#" class="view_list red_txt"> View Profile</a>
            </div>
        </div>
        <div class="row similarCompanies_line">
            <div class="col-lg-8 col-lg-offset-3 col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3">
                <a href="#" class="show_more red_txt">+ Show more</a>
            </div>
        </div>
    </div>
    <div class="widgets">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="pb20 mt10">Favourite Supplier</h2>
            </div>
        </div>
        {% if favourite_company_data %}
            {% for index, favourite_company in favourite_company_data %}
                <div class="row similarCompanies_line">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <img src="{{ favourite_company['company']['logo'] }}" alt="companies icon" />
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <p>{{ favourite_company['profile']['title'] }}</p>
                        <a href="/companies/{{ favourite_company['profile']['title'] }}/{{ favourite_company['company']['_id'] }}" class="view_list red_txt"> View Profile</a>
                    </div>
                </div>
            {% endfor %}
        {% else %}
            <div class="row similarCompanies_line">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <img src="/images/companies_icon.png" alt="companies icon" />
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <p>Nothing</p>
                    <a href="#" class="view_list red_txt"> View Profile</a>
                </div>
            </div>
        {% endif %}
        <div class="row similarCompanies_line">
            <div class="col-lg-8 col-lg-offset-3 col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3">
                <a href="#" class="show_more red_txt">+ Show more</a>
            </div>
        </div>
    </div>
</div>