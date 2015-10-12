{{ content() }}

{% set authorName = author.first_name ? author.first_name ~ ' ' ~ author.last_name : 'No author name' %}

<div class="container wallaper recipes_box">
    <div class="col-lg-9 col-md-9">
        <div class="row news_banner_top">
            <div class="col-xs-12">
                <img src="/images/banner-top-next-move.jpg">
            </div>
        </div>
        {#{% include 'recipes/partials/navTop.volt' %}#}
        {% include 'user/partials/headerMenu.volt' %}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="breadcrumb recipes_box_breadcrumb">
                    <li><a href="/recipes">Recipes</a></li>
                    <li><a href="/recipes/author/{{ author._id }}">{{ authorName }}</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7"></div>
            <div class="col-lg-5 col-md-5">
                {% include 'recipes/partials/navView.volt' %}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8"></div>
            <div class="col-lg-4 col-md-4">
                {% include 'recipes/partials/pagination.volt' %}
            </div>
        </div>
        <div class="row">
            <div class="container_heading text-center">
                <span>Recipes of {{ authorName }}</span>
            </div>
            <div class="recipes">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        {{ recipes_list(page.items, view) }}
                    </div>
                    <div class="row">
                        {% include 'recipes/partials/pagination.volt' %}
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        {% include 'recipes/partials/mightLike.volt' %}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        {% include 'recipes/partials/bannerLeft.volt' %}
    </div>
</div>