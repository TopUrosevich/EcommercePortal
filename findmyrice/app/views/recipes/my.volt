{{ content() }}

<div class="container wallaper recipes_box">
    <div class="recipes_container">
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
                        <li><a href="/recipes/my">My Recipes</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <button data-toggle="modal" data-target="#shareModal" type="button" class="btn btn-default">
                        Share Recipes <span class="badge">{{ shares | length }}</span>
                    </button>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="row">
                        {% include 'recipes/partials/navView.volt' %}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="recipes">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    {% if view == 'list' %}
                                        <div class="div_table">
                                            <div class="row div_table_head">
                                                <div class="col-lg-5 col-md-5">Name</div>
                                                <div class="col-lg-3 col-md-3">Category</div>
                                                <div class="col-lg-1 col-md-1">Shares</div>
                                                <div class="col-lg-1 col-md-1">Favorites</div>
                                                <div class="col-lg-2 col-md-2"></div>
                                            </div>
                                            {% for recipe in page.items %}
                                                <div class="row div_table_row">
                                                    <div class="col-lg-5 col-md-5">
                                                        <a href="/recipes/view/{{ recipe._id }}">{{ recipe.name }}</a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3">{{ recipe.getCategory().title }}</div>
                                                    <div class="col-lg-1 col-md-1">{{ recipe.getSharesCount() }}</div>
                                                    <div class="col-lg-1 col-md-1">{{ recipe.getFavoritesCount() }}</div>
                                                    <div class="col-lg-2 col-md-2">
                                                        <a href="/recipes/view/{{ recipe._id }}">
                                                            <span title="View Recipe" class="glyphicon glyphicon-eye-open"> </span>
                                                        </a>
                                                        <a href="/recipes/edit/{{ recipe._id }}">
                                                            <span title="Edit Recipe" class="glyphicon glyphicon-edit"> </span>
                                                        </a>
                                                        <a href="/recipes/delete/{{ recipe._id }}">
                                                            <span title="Delete Recipe" class="glyphicon glyphicon-trash"> </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            {% endfor %}
                                        </div>
                                    {% elseif view == 'grid' %}
                                        {% for recipe in page.items %}
                                            <div class="col-lg-4 col-md-4">
                                                <div class="recipes_preview">
                                                    <a href="/recipes/view/{{ recipe._id }}">
                                                        <div class="photo">
                                                            <img src="{{ recipe.photo_preview }}">
                                                        </div>
                                                        <div class="title">
                                                            <div class="col-lg-2 col-md-2">
                                                                <div class="row">
                                                                    <div class="recipe_circle"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-md-10">
                                                                {% set author = recipe.getAuthor() %}
                                                                <div class="row">
                                                                    <div class="recipe_name">
                                                                        {{ recipe.name }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="recipe_author">By {{ author.first_name }} {{ author.last_name }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="info">
                                                            <span class="glyphicon glyphicon-heart glyphicon_red"></span> {{ recipe.getFavoritesCount() }} Favourites
                                                            <span class="separate"> | </span>
                                                            {{ recipe.getSharesCount() }} Shares
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        {% endfor %}
                                    {% endif %}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    {% include 'recipes/partials/pagination.volt' %}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            {% include 'recipes/partials/bannerLeft.volt' %}
        </div>
    </div>
</div>

<div class="modal fade" id="shareModal" tabindex="-1" role="dialog"
     aria-labelledby="shareModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="shareLabel">Share Recipes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        {% for _share in shares %}
                            <div class="share_item">
                                {% if !_share.shown %}
                                    <span class="label label-info">New</span>
                                {% endif %}
                                {% set _owner = _share.getOwner() %}
                                {% set _authorName = _owner.first_name ? _owner.first_name ~ ' ' ~ _owner.last_name : 'No author name' %}
                                <span class="owner">{{ _authorName }} </span>
                                has shared with You a this recipe
                                {% set _recipe = _share.getRecipe() %}
                                <a href="/recipes/view/{{ _recipe._id }}?ref=share&id={{ _share._id }}">
                                    {{ _recipe.name }}
                                </a>
                            </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="primary_btn">Close</button>
            </div>
        </div>
    </div>
</div>