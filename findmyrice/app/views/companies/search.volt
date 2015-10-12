{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("users/index", "&larr; Go Back") }}
    </li>
    {% if profileRole == 'A' %}
    <li class="pull-right">
        {{ link_to("users/create", "Create users", "class": "btn btn-primary") }}
    </li>
    {% endif %}
</ul>

{% for user in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            {#<th>Id</th>#}
            <th>Name</th>
            <th>Email</th>
            {#<th>Profile</th>#}
            {% if profileRole == 'A' %}
            <th>Banned?</th>
            <th>Suspended?</th>
            <th>Confirmed?</th>
            {% endif %}
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            {#<td>{{ user.id }}</td>#}
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            {#<td>{{ user.profile.name }}</td>#}
            {% if profileRole == 'A' %}
            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("users/edit/" ~ user._id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
            <td width="12%">{{ link_to("users/delete/" ~ user._id, '<i class="icon-remove"></i> Delete', "class": "btn") }}</td>
            {% endif %}
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("companies/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("companies/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("companies/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("companies/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
