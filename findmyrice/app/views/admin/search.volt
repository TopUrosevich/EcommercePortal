{{ content() }}
<div class="container wallaper admin_search_box">
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("admin/index", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ link_to("admin/create", "Create users", "class": "btn red_btn") }}
        </li>
    </ul>
    <div class="rwd_table">
    {% for user in page.items %}
        {% if loop.first %}
            <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Banned?</th>
                <th>Suspended?</th>
                <th>Confirmed?</th>
            </tr>
            </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("admin/edit/" ~ user._id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
            <td width="12%">{{ link_to("admin/delete/" ~ user._id, '<i class="icon-remove"></i> Delete', "class": "btn") }}</td>
        </tr>
        </tbody>
        {% if loop.last %}
            <tbody>
            <tr>
                <td colspan="10" class="search_box_pagination">
                    <div class="btn-group">
                        {{ link_to("admin/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                        {{ link_to("admin/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                        {{ link_to("admin/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                        {{ link_to("admin/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                        <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                    </div>
                </td>
            </tr>
            <tbody>
            </table>
        {% endif %}
    {% else %}
        No users are recorded
    {% endfor %}
    </div>
</div>