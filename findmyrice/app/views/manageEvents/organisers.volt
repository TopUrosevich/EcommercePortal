{{ content() }}

<div class="container wallaper events_categories">
        <div class="container_heading">
            <h2>Events</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageEvents/partials/navManage.volt' %}
        </div>
        <div class="form_description">
            <span>Event Organisers</span>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
                <a href="/manageEvents/createOrganiser">
                    <button type="button" class="primary_btn">Create Organiser</button>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5">
                <form id="events_csv_form" method="post" enctype="multipart/form-data">
                    <button onclick="$('#csv_file').click()" type="button" class="primary_btn">Upload CSV</button>
                    <input onchange="$('#events_csv_form').submit()" id="csv_file" type="file" name="csv">
                </form>
            </div>
        </div>
        <div id="manage_events_organiser_table">
            <form action="/manageEvents/deleteOrganisers" method="post">
                <div class="rwd_table">
                    <table id="manage-events-organiser" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="name_col">Organiser Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th></th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Organiser', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
    </div>