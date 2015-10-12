{{ content() }}
<div class="container wallaper profile_box certificate_tab">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-9 col-md-10 col-sm-9 col-xs-12">
            <div class="row title_my_account">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Certification & Awards</h2>
                </div>
            </div>
            <div class="product_list_box">
                <h4 class="ml15">Certification</h4>
                <p class="productListBox_info ml15">Add the certification your company has received. This informationwill be included in our search to help users find suitably qualified companies.</p>
            </div>
            <div class="product_list_area gray_table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Certification Name</th>
                        <th>Issued By</th>
                        <th>Expires</th>
                        <th>Preview</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>BRC</td>
                        <td>HACCP Australia</td>
                        <td>14 Dec 14</td>
                        <td class="edit_delete_box"><a href="#">VIEW</a></td>
                        <td class="edit_delete_box"><a href="#">Remove</a></td>
                    </tr>
                    <tr>
                        <td>SQF 2000</td>
                        <td>HACCP Australia</td>
                        <td>14 Dec 14</td>
                        <td class="edit_delete_box"><a href="#">VIEW</a></td>
                        <td class="edit_delete_box"><a href="#">Remove</a></td>
                    </tr>
                    <tr>
                        <td>HACCP</td>
                        <td>HACCP Australia</td>
                        <td>14 Dec 14</td>
                        <td class="edit_delete_box"><a href="#">VIEW</a></td>
                        <td class="edit_delete_box"><a href="#">Remove</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <h3 class="ml15">Add New Certificate</h3>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 certificate_inp">
                            <input type="text" class="form-control" placeholder="Certification Name" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 certificate_inp">
                            <input type="text" class="form-control" placeholder="Issued By"/>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 certificate_inp">
                            <input type="text" class="form-control" placeholder="Expiry Date"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb10">
                            <p>File Upload</p>
                            <p>(.jpg .png .pdf)</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="fileUpload red_btn text-center">
                                <span>Upload Certificate</span>
                                <div style="display: none" id="ajax-loader-product"><img src="/img/ajax-loader2.gif"></div>
                                <form method="post" enctype="multipart/form-data" id="product-list">
                                    <input type="file" class="file_upload_btn" name="upload_product_list" id="upload_product_list">
                                    <input type="hidden" name="upload_product_list_id" id="upload_product_list_id" value="1">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">


            </div>
            <div class="row mt10">
                <div class="col-lg-2 col-lg-offset-10 col-md-2 col-md-offset-10 col-sm-3 col-sm-offset-9 col-xs-0 col-xs-offset-0">
                    <button type="button" class="red_btn add_btn">Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product_list_box">
                    <h4 class="ml15">Awards</h4>
                    <p class="productListBox_info ml15">Showcase the awards your business has received by ading them below:</p>
                </div>
            </div>
            <div class="product_list_area gray_table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Award Name</th>
                        <th>Award Date</th>
                        <th>Edit / Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Foodservice Supplier of the Year</td>
                        <td>2014</td>
                        <td class="edit_delete_box"><a href="#">Edit</a> / <a href="#">Delete</a></td>
                    </tr>
                    <tr>
                        <td>Foodservice Supplier of the Year</td>
                        <td>2014</td>
                        <td class="edit_delete_box"><a href="#">Edit</a> / <a href="#">Delete</a></td>
                    </tr>
                    <tr>
                        <td>Foodservice Supplier of the Year</td>
                        <td>2014</td>
                        <td class="edit_delete_box"><a href="#">Edit</a> / <a href="#">Delete</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 class="ml15">Add New Award</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 certificate_inp">
                    <input type="text" class="form-control" placeholder="Award Name" />
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 certificate_inp">
                    <input type="text" class="form-control" placeholder="Year"/>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <button type="button" class="red_btn add_btn">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>