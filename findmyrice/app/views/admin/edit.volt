<div class="wallaper container admin_edit_box">
<div class="row">
<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("admin", "&larr; Go Back") }}
    </li>
    {#<li class="pull-right">#}
    {#{{ submit_button("Save", "class": "btn btn-big btn-success") }}#}
    {#</li>#}
</ul>

{{ content() }}

<div class="center scaffold">
<h2>Edit users</h2>

<ul class="nav nav-tabs">
    <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
    <li><a href="#B" data-toggle="tab">Successful Logins</a></li>
    <li><a href="#C" data-toggle="tab">Password Changes</a></li>
    <li><a href="#D" data-toggle="tab">Reset Passwords</a></li>
</ul>

<div class="tabbable">
<div class="tab-content">

<div class="tab-pane active" id="A">
    <form method="post" autocomplete="off">
        {{ form.render("id") }}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="email">{{ form.label('email') }}</label>
                {{ form.render("email") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="first_name">{{ form.label('first_name') }}</label>
                {{ form.render("first_name") }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="last_name">{{ form.label('last_name') }}</label>
                {{ form.render("last_name") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="name">{{ form.label('name') }}</label>
                {{ form.render("name") }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="business_name">{{ form.label('business_name') }}</label>
                {{ form.render("business_name") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="street_address">{{ form.label('street_address') }}</label>
                {{ form.render("street_address") }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="suburb_town_city">{{ form.label('suburb_town_city') }}</label>
                {{ form.render("suburb_town_city") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="state">{{ form.label('state') }}</label>
                {{ form.render("state") }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="country">{{ form.label('country') }}</label>
                {{ form.render("country") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label for="postcode">{{ form.label('postcode') }}</label>
                {{ form.render("postcode") }}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label for="country_code">{{ form.label('country_code') }}</label>
                {{ form.render("country_code") }}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label for="area_code">{{ form.label('area_code') }}</label>
                {{ form.render("area_code") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="phone">{{ form.label('phone') }}</label>
                {{ form.render("phone") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="business_type">{{ form.label('business_type') }}</label>
                {{ form.render("business_type") }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="other_business_type">{{ form.label('other_business_type') }}</label>
                {{ form.render("other_business_type") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{ form.render('currently_import') }} {{ form.label('currently_import') }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{ form.render('currently_export') }} {{ form.label('currently_export') }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                {{ form.label('logo') }} {{ form.render('logo', ["class": "form-control"]) }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                {{ form.label('membership_type') }}  {{ form.render('membership_type') }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for="profilesId">Profile</label>
                {{ form.render("profilesId") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="suspended" class="mt10">Suspended?</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                {{ form.render("suspended", ["class": "form-control"]) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="banned" class="mt10">Banned?</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                {{ form.render("banned", ["class": "form-control"]) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <label for="active" class="mt10">Confirmed?</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                {{ form.render("active", ["class": "form-control"]) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 {{ submit_button("Update", "class": "btn btn-big red_btn") }}
            </div>
        </div>
    </form>
    <form method="post" autocomplete="off" action="{{ url("admin/changePassword/"~user_id) }}">
        <input type="hidden" name = "user_id" value="{{  user_id }}">
        <div class="center scaffold">

            <h2>Change Password</h2>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="password">Password</label>
                    {{ formPassword.render("password", ["class": "form-control"]) }}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="confirmPassword">Confirm Password</label>
                    {{ formPassword.render("confirmPassword", ["class": "form-control"]) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {{ submit_button("Change Password", "class": "btn red_btn") }}
                </div>
            </div>
        </div>
    </form>
</div>

<div class="tab-pane" id="B">
    <p>
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            {#<th>Id</th>#}
            <th>IP Address</th>
            <th>User Agent</th>
        </tr>
        </thead>
        <tbody>
        {% for login in user.successLogins %}
            <tr>
                {#<td>{{ login._id }}</td>#}
                <td>{{ login.ipAddress }}</td>
                <td>{{ login.userAgent }}</td>
                {#<th>{{ date("Y-m-d H:i:s", login.createdAt) }}#}
            </tr>
        {% else %}
            <tr><td colspan="2" align="center">User does not have successfull logins</td></tr>
        {% endfor %}
        </tbody>
    </table>
    </p>
</div>

<div class="tab-pane" id="C">
    <p>
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            {#<th>Id</th>#}
            <th>IP Address</th>
            <th>User Agent</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        {% for change in user.passwordChanges %}
            <tr>
                {#<td>{{ change._id }}</td>#}
                <td>{{ change.ipAddress }}</td>
                <td>{{ change.userAgent }}</td>
                <td>{{ date("Y-m-d H:i:s", change.createdAt) }}</td>
            </tr>
        {% else %}
            <tr><td colspan="3" align="center">User has not changed his/her password</td></tr>
        {% endfor %}
        </tbody>
    </table>
    </p>
</div>

<div class="tab-pane" id="D">
    <p>
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            {#<th>Id</th>#}
            <th>Date</th>
            <th>Reset?</th>
        </tr>
        </thead>
        <tbody>
        {% for reset in user.resetPasswords %}
            <tr>
                {#<th>{{ reset._id }}</th>#}
                <th>{{ date("Y-m-d H:i:s", reset.createdAt) }}
                <th>{{ reset.reset == 'Y' ? 'Yes' : 'No' }}
            </tr>
        {% else %}
            <tr><td colspan="2" align="center">User has not requested reset his/her password</td></tr>
        {% endfor %}
        </tbody>
    </table>
    </p>
</div>

</div>
</div>

</div>
</div>
</div>
</div>