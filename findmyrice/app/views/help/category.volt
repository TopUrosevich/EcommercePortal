{{ content() }}

<div class="container">
    <div class="help_container">
        <div class="container_heading">
            <h2>{{ category.title }}</h2>
        </div>
        <ul class="breadcrumb help_breadcrumb">
            <li><a href="/help">Help</a></li>
            <li><a href="/help/{{ category.alias }}">{{ category.title }}</a> </li>
        </ul>

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 top_faq">
            <div class="help_faq_box">
                <span class="help_category">{{ category.title }}</span>
                <div class="help_nav_faq">
                    <ul>
                        {% for item in topics %}
                            <li><a href="/help/{{ category.alias }}#{{item.alias }}">{{ item.title }}</a></li>
                        {% endfor %}
                    </ul>
                </div>
            </div>
            <hr>
            <div class="help_faq_box_content">
                <span class="help_category">{{ category.title }}</span>
                {% for item in topics %}
                    <div class="help_title" id="{{ item.alias }}">{{ item.title }}</div>
                    <div class="help_content">{{ item.content }}</div>
                {% endfor %}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            {% include 'help/partials/navLeft.volt' %}
        </div>
    </div>
</div>
