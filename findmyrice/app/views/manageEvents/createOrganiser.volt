{{ content() }}
<div class="container wallaper events_categories">
    <div class="container_heading">
        <h2>Events</h2>
    </div>
    <div class="nav_manage">
        {% include 'manageEvents/partials/navManage.volt' %}
    </div>
    <div class="form_description">
        <span>Add a Event Organiser</span>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            {% include 'manageEvents/partials/formOrganiser.volt' %}
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="div_table">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="div_table_head">Organiser Details</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_organiser_name" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_contact_name" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_email" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_street_address" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_organiser_name" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_city" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="preview_zip_code" class="div_table_row"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="div_table_row">
                            <span id="preview_country_code"></span>
                            <span id="preview_area_code"></span>
                            <span id="preview_phone"></span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>