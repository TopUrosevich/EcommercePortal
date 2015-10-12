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
            <span>Organiser Messages</span>
        </div>
        <div>
            <form action="/manageEvents/deleteOrganiserMessages" method="post">
                <div class="div_table">
                    <div class="row div_table_head">
                        <div class="col-lg-3 col-md-3">Name</div>
                        <div class="col-lg-3 col-md-3">Email</div>
                        <div class="col-lg-6 col-md-6">Message</div>
                    </div>
                    {% for message in messages %}
                        <div class="row div_table_row">
                            <div class="col-lg-3 col-md-3">
                                <input type="checkbox" name="message[{{ message._id }}]">
                                {{ message.name }}
                            </div>
                            <div class="col-lg-3 col-md-3">
                                {{ message.email}}
                            </div>
                            <div class="col-lg-6 col-md-6">
                                {{ message.message }}
                            </div>
                        </div>
                    {% endfor %}
                </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Message', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
    </div>
</div>