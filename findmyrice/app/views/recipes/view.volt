{{ content() }}

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
                    <li><a href="/recipes/view/{{ recipe._id }}">{{ recipe.name }}</a></li>
                </ul>
            </div>
        </div>
        <div class="recipes_single">
            <div class="recipe_name">{{ recipe.name }}</div>
            <div class="recipe_rating">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div id="star_rating" recipe-id="{{ recipe._id }}"></div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <div class="star_rating_average" id="star_rating_average"></div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="star_rating_total">Based on <span id="star_rating_total"></span> ratings</div>
                    </div>
                </div>
            </div>
            <div class="recipe_image">
                <img src="{{ recipe.photo_origin }}">
            </div>
            <div class="recipe_share">
                <div class="col-lg-1 col-md-1">
                    <div class="row">
                        <div class="share_label">Share</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="row">
                        <ul class="social_box">
                            <li><a href="http://www.facebook.com/sharer.php?u={{ url(router.getRewriteUri()) }}&t={{ recipe.name }}">
                                    <img src="/images/fb_icon.png" alt="fb icon"></a></li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url(router.getRewriteUri()) }}">
                                    <img src="/images/linkedin_icon.png" alt="linkedin icon"></a></li>
                            <li><a href="https://plusone.google.com/_/+1/confirm?hl=en&url={{ url(router.getRewriteUri()) }}">
                                    <img src="/images/g+_icon.png" alt="g+ icon"></a></li>
                            <li><a href="http://twitter.com/share?url={{ url(router.getRewriteUri()) }}&text={{ recipe.name }}">
                                    <img src="/images/twitter_icon.png" alt="twitter icon"></a></li>
                            <li><a href="http://www.pinterest.com/pin/create/button/?url={{ url(router.getRewriteUri()) }}&description={{ recipe.name }}&media={{ recipe.photo['h_215'] }}">
                                    <img src="/images/pinterest_icon.png" alt="pinterest icon"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="row">
                        <button data-toggle="modal" data-target="#addToCookbookModal" type="button" class="btn btn-sm">
                            Add to my Cookbook | <span class="glyphicon glyphicon-plus-sign"></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="row">
                        <button data-toggle="modal" data-target="#shareWithContactModal" type="button" class="btn btn-sm">
                            Share with a Contact | <span class="glyphicon glyphicon-plus-sign"></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <div class="row">
                        <button onclick="printElementById('print_area')" type="button" class="btn btn-sm">
                            Print | <span class="glyphicon glyphicon-print"></span>
                        </button>
                    </div>
                </div>
            </div>
            {% if recipe.type == 'single' %}
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="recipe_content">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#ingredients">Ingredients</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#method">Method</a>
                                </li>
                            </ul>
                            <div id="print_area" class="tab-content">
                                <div id="ingredients" class="tab-pane fade in active">
                                    {% for ingredient in recipe.ingredients %}
                                        <div class="ingredient">
                                            <span class="glyphicon glyphicon-unchecked"></span> {{ ingredient['qty'] }} {{ ingredient['unit'] }} {{ ingredient['ingredient'] }}
                                        </div>
                                    {% endfor %}
                                </div>
                                <div id="method" class="tab-pane fade">
                                    {% for method in recipe.methods %}
                                        <div class="method">
                                            <div class="col-lg-2 col-md-2">
                                                <div class="row">
                                                    <span class="step">Step {{ loop.index }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-md-10">
                                                <div class="row">
                                                    <span class="method_item">{{ method }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="recipe_servings">
                            <span>Servings </span> {{ recipe.servings ? recipe.servings : '-' }}
                        </div>
                    </div>
                </div>
            {% endif %}
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="recipe_tags">
                        <div class="container_heading">
                            <span>Recipe Tags</span>
                        </div>
                        <div class="tags">
                            {% for tag in recipe.tags %}
                                <div class="col-lg-3 col-md-3">
                                    <div class="row">
                                        <div class="tag"><a href="/recipes/tags/{{ tag }}">{{ tag }}</a></div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="about_author">
                        {% set author = recipe.getAuthor() %}
                        {% set profile = author.getProfile() %}
                        <hr>
                        <div class="row">
                            <div class="col-lg-2 col-md-2">
                                <img src="{{ profile ? profile.profile_image : '/images/empty_profile_image.png' }}">
                            </div>
                            <div class="col-lg-10 col-md-10">
                                <div class="author">
                                    <div class="name">
                                        {% set authorName = author.first_name ? author.first_name ~ ' ' ~ author.last_name : 'No author name' %}
                                        About <a href="/recipes/author/{{ author._id }}">{{ authorName }}</a>
                                    </div>
                                    <div class="location">
                                        {{ author.state ? author.state : 'No state' }}, {{ author.country ? author.country : 'No country' }}
                                    </div>
                                </div>
                                <div class="about">
                                    {{ profile ? profile.short_description : 'Profile short description is empty' }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    {% include 'recipes/partials/mightLike.volt' %}
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="container_heading text-center">
                        <span>Recipe Comments</span>
                    </div>
                    <div class="recipes_comments">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div id="comments_list">
                                    {% for comment in comments %}
                                        {% set commentOwner = comment.getOwner() %}
                                        <div class="col-lg-12 col-md-12" remove-comment-id="{{ comment._id }}">
                                            <div class="row">
                                                <div class="comment_item">
                                                    <div class="col-lg-2 col-md-2">
                                                        <div class="row">
                                                            {% set profile = commentOwner.getProfile() %}
                                                            <img src="{{ profile ? profile.profile_image : '/images/empty_profile_image.png' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10">
                                                        <div class="row">
                                                            <div class="comment_head">
                                                                {% set commentAuthorName = commentOwner.first_name ? commentOwner.first_name ~ ' ' ~ commentOwner.last_name : 'No author name' %}
                                                                <span class="comment_author_name">{{ commentAuthorName }}</span>
                                                                <span class="comment_time">{{ date('Y-m-d H:i:s', comment.created_at) }}</span>
                                                                {% if mid == comment.owner_id %}
                                                                    <span class="glyphicon glyphicon-remove glyphicon_remove_comment" title="Delete comment"
                                                                          onclick="deleteRecipeComment('{{ recipe._id }}', '{{ comment._id }}')"></span>
                                                                {% endif %}
                                                            </div>
                                                            <hr>
                                                            <div class="comment_message">
                                                                {{ comment.message }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="comments_form">
                                    {% if logged_in %}
                                        <div class="form-group">
                                            <textarea class="form-control form_control" id="comment_message" rows="5" placeholder="Comment message"></textarea>
                                        </div>
                                        <button class="primary_btn" id="comment_add" recipe-id="{{ recipe._id }}" type="button">Add Comment</button>
                                    {% else %}
                                        <div class="container_heading">
                                            <span>You must be logged in to comment</span>
                                        </div>
                                    {% endif %}
                                </div>
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

<div class="modal fade" id="addToCookbookModal" tabindex="-1" role="dialog"
     aria-labelledby="addToCookbookModal" aria-hidden="true">
    <div class="modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="addToCookbookLabel">Add to my Cookbook</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="form-group">
                            <input id="cookbook_name" type="text" class="form-control form_control" placeholder="Cookbook Name">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button id="cookbook_create" location="recipes" type="button" class="primary_btn">Create</button>
                    </div>
                </div>
                <div id="cookbook_add_success" class="row">
                    <div class="col-lg-12 col-md-12">
                        <span class="label label-success">Recipe was added successfully</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div id="cookbooks_list" class="cookbook_items">
                            {% for cookbook in myCookbooks  %}
                                <div class="cookbook_item">
                                    <input type="checkbox" id="{{ cookbook._id }}" value="{{ cookbook._id }}">
                                    {{ cookbook.name }}
                                </div>
                            {% endfor %}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="add_to_cookbook" recipe-id="{{ recipe._id }}" type="button" class="primary_btn">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="shareWithContactModal" tabindex="-1" role="dialog"
     aria-labelledby="addToCookbookModal" aria-hidden="true">
    <div class="modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="shareWithContactLabel">Share with a Contact</h4>
            </div>
            <div class="modal-body">
                <div id="recipe_share_success" class="row">
                    <div class="col-lg-12 col-md-12">
                        <span class="label label-success">Recipe was shared successfully</span>
                    </div>
                </div>
                <div id="recipe_share_error" class="row">
                    <div class="col-lg-12 col-md-12">
                        <span class="label label-danger">Recipe share error</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <input id="share_email" type="text" class="form-control form_control" placeholder="Email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="share_recipe" recipe-id="{{ recipe._id }}" type="button" class="primary_btn">Share</button>
            </div>
        </div>
    </div>
</div>