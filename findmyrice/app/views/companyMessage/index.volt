<div class="container wallaper my_account_box">
{#{% for type, messages in flashSession.getMessages() %}#}
{#{% for message in messages %}#}
{#<div class="alert alert-{{ type }}">#}
{#<button type="button" class="close" data-dismiss="alert">&times;</button>#}
{#{{ message }}#}
{#</div>#}
{#{% endfor%}#}
{#{% endfor %}#}
{#{{ flashSession.output() }}#}
<div class="row">
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
    {% include 'company/partials/leftMenu.volt' %}
</div>
<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
    <div class="row title_my_account">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>My Account</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 membership_form">
            <form method="post" autocomplete="off" enctype="multipart/form-data" id="company-details">
                {{ form.render("id") }}
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("email") }}
                        {{ form.messages("email") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="first_name">Fisrt Name</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("first_name") }}
                        {{ form.messages("first_name") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("last_name") }}
                        {{ form.messages("last_name") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-lg-9">
                        {{ form.render("name") }}
                        {{ form.messages("name") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="business_name">Business name</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("business_name") }}
                        {{ form.messages("business_name") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        {#<label for="street_address">#}Type Address{#</label>#}
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("type_address") }}
                        {{ form.messages("type_address") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="street_address">Street address</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("street_address") }}
                        {{ form.messages("street_address") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="town_city">Suburb/Town/City</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("suburb_town_city") }}
                        {{ form.messages("suburb_town_city") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="state">State</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("state") }}
                        {{ form.messages("state") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="country">Country</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("country") }}
                        {{ form.messages("country") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="postcode">Postcode</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("postcode") }}
                        {{ form.messages('postcode') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="country_code">Country Code</label>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("country_code") }}
                        {{ form.messages("country_code") }}
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                        <label for="area_code">Area Code</label>
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 area_code_field">
                        {{ form.render("area_code") }}
                        {{ form.messages("area_code") }}
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                        <label for="phone">Phone</label>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("phone") }}
                        {{ form.messages("phone") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="business_type">Business Type</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("business_type") }}
                        {{ form.messages("business_type") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label for="primary_supplier_category">Primary Supplier Category</label>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("primary_supplier_category") }}
                        {{ form.messages("primary_supplier_category") }}
                    </div>
                </div>
                {#<div class="row">#}
                {#<div class="col-lg-3">#}
                {#<label for="other_business_type">Other Business Type</label>#}
                {#</div>#}
                {#<div class="col-lg-9">#}
                {#{{ form.render("other_business_type") }}#}
                {#{{ form.messages("other_business_type") }}#}
                {#</div>#}
                {#</div>#}
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="checkbox">
                            <label>{{ form.render('currently_export') }} I currently export products overseas.</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ form.render('currently_import') }} I currently import products from overseas.</label>
                        </div>
                    </div>
                </div>
                <div class="row password_box">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Change Password</h3>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("password") }}
                        {{ form.messages("password") }}
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span>If you would like to change the password type a new one. Otherwise leave this blank</span>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        {{ form.render("confirmPassword") }}
                        {{ form.messages("confirmPassword") }}
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <button type="submit" class="red_btn update_btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 membership_type_box">
            <div class="user_logo">
                {% if userLogo_thumb %}
                    {{ image(userLogo_thumb, "alt": "company logo", "id":"logo", 'width':'100%') }}
                {% elseif userLogo %}
                    {{ image(userLogo, "alt": "company logo", "id":"logo", 'width':'100%') }}
                {% else %}
                    {{ image("../images/NoLogoImage.jpg", "alt": "company no logo", "id":"logo", 'width':'100%') }}
                {% endif %}
            </div>
            <h1>Membership Type</h1>
            <span class="membership_info">{{ user.membership_type }}</span>
            {{ link_to('membership', 'Upgrade Membership', 'class':"red_txt") }}
            <h1>Promote your profile</h1>
            {{ link_to('company/badge-icon', 'Download badges & Buttons', 'class':"red_txt") }}
        </div>
    </div>
</div>
</div>
</div>