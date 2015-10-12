{{ content() }}

<div class="container wallaper recipes_box">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="row news_banner_top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="/images/banner-top-next-move.jpg">
                </div>
            </div>
            {#{% include 'recipes/partials/navTop.volt' %}#}
            {% include 'user/partials/headerMenu.volt' %}
            <div class="row recipes_nav_images">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recipes_nav_image">
                    <a href="/recipes/search" class="image_link"><img src="/images/recipes-search-recipe.jpg"></a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recipes_nav_image">
                    <a href="/recipes/add" class="image_link"><img src="/images/recipes-add-recipes.jpg"></a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recipes_nav_image">
                    <a href="/recipes/my" class="image_link"><img src="/images/recipes-my-recipes.jpg"></a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recipes_nav_image">
                    <a href="/recipes/cookbooks" class="image_link"><img src="/images/recipes-my-cookbooks.jpg"></a>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    {% include 'recipes/partials/mightLike.volt' %}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            {% include 'recipes/partials/bannerLeft.volt' %}
        </div>
    </div>
</div>