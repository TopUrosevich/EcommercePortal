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
            <span>Edit a Event Organiser</span>
        </div>
        <div class="col-lg-8 col-md-8">
            {% include 'manageEvents/partials/formOrganiser.volt' %}
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="div_table">
                <div class="row div_table_head">Organiser Details</div>
                <div id="preview_organiser_name" class="row div_table_row">{{ organiser.organiser_name }}</div>
                <br>
                <div id="preview_contact_name" class="row div_table_row">{{ organiser.contact_name }}</div>
                <br>
                <div id="preview_email" class="row div_table_row">{{ organiser.email }}</div>
                <br>
                <div id="preview_street_address" class="row div_table_row">{{ organiser.street_address }}</div>
                <div id="preview_city" class="row div_table_row">{{ organiser.city }}</div>
                <div id="preview_country" class="row div_table_row">{{ organiser.country }}</div>
                <div id="preview_zip_code" class="row div_table_row">{{ organiser.zip_code }}</div>
                <br>
                <div class="row div_table_row">
                    <span id="preview_country_code">{{ organiser.country_code }}</span> <span id="preview_area_code">{{ organiser.area_code }}</span> <span id="preview_phone">{{ organiser.phone }}</span>
                </div>
            </div>
        </div>
    </div>
</div>