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
                    <li><a href="/recipes/cookbooks">My Cookbooks</a></li>
                    {% if cookbook is defined %}
                        <li><a href="/recipes/cookbooks/{{ cookbook._id }}">{{ cookbook.name }}</a></li>
                    {% endif %}
                </ul>
            </div>
        </div>
        {% if shares is defined %}
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <button data-toggle="modal" data-target="#shareModal" type="button" class="btn btn-default">
                        Share Cookbooks <span class="badge">{{ shares | length }}</span>
                    </button>
                </div>
            </div>
        {% endif %}
        {% if page is defined %}
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="cookbook_share">
                        <button data-toggle="modal" data-target="#shareWithContactModal" type="button" class="btn btn-sm">
                            Share with a Contact | <span class="glyphicon glyphicon-plus-sign"></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    {% include 'recipes/partials/navView.volt' %}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7"></div>
                <div class="col-lg-5 col-md-5">
                    {% include 'recipes/partials/pagination.volt' %}
                </div>
            </div>
        {% endif %}
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="recipes">
                    <div class="row">
                        {% if cookbooks is defined %}
                        <div class="col-lg-12 col-md-12">
                            <div class="cookbooks_list">
                                {% for _cookbook in cookbooks %}
                                <div id="{{ _cookbook._id }}" class="row">
                                    <div class="cookbook_item">
                                        <div class="col-lg-11 col-md-11">
                                            <a href="/recipes/cookbooks/{{ _cookbook._id }}">{{ _cookbook.name }} <span class="badge">{{ _cookbook.getRecipesCount() }}</span></a>
                                        </div>
                                        <div class="col-lg-1 col-md-1">
                                            <span onclick="deleteCookbook('{{ _cookbook._id }}')" class="glyphicon glyphicon-trash"></span>
                                        </div>
                                    </div>
                                </div>
                                {{ !loop.last ? '<hr>' : '' }}
                                {% endfor %}
                            </div>
                        </div>
                        {% elseif page is defined %}
                        {{ recipes_list(page.items, view) }}
                        {% else %}
                            <div class="container_heading text-center">
                                <span>No Recipes Found</span>
                            </div>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7"></div>
            <div class="col-lg-5 col-md-5">
                {% if page is defined %}
                    {% include 'recipes/partials/pagination.volt' %}
                {% endif %}
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="row">
                {% include 'recipes/partials/mightLike.volt' %}
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        {% include 'recipes/partials/bannerLeft.volt' %}
    </div>
</div>

<div class="modal fade" id="shareWithContactModal" tabindex="-1" role="dialog"
     aria-labelledby="shareWithContactModal" aria-hidden="true">
    <div class="modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="shareWithContactLabel">Share with a Contact</h4>
            </div>
            <div class="modal-body">
                <div id="cookbook_share_success" class="row">
                    <div class="col-lg-12 col-md-12">
                        <span class="label label-success">Cookbook was shared successfully</span>
                    </div>
                </div>
                <div id="cookbook_share_error" class="row">
                    <div class="col-lg-12 col-md-12">
                        <span class="label label-danger">Cookbook share error</span>
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
                <button id="share_cookbook" cookbook-id="{{ cookbook._id }}" type="button" class="primary_btn">Share</button>
            </div>
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
                <h4 class="modal-title" id="shareLabel">Share Cookbooks</h4>
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
                            {% set _authorName = _owner.first_name ? _owner.first_name ~ ' ' ~  _owner.last_name : 'No author name' %}
                            <span class="owner">{{ _owner.first_name }} {{ _owner.last_name }} </span>
                            has shared with You a this cookbook
                            {% set _cookbook = share.getCookbook() %}
                            <a href="/recipes/cookbooks/{{ _cookbook._id }}?ref=share&id={{ _share._id }}">
                                {{ _cookbook.name }}
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