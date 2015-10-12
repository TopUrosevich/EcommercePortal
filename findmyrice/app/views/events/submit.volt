{{ content() }}

<div class="container">
    <div class="events_container">
        <div class="col-lg-1 col-md-1"></div>
        <div class="col-lg-9 col-md-9">
            <div class="row">
                <div class="container_heading">
                    <h2>Submit an Event</h2>
                    <span>Submit your event</span>
                </div>
            </div>
            <div class="events_submit_form">
                {% include 'events/partials/formSubmit.volt' %}
            </div>
        </div>
        <div class="col-lg-1 col-md-1"></div>
    </div>
</div>