{{ content() }}

<div class="container">
    <div class="help_container">
        <div class="container_heading">
            <h2>General FAQ</h2>
        </div>
        <ul class="breadcrumb help_breadcrumb">
            <li><a href="/help">Help</a></li>
            <li><a href="/help/general/faq">General FAQ</a> </li>
        </ul>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 top_faq">
            <div class="help_faq_box">
                {% for category in categories %}
                    <span class="help_category">{{ category.title }}</span>
                    <div class="help_nav_faq">
                        <ul>
                            {% for item in category.getTopics() %}
                                <li><a href="/help/general/faq#{{item.alias }}">{{ item.title }}</a></li>
                            {% endfor %}
                        </ul>
                    </div>
                {% endfor %}
            </div>
            <hr>
            <div class="help_faq_box_content">
                {% for category in categories %}

                    <span class="help_category">{{ category.title }}</span>

                    {% for item in category.getTopics() %}

                        <div class="help_title" id="{{ item.alias }}">{{ item.title }}</div>
                        <div class="help_content">{{ item.content }}</div>

                    {% endfor %}

                {% endfor %}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            {% include 'help/partials/navLeft.volt' %}
        </div>

    </div>
</div>