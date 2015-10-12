<form>
    <div class="row search">
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            {% set recipes_count = page.total_items %}
            {%  if recipes_count == 1 %}
                <span class="all_recipes">{{ recipes_count }} recipe was found.</span>
            {% elseif recipes_count == 0 %}
                <span class="all_recipes">No recipe was found.</span>
            {%  elseif recipes_count != 1 %}
                <span class="all_recipes">{{ recipes_count }} recipes was found.</span>
            {%  endif %}
        </div>
        <div class="col-lg-8  col-md-8  col-sm-8 col-xs-12 col-xs-offset-0">
            <div class="searchBox">
                <input class="form-control form_control" type="text" name="query"
                       placeholder="Search by: Keyword, Recipe Name, Ingredient etc.">
                {{ submit_button('', 'class': 'primary_btn') }}
            </div>
        </div>
    </div>
</form>