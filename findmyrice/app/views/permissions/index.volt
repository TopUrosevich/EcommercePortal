
{{ content() }}
<div class="container wallaper permissions_box">
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
        <form method="post">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Manage Permissions</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="profileId">Profile</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{ select('profileId', profiles, 'using': ['_id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '', "class": "form-control") }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{ submit_button("Search", "class": "btn btn-primary red_btn mt10") }}
                </div>
            </div>


            {% if request.isPost() %}
                {% if request.getPost('profileId') %}
                    {% if profile %}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            {{ hidden_field("idProfile", "value": profile._id) }}
                            {{ submit_button('Save', 'class': 'btn btn-big red_btn', 'name': 'savePermissions') }}
                        </div>
                    </div>
                        {% for resource, actions in acl.getResources() %}
                            <h3>{{ resource }}</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for action in actions %}
                                    <tr>
                                        <td><input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}"  {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}></td>
                                        <td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
                                    </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                        {% endfor %}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                {{ submit_button('Save', 'class': 'btn btn-big btn-success red_btn', 'name': 'savePermissions') }}
                            </div>
                        </div>
                    {% endif %}
                {% endif %}
            {% endif %}
        </form>
    </div>
</div>
</div>