{%- macro recipes_list(_recipes, _view) %}
    {% if _view == 'grid' %}
        {% for recipe in _recipes %}
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="recipes_preview">
                    <a href="/recipes/view/{{ recipe._id }}">
                        <div class="photo">
                            <img src="{{ recipe.photo_preview }}">
                        </div>
                        <div class="title">
                            <div class="row">
                                <div class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-3 col-xs-offset-1">
                                    <div class="recipe_circle"></div>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                                    {% set author = recipe.getAuthor() %}
                                    <div class="recipe_name">
                                        {{ recipe.name }}
                                    </div>
                                    <div class="recipe_author">By {{ author.first_name }} {{ author.last_name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
                                    <span class="glyphicon glyphicon-heart glyphicon_red"></span> {{ recipe.getFavoritesCount() }} Favourites
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span class="separate"> | </span></div>
                                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-0 col-xs-5 col-xs-offset-0">
                                    {{ recipe.getSharesCount() }} Shares</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        {% endfor %}
    {% elseif _view == 'list' %}
        <div class="col-lg-12 col-md-12">
            <div class="div_table">
                <div class="row div_table_head">
                    <div class="col-lg-6 col-md-6">Name</div>
                    <div class="col-lg-3 col-md-3">Category</div>
                    <div class="col-lg-3 col-md-3">Created By</div>
                </div>
                {% for recipe in _recipes %}
                    <div class="row div_table_row">
                        <div class="col-lg-6 col-md-6">
                            <a href="/recipes/view/{{ recipe._id }}">{{ recipe.name }}</a>
                        </div>
                        <div class="col-lg-3 col-md-3">{{ recipe.getCategory().title }}</div>
                        {% set author = recipe.getAuthor() %}
                        {% set authorName = author.first_name ? author.first_name ~ ' ' ~ author.last_name : 'No author name' %}
                        <div class="col-lg-3 col-md-3">{{ authorName }}</div>
                    </div>
                {% endfor %}
            </div>
        </div>
    {% endif %}
{%- endmacro %}