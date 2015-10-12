{{  content() }}

<div class="container wallaper recipes_box">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="news_banner_top">
                        <img src="/images/banner-top-next-move.jpg">
                    </div>
                </div>
            </div>
            {#{% include 'recipes/partials/navTop.volt' %}#}
            {% include 'user/partials/headerMenu.volt' %}
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="breadcrumb recipes_box_breadcrumb">
                        <li><a href="/recipes">Recipes</a></li>
                        <li><a href="/recipes/search">Search Recipes</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {% include 'recipes/partials/formSearch.volt' %}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {% include 'recipes/partials/filter.volt' %}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                    {% include 'recipes/partials/pagination.volt' %}
                </div>
            </div>
            <div class="recipes">
                <div class="row">
                    {{ recipes_list(page.items, view) }}
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {% include 'recipes/partials/pagination.volt' %}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            {% include 'recipes/partials/bannerLeft.volt' %}
        </div>
    </div>
</div>