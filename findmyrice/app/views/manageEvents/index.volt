{{ content() }}

<div class="container wallaper news_blog_box">
        <div class="container_heading">
            <h2>Events</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageEvents/partials/navManage.volt' %}
        </div>
        <div class="form_description">
            <span>Events</span>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
                <a href="/manageEvents/create">
                    <button type="button" class="primary_btn">Create Event</button>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5">
                <form id="events_csv_form" method="post" enctype="multipart/form-data">
                    <button onclick="$('#csv_file').click()" type="button" class="primary_btn">Upload CSV</button>
                    <input onchange="$('#events_csv_form').submit()" id="csv_file" type="file" name="csv">
                </form>
            </div>
        </div>
        <div id="manage_events_table">
            <form action="/manageEvents/delete" method="post">
                <div class="rwd_table">
                    <table id="manage-events" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="name_col">Name</th>
                            <th class="category_col">Category</th>
                            <th class="approval_col">Approval</th>
                            <th class="date_col">Date</th>
                            <th class="changes_col"></th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Event(s)', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
</div>