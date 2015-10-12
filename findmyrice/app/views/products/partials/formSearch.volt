<form class="form form-inline" action="/products/search">
    <div class="row search">
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            {%  if products_count == 1 %}
            <span class="all_products">{{ products_count }} event was found.</span>
            {% elseif products_count == 0 %}
            <span class="all_products">No event was found.</span>
            {%  elseif products_count != 1 %}
            <span class="all_products">{{ products_count }} products was found.</span>
            {%  endif %}
        </div>
        <div class="col-lg-6  col-md-6  col-sm-6 col-xs-12 col-xs-offset-0">
            <div class="searchBox">
                <input class="form-control form_control" type="text" name="query"
                       placeholder="Search by: Country, City, Event type or event name">
                    {{ submit_button('', 'class': 'primary_btn') }}
            </div>
        </div>
    </div>
</form>
