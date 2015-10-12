{{ content() }}

<div class="container wallaper recipes_box">
    {#<div class="recipes_container">#}
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
                        <li><a href="/recipes/add">Add Recipes</a></li>
                        {% if recipeType is defined %}
                            <li><a href="/recipes/add/{{ recipeType }}">{{ recipeType == 'single' ? 'Add New Recipe' : 'Add Photo Recipe' }}</a></li>
                        {% endif %}
                    </ul>
                </div>
            </div>
            {% include 'recipes/partials/formRecipe.volt' %}
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    {% include 'recipes/partials/mightLike.volt' %}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            {% include 'recipes/partials/bannerLeft.volt' %}
        </div>
    {#</div>#}
</div>