{{ content() }}

<div class="container">
    <div class="news_container">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="row news_banner_top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <img src="/img/news-banner-top.jpg" alt="">
                </div>
            </div>
            {% include 'blog/partials/navTop.volt' %}
            <div class="col-xs-12">
                <div class="row news_article_back">
                    <div class="col-lg-12">
                        <a href="/blog/{{ article.getCategory().alias }}" class="red_txt back_link">
                            <i class="fa fa-chevron-left"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="row news_article_image">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="{{ article.image }}" alt="">
                    </div>
                </div>
                <div class="row news_article_share">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12  padding_all0">
                        <ul class="social_box">
                            <li class="share_txt">Share</li>
                            <li><a href="http://www.facebook.com/sharer.php?u={{ url(router.getRewriteUri()) }}&t={{ article.title }}">
                                    <img src="/images/fb_icon.png" alt="fb icon"></a></li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url(router.getRewriteUri()) }}">
                                    <img src="/images/linkedin_icon.png" alt="linkedin icon"></a></li>
                            <li><a href="https://plusone.google.com/_/+1/confirm?hl=en&url={{ url(router.getRewriteUri()) }}">
                                    <img src="/images/g+_icon.png" alt="g+ icon"></a></li>
                            <li><a href="http://twitter.com/share?url={{ url(router.getRewriteUri()) }}&text={{ article.title }}">
                                    <img src="/images/twitter_icon.png" alt="twitter icon"></a></li>
                            <li><a href="http://www.pinterest.com/pin/create/button/?url={{ url(router.getRewriteUri()) }}&description={{ article.title }}&media={{ article.image }}">
                                    <img src="/images/pinterest_icon.png" alt="pinterest icon"></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 padding_all0 question">
                        <a href="/become-a-contributor">Want to contribute?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="news_article_title">
                            <span>{{ article.title }}</span>
                        </div>
                        <div class="news_article_date">
                            {% set contributor = article.getContributor() %}
                            <span class="text-uppercase">BY {{ contributor.first_name }} {{ contributor.last_name }} </span>
                            <span>{{ date('jS F Y', article.date) }}</span>
                        </div>
                        <div class="news_article_content">
                            {{ article.content }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="news_article_about_author">
                            {% set profile = contributor.getProfile() %}
                            <hr>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    {% if profile.profile_image is defined  %}<img src=" {{ profile.profile_image }}"> {% endif %}
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                    <div class="author">About {{ contributor.first_name }} {{ contributor.last_name }}</div>
                                    <div class="about">
                                        {% if profile.short_description is defined  %}{{ profile.short_description }} {% endif %}
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="container_heading text-center">
                            <h3>You Might Also Like</h3>
                        </div>
                        <div class="news_box news_box_article">
                            {% for article in mightLike %}
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="news_preview">
                                        <a href="/blog/{{ article.getCategory().alias }}/{{ article.alias }}">
                                            <img src="{{ article.images['h_120'] }}">
                                            <span>{{ article.title }}</span>
                                        </a>
                                        <div class="content">
                                            {{ mb_substr(article.content | striptags, 0, 100) }}...
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-lg-offset-0 col-md-3 col-sm-12 col-sm-offset-0 col-md-offset-0 col-xs-6 col-xs-offset-3">
            <div class="row news_banner_left">
                <img src="/img/news-banner-left.jpg">
            </div>
            <div class="row news_banner_left">
                <img src="/img/news-banner-left.jpg">
            </div>
            <div class="row news_banner_left">
                <img src="/img/news-banner-left.jpg">
            </div>
        </div>
    </div>
</div>