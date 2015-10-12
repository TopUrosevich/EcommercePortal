{{ content() }}

<div class="container">
    <div class="events_container">
        <div class="container_heading">
            <h2>Events</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageEvents/partials/navManage.volt' %}
        </div>
        <div class="form_description">
            <span>Add Event</span>
        </div>
        <div class="col-lg-8 col-md-8">
            {% include 'manageEvents/partials/formEvent.volt' %}
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="div_table">
                <div id="preview_image" class="div_table_row">
                    <img src="{{ event.image_origin }}">
                </div>
            </div>
            <div class="div_table">
                <div class="row div_table_head">Event Details</div>
                <div id="preview_event_name" class="row div_table_row">{{ event.event_name }}</div>
                <div id="preview_venue" class="row div_table_row">{{ event.venue }}</div>
                <div id="preview_organiser" class="row div_table_row">{{ event.getOrganiser().organiser_name }}</div>
                <div id="preview_category" class="row div_table_row">{{ event.getCategory().title }}</div>
                <div class="row div_table_row"><span id="preview_start_date">{{ event.start_date }}</span> - <span id="preview_end_date">{{ event.end_date }}</span></div>
                <div id="preview_enquiry_email" class="row div_table_row">{{ event.enquiry_email }}</div>
                <div id="preview_website" class="row div_table_row">{{ event.website }}</div>
            </div>
        </div>
    </div>
</div>