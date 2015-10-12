{{ content() }}
<div class="container wallaper events_categories">
    <div class="events_container">
        <div class="container_heading">
            <h2>Events</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageEvents/partials/navManage.volt' %}
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="div_table_head"> Add Event</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {% include 'manageEvents/partials/formEvent.volt' %}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="div_table">
                    <div id="preview_image" class="div_table_row">
                        <img>
                    </div>
                </div>
                <div class="div_table">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p class="div_table_head">Event Details</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_event_name" class="div_table_row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_venue" class="div_table_row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_organiser" class="div_table_row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_category" class="div_table_row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="div_table_row"><span id="preview_start_date"></span> - <span id="preview_end_date"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_enquiry_email" class="div_table_row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="preview_website" class="div_table_row"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>