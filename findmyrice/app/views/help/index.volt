{{ content() }}
<div class="container">
    <div class="help_container">
        <div class="container_heading">
            <h2>Find My Rice Support</h2>
            <span>Read our frequently asked questions for last answers</span>
        </div>
        <hr>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 top_faq">
                <div class="help_search row">
                    {% include 'help/partials/searchForm.volt' %}
                </div>
                <span>Top FAQ's</span>
                <div class="help_nav_faq">
                    <ul>
                        {% for topic in topFaqTopics %}
                            <li>
                                <a href="/help/{{ topic.getCategory().alias }}#{{ topic.alias }}">
                                    {{ topic.title }}
                                </a>
                            </li>
                        {% endfor %}
                    </ul>
                </div>
                <a href="/help/general/faq">
                    <button class="primary_btn">View All FAQ's</button>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                {% include 'help/partials/navLeft.volt' %}
            </div>
        </div>
</div>