{{ content() }}
 {% for type, messages in flashSession.getMessages() %}
     {% for message in messages %}
         <div class="alert alert-{{ type }}">
             <button type="button" class="close" data-dismiss="alert">&times;</button>
             {{ message }}
         </div>
     {% endfor%}
 {% endfor %}
{#{{ flashSession.output() }}#}
<div class="container wallaper profile_box">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="row title_my_account">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Product Lists &  Service Area</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product_list_box">
                    <h4 class="ml15">Product Lists</h4>
                    <p class="productListBox_info ml15">Upload your product lists to ensure users can find the products you stock during a product search.</p>
                    <div class="product_list_area">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product List Name</th>
                                <th>File Type</th>
                                <th>Size</th>
                                <th>Uploaded</th>
                                <th>Preview</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            {% if products %}
                                {% for index, product in products %}
                                    <tr>
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ product['pl_name'] }}</td>
                                        <td>{{ product['pl_file_type'] }}</td>
                                        <td>{{ product['pl_size'] }}Kb </td>
                                        <td>{{ product['pl_uploaded'] }}</td>
                                        <td class="edit_delete_box"><a href="{{ product['pl_url'] }}">VIEW</a></td>
                                        <td class="edit_delete_box"><a href="?delete={{ product['_id'] }}" onclick="return confirm('Are you sure?')">Remove</a></td>
                                    </tr>
                                {% endfor %}
                            {% else %}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            {% endif %}
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <p class="ml15">File Upload</p>
                            <p class="ml15">(.xls .csv .doc .pdf)</p>
                        </div>
                    </div>
                    <div class="row fileUpload_box">
                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
                            <div class="fileUpload red_btn text-center">
                                <span>Upload Product List</span>
                                <div style="display: none" id="ajax-loader-product"><img src="/img/ajax-loader2.gif"></div>
                                <form method="post" enctype="multipart/form-data" id="product-list">
                                    <input type="file" class="file_upload_btn" name="upload_product_list" id="upload_product_list" />
                                    <input type="hidden" name="upload_product_list_id" id="upload_product_list_id" value="1" />
                                </form>
                            </div>
                            <div style="display: none; color:#f40909" id="product-message">Something went wrong.</div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7">
                            <p class="text_bold">For the best search results download the product list template <a href="../files/Product List Template.csv" class="red_txt">here</a>.</p>
                        </div>
                    </div>
                </div>
                <div class="service_area_box">
                <h4 class="ml15">Service Area</h4>
                <p class="productListBox_info ml15">To be included in the product & Services search you will need to specify a Delivery/Service area.</p>
                <div class="product_list_area">
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
                        {% if ServiceAreas %}
                            {% for ServiceArea in ServiceAreas %}
                                <tr>
                                    <td>{{ ServiceArea['sa_area_name'] }}</td>
                                    <td>{{ ServiceArea['product_list_name'] }}</td>
                                    <td>{{ ServiceArea['sa_status'] }} </td>
                                    <td class="edit_delete_box"><a href="/company/product-list-service-area/edit/{{ ServiceArea['_id'] }}">Edit</a> / <a href="/company/product-list-service-area/delete/{{ ServiceArea['_id'] }}" onclick="return confirm('Are you sure?')">Delete</a></td>
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
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5 col-xs-7">
                        <div class="add_single_box"><button type="button" class="add_single_btn red_btn">Add Single Service Area</button></div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 text-center">
                        <div class="fileUpload red_btn">
                            <span>Upload Multiple Service Area’s</span>
                            <input type="file" class="file_upload_btn" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-10 col-xs-12 mt10 mb15">
                        Upload multiple Service area’s via a csv file. Downlaod the template <a href="#" class="red_txt">here</a>.
                    </div>
                </div>
                <!--   Start  -->
                <div id="service_area" style="display: none" class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div role="tabpanel" class="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active" id="area_details_tab">
                                    <a href="#area_details" aria-controls="home" role="tab" data-toggle="tab">Area Details</a>
                                </li>
                                <li role="presentation" id="profile_tab">
                                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Service/Delivery Area</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content area_details">
                                <div role="tabpanel" class="tab-pane active" id="area_details">
                                    {{ form('action':'company/product-list-service-area#area_details','enctype':"multipart/form-data" , 'id': 'form-ad-plsa') }}
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-md-6">
                                            <div class="checkbox">
                                                <label class="no_important company_info_txt">
                                                    I service supply globally from this location <input type="checkbox" class="company_info">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="label_not_required no_important">Type Address</label>
                                                {{ ad_form.render('ad_type_address') }}
                                                {{ ad_form.messages('ad_type_address') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="ad_country">Country</label>
                                                {{ ad_form.render('ad_country') }}
                                                {{ ad_form.messages('ad_country') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="service_state">State</label>
                                                {{ ad_form.render('ad_state') }}
                                                {{ ad_form.messages('ad_state') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="service_region">Region</label>
                                                {{ ad_form.render('ad_suburb_town_city') }}
                                                {{ ad_form.messages('ad_suburb_town_city') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 save_exit_btn">
                                            <button type="button" class="red_btn save_btn">Save</button>
                                            <button type="button" class="red_btn exit_btn">Exit</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    {{ form('action':'company/product-list-service-area#profile','enctype':"multipart/form-data" , 'id': 'form-plsa') }}
                                    {{ form.render("id") }}
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
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                                                    <label for="product_list">Product List</label>
                                                    {{ form.render('product_list') }}
                                                    {{ form.messages('product_list') }}
                                            </div>
                                            {#<div class="form-group">#}
                                            {#<label for="product_list">Product List</label>#}
                                            {#{{ form.render('product_list') }}#}
                                            {#{{ form.messages('product_list') }}#}
                                            {#</div>#}
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="no_important label_not_required">Type Address</label>
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
                    </div>
                </div>
                <!-- End --->


                </div>
                </div>
            </div>
        </div>


    </div>
</div>