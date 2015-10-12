{{ content() }}

<div class="container" id="scroll_top">
    <div class="events_container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="/images/banner_userprofile.png" alt="user profile" class="banner_profile"/>
                    </div>
                </div>
                <div class="events_search">
                    {% include 'events/partials/formSearch.volt' %}
                    {% include 'events/partials/formFilter.volt' %}
                    {% include 'events/partials/formSorting.volt' %}

                </div>
                <div class="row" id="data_events">
                    {% for event in page.items %}
                        {% set category = event.getCategory() %}
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="events_preview">
                                <a href="/events/{{ category.alias }}/{{ event._id }}">
                                    <div class="events_preview_top">

                                        <div class="venue">
                                            {{ event.event_name }}
                                        </div>

                                        <div class="date">
                                            {{ date('d', event.start_date) }} - {{ date('d M Y', event.end_date) }}
                                        </div>
                                        <div class="location">{{ event.city }}, {{ event.country }}</div>
                                        <div class="category">{{ category.title }}</div>
                                        <div class="description">{{ mb_substr(event.description | striptags, 0, 110) }}...</div>
                                    </div>
                                </a>
                                <div class="events_preview_bootom">
                                    <a href="/events/{{ category.alias }}/{{ event._id }}">
                                        <button type="button" class="primary_btn">View Details</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <div class="events_pagination">
                            {% if events_count > 21 %}
                                <a href="{{ router.getRewriteUri() }}" id="more_ln">More+</a>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 left_events_box">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="ads_user_outer">
                            <img src="/images/ads_user1.png" alt="ads user" class="mb20"/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 feature_events_box">
                        <div class="container_heading feature_events text-center">
                            <span>Featured Events</span>
                        </div>
                        {% for event in featuredEvents %}
                            <div class="col-lg-12 col-md-12 col-sm-6">
                                <a href="/events/{{ category.alias }}/{{ event._id }}">
                                    <div class="events_preview left_events_preview">
                                        {% set category = event.getCategory() %}
                                        {% if event.image_preview %}
                                            <img src="{{ event.image_preview }}">
                                        {% else %}
                                            <img src="/images/events/default-preview.jpg">
                                        {% endif %}
                                        <div class="venue">
                                            {{ event.event_name }}
                                        </div>
                                        {#<div class="venue">{{ event.event_name }}</div>#}
                                        <div class="date">
                                            {{ date('d', event.start_date) }} - {{ date('d M Y', event.end_date) }}
                                        </div>
                                        <div class="location">{{ event.city }}, {{ event.country }}</div>
                                        <div class="category">{{ category.title }}</div>
                                        <div class="explore">
                                            <p class="red_txt">Explore Event</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>