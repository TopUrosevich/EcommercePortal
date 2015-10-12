{{ content() }}

<div class="container" id="scroll_top">
    <div class="products_container">
        <div class="products_search">
            {#{% include 'products/partials/formSearch.volt' %}#}
            {#{% include 'products/partials/formFilter.volt' %}#}
        </div>
        {% if all_data %}
            {% for index, data in all_data %}
                {% if data['products'] %}
                    {% for  index_p, product in data['products'] %}
                        {%  if  product['pl_url']  %}
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="mb10">
                                        {{ product['pl_name'] }}
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-9 col-lg-offset-2 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                            <p>{{ product['sa_street_address'] }}</p>
                                            <p>{{ product['sa_city'] }}, {{ product['sa_state'] }}</p>
                                            <p>{{ product['sa_country'] }}, {{ product['sa_postcode'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row mb15 mt20">
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                            <div class="glyph-icon flaticon-telephonesolid"></div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                            <a href="#" class="red_btn supplier_btn">Show Phone Number</a>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-9 col-lg-offset-2 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                            <a href="{{ product['pl_url'] }}" class="red_txt view_product_list">View Product List</a>
                                            <a href="companies/{{ data['company']['_id'] }}" class="red_txt view_product_list">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endif %}
                    {% endfor %}

                {% else %}

                {% endif %}

            {% endfor %}
        {% else %}
            <div class="products-list-wrapper">
                <div class="products-list-image">
                    <a href="http://findmyrice.com/company/2318/">
                        <img width="140" height="140" src="http://findmyrice.com/wp-content/uploads/2014/10/Bidvest-Logo-140x140.jpg" class="attachment-140x140 wp-post-image" alt="Bidvest Logo">
                    </a>
                </div>
                <div class="products-list-right">
                    <div class="products-list-title">
                        <a href="http://findmyrice.com/company/2318/">
                            Bidvest
                        </a>
                    </div>
                    <div class="products-list-content"> <p></p>
                        <p>12 Liberty Street, PORTSMITH, QLD, Australia</p>
                    </div>
                    <div class="help-number">
                        <p>07 4035 0400</p>
                    </div>
                    <div class="download-pdf-list">
                        <i class="fa fa-file-pdf-o"></i>
                        <a href="" target="_blank" title="Product List">Product List </a>
                    </div>
                    <div class="view_profile_link">
                        <a href="http://findmyrice.com/company/2318/" target="_blank" title="View Profile">View Profile </a>
                    </div>

                </div>
            </div>
        {% endif %}


    </div>
</div>