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
            <span>Add a Ingredient</span>
        </div>
        <div class="col-lg-4 col-md-4">
            <form method="post" autocomplete="off">
                <div class="row">
                    <div class="form-group">
                        {{ form.render('name', ['class': 'form-control form_control', 'placeholder': 'Ingredient']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('name') ? form.getMessagesFor('name')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ submit_button('Add New Ingredient', 'class': 'primary_btn') }}
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3"></div>
        <div class="col-lg-5 col-md-5">
            <form action="/manageRecipes/deleteIngredients" method="post">
                <div class="div_table">
                    <div class="row div_table_head">
                        <div>Ingredient Name</div>
                    </div>
                    {% for ingredient in ingredients %}
                        <div class="row div_table_row">
                            <div>
                                <input type="checkbox" name="ingredient[{{ ingredient._id }}]">
                                {{ ingredient.name }}
                            </div>
                        </div>
                    {% endfor %}
                </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Ingredient', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
    </div>
</div>