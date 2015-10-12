{{ content() }}
<div class="register_box wallaper container">
    <div class="row step_box">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="company_txt">Service / Delivery Area</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 text-right step_box">
            <ul class="step_block">
                <li>Step</li>
                <li><a href="#" class="active">2</a></li>
                <li>of</li>
                <li><a href="#">3</a></li>
                <li>{{ link_to('session/register-company-step1','Back','class':"back_btn" ,'id':"back_btn_2" ) }}</li>
            </ul>
        </div>
    </div>
    <div class="row info_delivery_area">
        <div class="col-lg-offset-1 col-lg-8">
            To be included in the product & Services search you will need to specify at least one Delivery/ Service area. If you have multiple distribution centres or
            office locations these can be added later.
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12">
            <div class="delivery_area">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Area Name</th>
                        <th>Product List</th>
                        <th>Status</th>
                        <th>Edit / Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% if products %}
                    {% for product in products %}
                    <tr>
                        <td>{{ product['service_area']['area_name'] }}</td>
                        {% if product['product_info'] %}
                            <td>{{ product['product_info']['product_list_name'] }}</td>
                        {%  else %}
                            <td>Empty</td>
                        {%  endif %}
                        {#<td>{{ product['service_area']['status'] }}</td>#}
                        <td>Complete</td>
                        <td class="edit_delete_box"><a href="/session/register-company-step2/edit/step2_{{ product['product_info']['unique'] }}">Edit</a> / <a href="/session/register-company-step2/delete/step2_{{ product['product_info']['unique'] }}" onclick="return confirm('Are you sure?')">Delete</a></td>
                    </tr>
                    {% endfor %}
                    {% else %}
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    {% endif %}

                    </tbody>
                </table>
                <div class="add_single_box"><button type="button" class="add_single_btn red_btn">Add Single Service Area</button></div>
                <div id="service_area" style="display: none">
                    <div class="row register_form area_details">
                            {{ form('action':'session/register-company-step2#save-assa','enctype':"multipart/form-data" , 'id': 'form-register-assa') }}
                            {#{{ form.render("id") }}#}
                            {#<div class="row">#}
                                {#<div class="col-lg-12 col-md-12 col-sm-12">#}
                                    {#<div class="checkbox">#}
                                        {#<label class="no_important company_info_txt">#}
                                            {#I currently import products from overseas <input type="checkbox" class="company_info">#}
                                        {#</label>#}
                                    {#</div>#}
                                {#</div>#}
                            {#</div>#}
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="area_name">Area Name</label>
                                        {{ form.render('area_name') }}
                                        {{ form.messages('area_name') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="area_country">Country</label>
                                        {{ form.render('country') }}
                                        {{ form.messages('country') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="area_suburb">Suburb/Town/City</label>
                                        {{ form.render('suburb_town_city') }}
                                        {{ form.messages('suburb_town_city') }}
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <div class="form-group">
                                                <label for="country_code">Country Code</label>
                                                {{ form.render('country_code') }}
                                                {{ form.messages('country_code') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="area_code">Area Code</label>
                                                {{ form.render('area_code') }}
                                                {{ form.messages('area_code') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>Product</div>
                                        File Upload
                                        (pdf. doc. docx. xls. xlsx. csv)

                                        {{ form.render('productToUpload') }}
                                        {{ form.messages('productToUpload') }}


                                        {% for type, messages in flashSession.getMessages() %}
                                            {% for message in messages %}
                                                <div class="alert alert-{{ type }}">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    {{ message }}
                                                </div>
                                            {% endfor%}
                                        {% endfor %}
                                        {#{{ flashSession.output() }}#}
                                    </div>
                                    {#<div class="form-group">#}
                                        {#<label for="area_country">Status</label>#}
                                        {#{{ form.render('status') }}#}
                                        {#{{ form.messages('status') }}#}
                                    {#</div>#}

                                    {#<div class="form-group">#}
                                        {#<label for="product_list">Product List</label>#}
                                        {#{{ form.render('product_list') }}#}
                                        {#{{ form.messages('product_list') }}#}
                                    {#</div>#}
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="street_address">Type Address</label>
                                        {{ form.render('type_address') }}
                                        {{ form.messages('type_address') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="street_address">Street Address</label>
                                        {{ form.render('street_address') }}
                                        {{ form.messages('street_address') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        {{ form.render('state') }}
                                        {{ form.messages('state') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">Postcode/Zip Code</label>
                                        {{ form.render('postcode') }}
                                        {{ form.messages('postcode') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="area_phone">Phone</label>
                                        {{ form.render('phone') }}
                                        {{ form.messages('phone') }}
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            {#<button type="button" class="red_btn save_btn">Save</button>#}
                                            {{ submit_button("Save", "class": "red_btn save_btn", "id":"save-assa") }}
                                            <button type="button" class="red_btn exit_btn">Exit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                </div>

            </div>
            <div class="next_btn_box">{{ link_to('session/register-company-step3','<button class="next_btn" id="next_btn_2"> Next > </button>') }}</div>
        </div>
    </div>
</div>