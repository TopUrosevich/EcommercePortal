{% include 'companies/partials/header.volt' %}
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 left_widgets_box">
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h2>About</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                        {{ link_to("companies/about/"~company_id, "More", 'class':'more_link', 'id':'aboute_more_link') }}
                    </div>
                </div>
                <div class="row" id="short_desc">
                    <div class="col-lg-12">
                        <p class="about_widgets_txt">
                            {{ profile.short_description | striptags }}...
                        </p>
                    </div>
                </div>
                <div class="row" id="long_desc">
                    <div class="col-lg-12">
                        <p class="about_widgets_txt">
                            {{ profile.long_description | striptags }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2>Certificates</h2>
                    </div>
                </div>
                <div class="row certificates_widgets_txt">
                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-6">
                        <span>HACCP</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-7 col-xs-6">
                        <a href="#" class="red_txt">View Certificate</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-6">
                        <span>BRC</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-7 col-xs-6">
                        <a href="#" class="red_txt">View Certificate</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-6">
                        <span>SQF 2000</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-7 col-xs-6">
                        <a href="#" class="red_txt">View Certificate</a>
                    </div>
                </div>
            </div>
            <div class="widgets awards_widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2>Awards</h2>
                    </div>
                </div>
                <div class="row certificates_widgets_txt">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                        <p>
                            <span>1999</span>
                            <span>1st Place</span>
                            <span>AnnualProduce Awards</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h2>Photo’s</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                        {{ link_to("companies/"~create_alias(profile.title)~"/gallery/"~company_id, "More", 'class':'more_link') }}
                    </div>
                </div>
                <div class="row photos_widgets" id="images_box">
                    {% if galleries %}
                        {% for index, photo_name in galleries %}
                                    <div class="box photo col1">
                                        <a href="{{ bucketUrl }}/companies/{{ company_id }}/gallery/{{ photo_name }}" class="fancybox" data-fancybox-group="gallery" title="gallery photo">
                                            <img src="{{ bucketUrl }}/companies/{{ company_id }}/gallery/thumb_290x190_{{ photo_name }}" alt="widgets photo"/>
                                        </a>
                                    </div>
                            {% if index == 8 %}
                                {% break %}
                            {% endif %}
                        {% endfor %}
                    {% else %}
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src="/images/widgets_photo1.png" alt="widgets photo"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src="/images/widgets_photo2.png" alt="widgets photo"/>
                                </div>
                            </div>
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 center_widgets_box">
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2>Product List & Locations</h2>
                    </div>
                </div>
                {% if Products_Location %}
                    {% for index, product  in Products_Location %}
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="mb10">
                                    {{ product['pl_name'] }}
                                </p>
                                <div class="row">
                                    <div class="col-lg-9 col-lg-offset-2 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                        <p>{{ product['sa_street_address'] }}</p>
                                        <p>{{ product['sa_city'] }}, {{ product['sa_state'] }}</p>
                                        <p>{% if product['sa_country'] %} {{ product['sa_country'] }} , {% endif %} {{ product['sa_postcode'] }}</p>
                                    </div>
                                </div>
                                <div class="row mb15 mt20">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="glyph-icon flaticon-telephonesolid"></div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                        <a href="#" class="red_btn supplier_btn show_phone_number">Show Phone Number</a>
                                        <span style="display: none">{{ product['sa_country_code'] }}-{{ product['sa_area_code'] }}-{{ product['sa_phone'] }}</span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-lg-offset-2 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                        <a href="{{ product['pl_url'] }}" class="red_txt view_product_list">View Product List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                    {% else %}
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="mb10">
                                    Area Name
                                </p>
                                <div class="row">
                                    <div class="col-lg-9 col-lg-offset-2 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                        <p>Street Address</p>
                                        <p>City, State</p>
                                        <p>Country, Postal Code</p>
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
                                        <a href="#" class="red_txt view_product_list">View Product List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                {% endif %}
            </div>
            <div class="widgets photos_widgets" id="photo_first">
                {% if galleries %}
                    {% for index, photo_name in galleries  %}
                    {% if loop.first %}
                        <img src="{{ bucketUrl }}/companies/{{ company_id }}/gallery/thumb_290x190_{{ photo_name }}" alt="supplier"/>
                        {% break %}
                    {% endif %}
                    {% endfor %}
                {% else %}
                    <img src="/images/supplier_profile1.jpg" alt="supplier profile"/>
                {% endif %}

            </div>
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="pb30">Products & Services</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="product_widgets_txt">
                            {{ profile.keywords }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="pb30">Connected Companies</h2>
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
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 right_widgets_box">
            <div class="widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2>Head Office</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mb10">
                            {{ profile.address }}
                        </p>
                        <div class="row">
                            <div class="col-lg-9 col-lg-offset-2  col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-9 col-xs-offset-2">
                                <p>{{ profile.city }},</p>
                                <p>{{ profile.state }}</p>
                                <p>{% if profile.country  is defined %} {{ profile.country }}, {% endif %} {% if company.postcode  %} {{ company.postcode }} {% endif %}</p>
                            </div>
                        </div>
                        <div class="row mb15 mt20">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="glyph-icon flaticon-telephonesolid"></div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <a href="#" class="red_btn supplier_btn show_phone_number">Show Phone Number</a>
                                <span style="display: none">{{ company.country_code }}-{{ company.area_code }}-{{ company.phone }}</span>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="glyph-icon flaticon-pc"></div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <a href="#" class="red_btn supplier_btn show_web_site">Show Website</a>
                                {% if profile.web_site != '' %}
                                    <span style="display: none"><a href="{{ profile.web_site }}">{{ profile.web_site }}</a></span>
                                {% else %}
                                    <span style="display: none">Website missing</span>
                                {% endif %}
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="glyph-icon flaticon-envelopeback"></div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <span id="contact_supplier" class="red_btn supplier_btn">Contact Supplier</span>
                            </div>

                            <div  id="contactSupplier" style="display: none">
                                <div class="contact_supplier">
                                    <div class="content">
                                        <div class="header">
                                            <button type="button" class="close">
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </button>
                                        </div>
                                        <form action="/companies/contact-supplier" method="post">
                                            <div>
                                                {{ contactForm.render('company_id', ['value': company._id]) }}
                                                <div class="form-group">
                                                    {{ contactForm.render('name', ['class': 'form-control required', 'placeholder': 'Name']) }}
                                                    <span class="text-danger">
                                                    {{ contactForm.hasMessagesFor('name') ? contactForm.getMessagesFor('name')[0] : '' }}
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    {{ contactForm.render('email', ['class': 'form-control required', 'placeholder': 'Email']) }}
                                                    <span class="text-danger">{{ contactForm.hasMessagesFor('email') ? contactForm.getMessagesFor('email')[0] : '' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    {{ contactForm.render('message', ['class': 'form-control required', 'rows': 5, 'placeholder': 'Message']) }}
                                                    <span class="text-danger">
                                                    {{ contactForm.hasMessagesFor('message') ? contactForm.getMessagesFor('message')[0] : '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="primary_btn">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="widgets opening_hours_widgets">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="pb30">Opening Hours</h2>
                    </div>
                </div>
                <div class="row certificates_widgets_txt">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <span class="week_day">Monday</span>
                            <span>{{ profile.ho_mon_1 }} - {{ profile.ho_mon_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Tuesday</span>
                            <span>{{ profile.ho_tu_1 }} - {{ profile.ho_tu_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Wednesday</span>
                            <span>{{ profile.ho_wed_1 }} - {{ profile.ho_wed_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Thursday</span>
                            <span>{{ profile.ho_thu_1 }} - {{ profile.ho_thu_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Friday</span>
                            <span>{{ profile.ho_fri_1 }} - {{ profile.ho_fri_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Saturday</span>
                            <span>{{ profile.ho_sat_1 }} - {{ profile.ho_sat_2 }}</span>
                        </p>
                        <p>
                            <span class="week_day">Sunday</span>
                            <span>{{ profile.ho_sun_1 }} - {{ profile.ho_sun_2 }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="widgets photos_widgets" id="photo_last">
                {% if galleries %}
                    {% for index, photo_name in galleries  %}
                        {% if loop.last %}
                            <img src="{{ bucketUrl }}/companies/{{ company_id }}/gallery/thumb_290x190_{{ photo_name }}" alt="supplier"/>
                        {% endif %}
                    {% endfor %}
                {% else %}
                    <img src="/images/supplier_profile2.jpg" alt="supplier profile"/>
                {% endif %}
            </div>
            <input type="hidden" name="c_profilesId" id="c_profilesId" value="{{ company.profilesId }}">
            <input type="hidden" name="c_business_type" id="c_business_type" value="{{ company.business_type }}">
            <div class="widgets" id="data_similar_companies">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="pb30">similar companies</h2>
                    </div>
                </div>

                {% if similarCompanies %}
                    {% for sCompany in similarCompanies %}
                        <div class="row similarCompanies_line">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                {% if sCompany['user']['logo'] %}
                                    <img src="{{ sCompany['user']['logo'] }}" alt="companies icon" />
                                {% else %}
                                    <img src="/images/no_logo.gif" alt="companies icon" />
                                {% endif %}

                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <p>{{ sCompany['profile']['title'] }}</p>
                                {% set profile_title = sCompany['profile']['title'] %}
                                {#<a href="/companies/{{ profile_title }} /{{ sCompany['user']['_id'] }}" class="view_list red_txt"> View Profile</a>#}
                                <a href="/companies/{{ create_alias(profile_title) }}/{{ sCompany['user']['_id'] }}" class="view_list red_txt"> View Profile</a>
                            </div>
                        </div>
                    {% endfor %}
                {% else %}
                    Nothing...
                {% endif %}

                <div class="row similarCompanies_line">
                    <div class="col-lg-8 col-lg-offset-3 col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3" id="div_similar_more_ln">
                        <a href="#" class="show_more red_txt" id="similar_more_ln">+ Show more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>