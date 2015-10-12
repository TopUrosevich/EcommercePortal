{{ content() }}

<div class="container">
    <div class="news_container">
        <div class="col-lg-9 col-md-9">
            <div class="row news_banner_top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <img src="/img/news-banner-top.jpg" alt="banner">
                </div>
            </div>
            {% include 'blog/partials/navTop.volt' %}
            {% include 'blog/partials/formSearch.volt' %}
            {#<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
                    <div class="container_heading text-center">
                        <h3>Feature Stories</h3>
                    </div>
                </div>
            </div>#}
            <div class="row news_box">
                    {#{% for feature in featureStories %}#}
                        {#<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 feature_stories">#}
                    {#<div class="news_top_small_item news_preview">#}
                        {#<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">#}
                            {#<a href="/blog/{{ feature.getCategory().alias }}/{{ feature.alias }}">#}
                                {#<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">#}
                                    {#<img src="{{ feature.images['h_120'] }}" alt="">#}
                                {#</div>#}
                                {#<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">#}
                                    {#<span>{{ feature.title }}</span>#}
                                {#</div>#}
                            {#</a>#}
                        {#</div>#}

                        {#<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">#}
                            {#<div class="content">#}
                                {#{{ mb_substr(feature.content | striptags, 0, 45) }}...#}
                            {#</div>#}
                        {#</div>#}
                    {#</div>#}
                {#</div>#}
                    {#{% endfor %}#}
                {% for topArticle in topArticles %}
                    {% if loop.first %}
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="news_top_big_item news_preview recent_news">
                                <a href="/blog/{{ topArticle.getCategory().alias }}/{{ topArticle.alias }}">
                                    <img src="{{ topArticle.image }}" alt="">
                                    <h2>{{ topArticle.title }}</h2>
                                </a>
                                <div class="content">
                                    {{ mb_substr(topArticle.content | striptags, 0, 350) }}...
                                </div>
                            </div>
                        </div>
                        {% break %}
                    {% else %}
                    {% endif %}
                {% endfor %}
            </div>
            {% for topArticle in topArticles %}
                {% if loop.first %}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <a href="/blog/{{ topArticle.getCategory().alias }}/{{ topArticle.alias }}" class="red_txt pr15">More+</a>
                        </div>
                    </div>
                    {% break %}
                {% endif %}
            {% endfor %}

            <div class="row news_box" id="data_blogs">
                        {% for article in page.items %}
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="news_preview">
                                    <a href="/blog/{{ article.getCategory().alias }}/{{ article.alias }}">
                                        <img src="{{ article.images['h_120'] }}" alt="">
                                        <span>{{ article.title }}</span>
                                    </a>
                                    <div class="content">
                                        {{ mb_substr(article.content | striptags, 0, 110) }}...
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="news_pagination">
                        {% if articles_count > 8 %}
                            <a href="{{ router.getRewriteUri() }}" id="more_ln">More+</a>
                        {% endif %}
                        {#{% if page.current == 1 %}#}
                            {#<a href="{{ router.getRewriteUri() }}?page={{ page.next }}" id>More+</a>#}
                        {#{% else %}#}
                            {#<a href="{{ router.getRewriteUri() }}?page={{ page.before }}">Before</a>#}
                            {#<a href="{{ router.getRewriteUri() }}?page={{ page.next }}">Next</a>#}
                            {#<a href="{{ router.getRewriteUri() }}?page={{ page.last }}">Last</a>#}
                        {#{% endif %}#}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="row news_banner_left">
                <div class="col-lg-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-md-12 col-sm-12 col-xs-6 col-xs-offset-3">
                    <img src="/img/news-banner-left.jpg" alt="">
                </div>
            </div>
            <div class="row most_popular_box">
                <div class="container_heading text-center">
                    <h3>Most Popular</h3>
                </div>
                {% for topArticle in topArticles %}
                {% if loop.first %}
                {% else %}
                    {% if loop.index == 2 %}
                        <div class="col-lg-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-md-12 col-sm-12 col-xs-10 col-xs-offset-1">
                    {% endif %}
                    <div class="news_top_small_item mb20">
                    <a href="/blog/{{ topArticle.getCategory().alias }}/{{ topArticle.alias }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 co-sm-4 col-xs-3">
                                <img src="{{ topArticle.images['h_50'] }}" alt="">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <span>{{ loop.index }}.</span>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <span>{{ topArticle.title }}</span>
                            </div>
                        </div>
                    </a>
                    {% if !loop.last %}
                    <hr>
                    {% endif %}
                        </div>
                        {% if loop.last %}
                            </div>
                        {% endif %}
                    {% endif %}
                {% endfor %}
            </div>

            <div class="row news_banner_left">
                <div class="col-lg-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-md-12 col-sm-12 col-xs-6 col-xs-offset-3">
                    <img src="/img/news-banner-left.jpg" alt="">
                </div>
            </div>
            <div class="row news_banner_left">
                <div class="col-lg-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-md-12 col-sm-12 col-xs-6 col-xs-offset-3">
                    <img src="/img/news-banner-left.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>