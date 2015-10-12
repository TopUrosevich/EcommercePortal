{{ content() }}

<div class="container">
    <div class="recipes_container">
        <div class="container_heading">
            <h2>Recipes</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageRecipes/partials/navManage.volt' %}
        </div>
        <div class="form_description">
            <span>Add a Recipe Category</span>
        </div>
        <div class="col-lg-4 col-md-4">
            <form method="post" autocomplete="off">
                <div class="row">
                    <div class="form-group">
                        {{ form.render('title',['class': 'form-control form_control', 'placeholder': 'Title']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('title') ? form.getMessagesFor('title')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ form.render('alias', ['class': 'form-control form_control', 'placeholder': 'Alias']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ submit_button('Add New Category', 'class': 'primary_btn') }}
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3"></div>
        <div class="col-lg-5 col-md-5">
            <form action="/manageRecipes/deleteCategories" method="post">
                <div class="div_table">
                    <div class="row div_table_head">
                        <div>Category Title</div>
                    </div>
                    {% for category in categories %}
                        <div class="row div_table_row">
                            <div>
                                <input type="checkbox" name="category[{{ category._id }}]">
                                {{ category.title }}
                            </div>
                        </div>
                    {% endfor %}
                </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Category', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
    </div>
</div>