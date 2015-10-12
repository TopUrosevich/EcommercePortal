{{ content() }}
<div class="container wallaper news_blog_box">
    <div class="news_container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="container_heading">
                    <h2>News/Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="nav_manage">
                    {% include 'manageNews/partials/navManage.volt' %}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <div class="row div_table_head">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        Add a News Category
                    </div>
                </div>
                <form method="post" autocomplete="off">
                    <div class="row mt10">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {#{{ form.label('title') }}#}
                                {{ form.render('title',['class': 'form-control form_control', 'placeholder': 'Title']) }}
                                <span class="text-danger">
                                    {{ form.hasMessagesFor('title') ? form.getMessagesFor('title')[0] : '' }}
                                </span>
                            </div>
                            <div class="form-group">
                                {#{{ form.label('alias') }}#}
                                {{ form.render('alias', ['class': 'form-control form_control', 'placeholder': 'Alias']) }}
                                <span class="text-danger">
                                    {{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}
                                </span>
                            </div>
                            <div class="form-group">
                                {{ submit_button('Add New Category', 'class': 'primary_btn') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1 col-xs-12">
                <form action="/manageNews/deleteCategories" method="post">
                        <div class="row div_table_head">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                Category Title
                            </div>
                        </div>
                        {% for category in categories %}
                        <div class="row div_table_row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="checkbox" name="category[{{ category._id }}]">
                                {{ category.title }}
                            </div>
                        </div>
                        {% endfor %}
                    <div class="row div_table_btn">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{ submit_button('Delete Category', 'class': 'primary_btn') }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>