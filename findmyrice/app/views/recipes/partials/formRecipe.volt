{% if recipeType is defined %}
    <div class="recipes_form">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3">
                        {{ form.label('name') }}
                    </div>
                    <div class="col-lg-8 col-md-8">
                        {{ form.render('name',['class': 'form-control form_control']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('name') ? form.getMessagesFor('name')[0] : '' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3">
                        {{ form.label('category_id') }}
                    </div>
                    <div class="col-lg-8 col-md-8">
                        {{ form.render('category_id',['class': 'form-control form_control']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('category_id') ? form.getMessagesFor('category_id')[0] : '' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3">
                        {{ form.label('photo') }}
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="photo_uploader">
                            <p>Drag an image here or click to upload</p>
                            <img src="{{ recipe is defined ? recipe.photo_origin : '' }}">
                        </div>
                        {#{{ form.render('photo',['class': 'form-control form_control']) }}#}
                        <input type="file" id="photo" name="photo"
                               class="form-control form_control" accept="image/png,image/jpeg">
                        <span class="text-danger">
                            {{ form.hasMessagesFor('photo') ? form.getMessagesFor('photo')[0] : '' }}
                        </span>
                    </div>
                </div>
            </div>
            {% if recipeType == 'single' %}
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3">
                            {{ form.label('ingredients') }}
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="row ingredients">
                                <div class="col-lg-12 col-md-12">
                                    <div class="col-lg-2 col-md-2"><label>Qty</label></div>
                                    <div class="col-lg-3 col-md-3"><label>Unit</label></div>
                                    <div class="col-lg-7 col-md-7"><label>Ingredient</label></div>
                                </div>
                            </div>
                            <div class="row ingredients">
                                <div id="ingredients_input" class="col-lg-12 col-md-12">
                                    {% if recipe is defined %}
                                        {% set nextIndex = 0 %}
                                        {% for ingredient in recipe.ingredients %}
                                            <div class="col-lg-2 col-md-2">
                                                <input name="ingredients[{{ loop.index - 1 }}][qty]" value="{{ ingredient['qty'] }}" class="form-control form_control" type="text">
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <input unit-autocomplete name="ingredients[{{ loop.index - 1 }}][unit]" value="{{ ingredient['unit'] }}" class="form-control form_control" type="text">
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <input ingredient-autocomplete name="ingredients[{{ loop.index - 1 }}][ingredient]" value="{{ ingredient['ingredient'] }}" class="form-control form_control" type="text">
                                            </div>
                                            {% if loop.last %}
                                                {% set nextIndex = loop.index %}
                                            {% endif %}
                                        {% endfor %}
                                        <div class="col-lg-2 col-md-2">
                                            <input name="ingredients[{{ nextIndex }}][qty]" class="form-control form_control" type="text">
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <input unit-autocomplete name="ingredients[{{ nextIndex }}][unit]" class="form-control form_control" type="text">
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <input ingredient-autocomplete name="ingredients[{{ nextIndex }}][ingredient]" class="form-control form_control" type="text">
                                        </div>
                                    {% else %}
                                        {% for i in [0,1,2,3] %}
                                            <div class="col-lg-2 col-md-2">
                                                <input name="ingredients[{{ i }}][qty]" class="form-control form_control" type="text">
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <input unit-autocomplete name="ingredients[{{ i }}][unit]" class="form-control form_control" type="text">
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <input ingredient-autocomplete name="ingredients[{{ i }}][ingredient]" class="form-control form_control" type="text">
                                            </div>
                                        {% endfor %}
                                    {% endif %}
                                </div>
                                <div><span class="add" id="add_ingredient">+ Add Ingredient</span></div>
                            </div>
                            <span class="text-danger">
                                {{ form.hasMessagesFor('ingredients') ? form.getMessagesFor('ingredients')[0] : '' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3">
                            {{ form.label('methods') }}
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div id="methods_input" class="row">
                                {% if recipe is defined %}
                                    {% set nextStep = 1 %}
                                    {% for method in recipe.methods %}
                                        <div class="col-lg-2 col-md-2"><label>Step {{ loop.index }}</label></div>
                                        <div class="col-lg-10 col-md-10">
                                            <input name="methods[]" value="{{ method }}" type="text" class="form-control form_control">
                                        </div>
                                        {% if loop.last %}
                                            {% set nextStep = loop.index + 1 %}
                                        {% endif %}
                                    {% endfor %}
                                    <div class="col-lg-2 col-md-2"><label>Step {{ nextStep }}</label></div>
                                    <div class="col-lg-10 col-md-10">
                                        <input class="form-control form_control" name="methods[]" type="text">
                                    </div>
                                {% else %}
                                    {% for i in [0,1,2] %}
                                        <div class="col-lg-2 col-md-2"><label>Step {{ loop.index }}</label></div>
                                        <div class="col-lg-10 col-md-10">
                                            <input class="form-control form_control" name="methods[]" type="text">
                                        </div>
                                    {% endfor %}
                                {% endif %}
                            </div>
                            <div><span class="add" id="add_method">+ Add Step</span></div>
                            <span class="text-danger">
                                {{ form.hasMessagesFor('methods') ? form.getMessagesFor('methods')[0] : '' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3">
                            {{ form.label('servings') }}
                        </div>
                        <div class="col-lg-8 col-md-8">
                            {{ form.render('servings',['class': 'form-control form_control']) }}
                            <span class="text-danger">
                                {{ form.hasMessagesFor('servings') ? form.getMessagesFor('servings')[0] : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            {% endif %}
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3">
                        {{ form.label('notes') }}
                    </div>
                    <div class="col-lg-8 col-md-8">
                        {{ form.render('notes',['class': 'form-control form_control', 'rows': 4]) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('notes') ? form.getMessagesFor('notes')[0] : '' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3">
                        {{ form.label('tags') }}
                    </div>
                    <div class="col-lg-8 col-md-8">
                        {{ form.render('tags',['class': 'form-control form_control', 'placeholder': 'Enter Tags separated by comma']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('tags') ? form.getMessagesFor('tags')[0] : '' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3"></div>
                    <div class="col-lg-8 col-md-8">
                        <div class="row">
                            <div class="col-lg-2 col-md-2">
                                {{ submit_button('Save', 'class': 'primary_btn') }}
                            </div>
                            <div class="col-lg-7 col-md-7">
                                {#{{ form.render('public') }}#}
                                <input type="checkbox" id="public" name="public" {{ recipe is defined and recipe.public ? 'checked value="on"' : '' }}>
                                {{ form.label('public') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
{% else %}
    <div class="row recipes_nav_images">
        <div class="col-lg-6 col-md-6 recipes_nav_image">
            <a href="/recipes/add/single" class="image_link">
                <img src="/images/recipes-add-new-recipe.jpg">
            </a>
        </div>
        <div class="col-lg-6 col-md-6 recipes_nav_image">
            <a href="/recipes/add/photo" class="image_link">
                <img src="/images/recipes-add-photo-recipe.jpg">
            </a>
        </div>
    </div>
{% endif %}