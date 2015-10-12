{{ content() }}
{% set activeAllTab = "" %}
{% set activeProductsTab = "" %}
{% set activeCompaniesTab = "" %}
{%  if not(url_params["companies_only"] is defined) and not(url_params["products_only"] is defined) %}
    {% set activeAllTab = "active" %}
{%  elseif url_params["companies_only"] is defined %}
    {% set activeCompaniesTab = "active" %}
{% elseif url_params["products_only"] is defined %}
    {% set activeProductsTab = "active" %}
{% else %}
    {% set activeAllTab = "active" %}
{% endif %}
<div class="user_profile_box search_page_box">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                {% include 'search/partials/headerBanner.volt' %}
                {% include 'search/partials/simpleSearch.volt' %}
                {% include 'search/partials/advancedSearch.volt' %}
                <div class="row">
                    {% if leftSide %}
                        {% include 'search/partials/leftSide.volt' %}
                        <div class="col-lg-9 col-md-9 col-sm-8 company_searchBox_widgets">
                        {% else %}
                        <div class="col-lg-12 col-md-12 col-sm-12 company_searchBox_widgets">
                    {% endif %}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="search_results_box">
                                    {%  if not(url_params["companies_only"] is defined) %}
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2>Products that match your search results</h2>
                                        </div>
                                    </div>
                                    {% endif %}
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <ul class="result_list text-right">
                                                <li><a href="/search" class="{{ activeAllTab }}">All Listings</a></li>
                                                <li><a href="/search?products_only=yes" class="{{ activeProductsTab }}">Products Only</a></li>
                                                <li><a href="/search?companies_only=yes" class="{{ activeCompaniesTab }}">Companies Only</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    {%  if not(url_params["companies_only"] is defined) %}
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <span>{{ count_products }} Products match your results</span>
                                        </div>
                                    </div>
                                    {% endif %}
                                </div>
                            </div>
                        </div>
                        {%  if not(url_params["companies_only"] is defined) %}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="search_table">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th># Results</th>
                                            <th>Location</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {% if companies_allData %}
                                            {% if companies_allData['plsa'] is defined %}
                                                {% set even_odd = 1 %}
                                            {%  for index_plsa, plsa_item in companies_allData['plsa'] %}

                                                {% if plsa_item["totalProducts"] is defined %}
                                                    {% set item_totalProducts = plsa_item["totalProducts"] %}
                                                {% else %}
                                                    {% set item_totalProducts = 0 %}
                                                {% endif %}

                                                {% if even_odd is odd %}
                                                    {% set tr_class = "odd" %}
                                                {% else %}
                                                    {% set tr_class = "even" %}
                                                {% endif %}
                                                {% set even_odd = even_odd + 1 %}

                                                {%  for index_plsa2, plsa_item2 in plsa_item %}

                                                    {% if (index_plsa2 !== "totalProducts") %}
                                                        <tr class="{{ tr_class }}">
                                                            {% if plsa_item2['_source']['c_title'] is defined %}
                                                                <td> {{ plsa_item2['_source']['c_title'] }}</td>
                                                            {% else %}
                                                                <td></td>
                                                            {% endif %}
                                                            <td>
                                                                <span id="count_{{ plsa_item2['_source']['user_id'] }}">{{ item_totalProducts }}</span> <a href="/companies/{{ plsa_item2['_source']['user_id'] }}" class="red_txt view_products" data-companyId="{{ plsa_item2['_source']['user_id'] }}">View</a></td>
                                                            {% if plsa_item2['_source']['sa_city'] is defined %}
                                                                <td>{{ plsa_item2['_source']['sa_city'] }}, {{ plsa_item2['_source']['sa_state'] }}</td>
                                                            {% else %}
                                                                <td></td>
                                                            {% endif %}
                                                        </tr>
                                                        {% break %}
                                                    {% endif %}
                                                {%  endfor %}
                                            {%  endfor %}
                                                {% endif %}
                                        {% else %}
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        {% endif %}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {% endif %}
                        {%  if not(url_params["products_only"] is defined) %}
                        <div class="search_results_box">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb10">
                                    <h2>Companies that match your search results</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    {% if count_companies !== 0 %}
                                        <span>Showing 1 to {{ count_companies }} of {{ count_companies }} results</span>
                                    {% else %}
                                        <span>0 Companies match your results</span>
                                    {% endif %}
                                </div>
                            </div>
                        </div>
                        <div class="company_preivew_box">
                                {% if companies_allData %}
                                    {%  for index, item in companies_allData['companies'] %}
                                        {% if ( ( index + 1 ) % 3 ) == 0  %}
                                            <div class="row">
                                        {% endif %}
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="company_preview">
                                                    {% if item['_source']['premium'] is defined %}
                                                        <span class="premium_txt">Premium</span>
                                                        <div class="company_img_box">
                                                            <img src="{{ item['_source']['logo'] }}" class="logo_company" alt="logo anzco" />
                                                        </div>
                                                    {% endif %}
                                                    <h3>{{ item['_source']['title'] }}</h3>
                                                    <h4>{{ item['_source']['business_type'] }}</h4>
                                                    <p>{{ item['_source']['city'] }}, {{ item['_source']['country'] }}</p>
                                                    <a href="/companies/{{ item['_source']['user_id'] }}" class="red_txt">View Profile</a>
                                                </div>
                                            </div>
                                        {% if ( ( index + 1 ) % 3 ) == 0  %}
                                            </div>
                                        {% endif %}
                                    {%  endfor %}
                                {% endif %}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                    <div><a href="#" class="red_txt more_link">+More</a></div>
                                </div>
                            </div>
                        </div>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% include 'search/partials/rightSide.volt' %}
        </div>
    </div>
</div>
