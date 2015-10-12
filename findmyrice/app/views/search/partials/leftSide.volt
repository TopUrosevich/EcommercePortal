<div class="col-lg-3 col-md-3 col-sm-4">
    <div class="left_sidebar">
        <div class="search_widgets_box">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {% if (not(categoriesData["terms"] is empty))  %}
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>Categories</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets">

                            {% for index_categories, categories in categoriesData %}
                                {% if index_categories == "total" %}
                                    {% set totalCategories = categories %}
                                {% endif %}
                                {% if index_categories == "terms" %}
                                    {% for item_index_category, item_category in categories %}
                                        <a href="#" class="lf_filter" data-index="{{ item_category["term"] }}" data-type="lf_category">
                                            {% if url_params["lf_category"] is defined %}
                                                    {% for index_item_url, item_url in url_params %}
                                                        {% if index_item_url == "lf_category" %}
                                                            <?php
                                                             if (strpos($item_url,$item_category["term"]) !== false) { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                            <?php } else { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                            <?php } ?>
                                                            {% break %}
                                                        {% endif %}
                                                    {% endfor %}
                                            {% else %}
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                            {% endif %}
                                            {{ item_category["term"]|capitalize }} ({{ item_category["count"] }})
                                        </a>
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                    </div>
                    {% endif %}

                    {% if (not(stateData["terms"] is empty))  %}
                    <div class="widgets_line"></div>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>State</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets">
                            {% for index_states, states in stateData %}
                                {% if index_states == "total" %}
                                    {% set totalStates = states %}
                                {% endif %}
                                {% if index_states == "terms" %}
                                    {% for item_index_state, item_state in states %}
                                        <a href="#" class="lf_filter" data-index="{{ item_state["term"] }}" data-type="lf_state">
                                            {% if url_params["lf_state"] is defined %}
                                                {% for index_item_url, item_url in url_params %}
                                                    {% if index_item_url == "lf_state" %}
                                                        <?php
                                                        if (strpos($item_url,$item_state["term"]) !== false) { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                        <?php } else { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                        <?php } ?>
                                                        {% break %}
                                                    {% endif %}
                                                {% endfor %}
                                            {% else %}
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                            {% endif %}
                                            {{ item_state["term"]|capitalize }} ({{ item_state["count"] }})
                                        </a>
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                    </div>
                    {% endif %}
                    {% if (not(cityData["terms"] is empty))  %}
                    <div class="widgets_line"></div>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>City</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets">

                            {% for index_cities, cities in cityData %}
                                {% if index_cities == "total" %}
                                    {% set totalCities = cities %}
                                {% endif %}
                                {% if index_cities == "terms" %}
                                    {% for item_index_city, item_city in cities %}
                                        <a href="#" class="lf_filter" data-index="{{ item_city["term"] }}" data-type="lf_city">
                                            {% if url_params["lf_city"] is defined %}
                                                {% for index_item_url, item_url in url_params %}
                                                    {% if index_item_url == "lf_city" %}
                                                        <?php
                                                        if (strpos($item_url,$item_city["term"]) !== false) { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                        <?php } else { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                        <?php } ?>
                                                        {% break %}
                                                    {% endif %}
                                                {% endfor %}
                                            {% else %}
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                            {% endif %}
                                            {{ item_city["term"]|capitalize }} ({{ item_city["count"] }})
                                        </a>
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                    </div>
                    {% endif %}

                    {% if (not(keywordsData["terms"] is empty))  %}
                    <div class="widgets_line"></div>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>Keywords</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets">

                            {% for index_keywords, keywords in keywordsData %}
                                {% if index_keywords == "total" %}
                                    {% set totalKeywords = keywords %}
                                {% endif %}
                                {% if index_keywords == "terms" %}
                                    {% for item_index_keyword, item_keyword in keywords %}
                                        <a href="#" class="lf_filter" data-index="{{ item_keyword["term"] }}" data-type="lf_keywords">
                                            {% if url_params["lf_keywords"] is defined %}
                                                {% for index_item_url, item_url in url_params %}
                                                    {% if index_item_url == "lf_keywords" %}
                                                        <?php
                                                        if (strpos($item_url,$item_keyword["term"]) !== false) { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                        <?php } else { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                        <?php } ?>
                                                        {% break %}
                                                    {% endif %}
                                                {% endfor %}
                                            {% else %}
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                            {% endif %}
                                            {{ item_keyword["term"]|capitalize }} ({{ item_keyword["count"] }})
                                        </a>
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                    </div>
                    {% endif %}

                    {% if (not(businessTypeData["terms"] is empty))  %}
                    <div class="widgets_line"></div>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>Business Type</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets business_widgets">


                            {% for index_businessTypes, businessTypes in businessTypeData %}
                                {% if index_businessTypes == "total" %}
                                    {% set totalBusinessTypes = businessTypes %}
                                {% endif %}
                                {% if index_businessTypes == "terms" %}
                                    {% for item_index_businessType, item_businessType in businessTypes %}
                                        <a href="#" class="lf_filter" data-index="{{ item_businessType["term"] }}" data-type="lf_business_type">
                                            {% if url_params["lf_business_type"] is defined %}
                                                {% for index_item_url, item_url in url_params %}
                                                    {% if index_item_url == "lf_business_type" %}
                                                        <?php
                                                        if (strpos($item_url,$item_businessType["term"]) !== false) { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                        <?php } else { ?>
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                        <?php } ?>
                                                        {% break %}
                                                    {% endif %}
                                                {% endfor %}
                                            {% else %}
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                            {% endif %}
                                            {{ item_businessType["term"]|capitalize }} ({{ item_businessType["count"] }})
                                        </a>
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                    </div>
                    {% endif %}
                    <div class="row mt20">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                            <h2>Show Only</h2>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 see_all_box">
                            <a href="#" class="see_all_txt">see all</a>
                        </div>
                    </div>
                    <div class="search_widgets business_widgets">
                        {% if premiumData %}
                            {% for index_premiums, premiums in premiumData %}
                                {% if index_premiums == "total" %}
                                    {% set totalPremiums = premiums %}
                                {% endif %}
                                {% if index_premiums == "terms" %}
                                    {% for item_index_premium, item_premium in premiums %}
                                        {%  if item_premium["term"] == "yes" %}
                                        <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="{{ item_premium["term"] }}" data-type="premium">
                                                {% if url_params["premium"] is defined %}
                                                    {% for index_item_url, item_url in url_params %}
                                                        {% if index_item_url == "premium" %}
                                                            <?php
                                                        if (strpos($item_url,$item_premium["term"]) !== false) { ?>
                                                            <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                            <?php } else { ?>
                                                            <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                            <?php } ?>
                                                            {% break %}
                                                        {% endif %}
                                                    {% endfor %}
                                                {% else %}
                                                    <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                {% endif %}
                                                Premium ({{ item_premium["count"] }})</a>
                                        </div>
                                            {% endif %}
                                    {% endfor %}
                                {% endif %}
                            {% endfor %}
                        {% else %}
                            <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="yes" data-type="premium">
                                    {% if url_params["premium"] is defined %}
                                        {% for index_item_url, item_url in url_params %}
                                            {% if index_item_url == "premium" %}
                                                <?php
                                                        if (strpos($item_url,"yes") !== false) { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                <?php } else { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                <?php } ?>
                                                {% break %}
                                            {% endif %}
                                        {% endfor %}
                                    {% else %}
                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                    {% endif %}
                                    Premium
                                </a>
                            </div>
                        {% endif %}

                        {% if importerData %}
                            {% for index_importers, importers in importerData %}
                                {% if index_importers == "total" %}
                                    {% set totalImporter = importers %}
                                {% endif %}
                                {% if index_importers == "terms" %}
                                        {% for item_index_importer, item_importer in importers %}
                                            {%  if item_importer["term"] == "yes" %}
                                            <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="{{ item_importer["term"] }}" data-type="importers">
                                                    {% if url_params["importers"] is defined %}
                                                        {% for index_item_url, item_url in url_params %}
                                                            {% if index_item_url == "importers" %}
                                                                <?php
                                                                if (strpos($item_url,$item_importer["term"]) !== false) { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                                <?php } else { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                                <?php } ?>
                                                                {% break %}
                                                            {% endif %}
                                                        {% endfor %}
                                                    {% else %}
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                    {% endif %}
                                                    Importer ({{ item_importer["count"] }})
                                                </a>
                                            </div>
                                            {% endif %}
                                        {% endfor %}
                                {% endif %}
                            {% endfor %}
                        {% else %}
                            <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="yes" data-type="importers">
                                    {% if url_params["importers"] is defined %}
                                        {% for index_item_url, item_url in url_params %}
                                            {% if index_item_url == "importers" %}
                                                <?php
                                                if (strpos($item_url,"yes") !== false) { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                <?php } else { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                <?php } ?>
                                                {% break %}
                                            {% endif %}
                                        {% endfor %}
                                    {% else %}
                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                    {% endif %}
                                    Importer
                                </a>
                            </div>
                        {% endif %}

                        {% if exporterData %}
                            {% for index_exporters, exporters in exporterData %}
                                {% if index_exporters == "total" %}
                                    {% set totalExporters = exporters %}
                                {% endif %}
                                {% if index_exporters == "terms" %}
                                        {% for item_index_exporter, item_exporter in exporters %}
                                            {%  if item_exporter["term"] == "yes" %}
                                            <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="{{ item_exporter["term"] }}" data-type="exporters">
                                                    {% if url_params["exporters"] is defined %}
                                                        {% for index_item_url, item_url in url_params %}
                                                            {% if index_item_url == "exporters" %}
                                                                <?php
                                                        if (strpos($item_url,$item_exporter["term"]) !== false) { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                                <?php } else { ?>
                                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                                <?php } ?>
                                                                {% break %}
                                                            {% endif %}
                                                        {% endfor %}
                                                    {% else %}
                                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                    {% endif %}
                                                    Exporter ({{ item_exporter["count"] }})
                                                </a>
                                            </div>
                                            {% endif %}
                                        {% endfor %}
                                {% endif %}
                            {% endfor %}
                        {% else %}
                            <div class="flaticon-ringbutton2"><a href="#" class="lf_filter" data-index="yes" data-type="exporters">
                                    {% if url_params["exporters"] is defined %}
                                        {% for index_item_url, item_url in url_params %}
                                            {% if index_item_url == "exporters" %}
                                                <?php
                                                        if (strpos($item_url,"yes") !== false) { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_selected.png">
                                                <?php } else { ?>
                                                <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                                <?php } ?>
                                                {% break %}
                                            {% endif %}
                                        {% endfor %}
                                    {% else %}
                                        <img height="11" width="11" border="0" align="bottom" src="/images/checkbox_unselected.png">
                                    {% endif %}
                                    Exporter
                                </a>
                            </div>
                        {% endif %}
                    </div>
                    <div class="row mt20">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2>More refinements...</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>