{{ content() }}

<div class="container">
    <div class="container_heading">
        <h2>Search in FAQ</h2>
    </div>
    <ul class="breadcrumb help_breadcrumb">
        <li><a href="/help">Help</a></li>
        <li><a href="/help/search/text">Search in FAQ</a></li>
    </ul>
    <hr>
    <div class="col-lg-4 col-md-4">
        {% include 'help/partials/navLeft.volt' %}
    </div>
    <div class="col-lg-8 col-md-8">

        <div class="help_search">
            {% include 'help/partials/searchForm.volt' %}
        </div>

        <span class="text-danger">{{ form.hasMessagesFor('query') ? form.getMessagesFor('query')[0] : '' }}</span>

        <div class="help_faq_box_content">

            {% if categories === false %}
                <span class="help_category">No search results</span>
            {% endif %}

            {% if categories %}
                {% for category in categories %}
                    <span class="help_category">{{ category.title }}</span>
                    {% for topic in category.topics %}
                        <div class="help_title">{{ topic.title }}</div>
                        <div class="help_content">{{ topic.content }}</div>
                    {% endfor %}
                {% endfor %}
            {% endif %}

        </div>

    </div>
</div>