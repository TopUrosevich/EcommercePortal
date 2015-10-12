<div class="wallaper container manage_users_box">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
            <form method="post" autocomplete="off">
                <ul class="pager">
                    <li class="previous pull-left">
                        {{ link_to("admin", "&larr; Go Back") }}
                    </li>
                    <li class="pull-right">
                        {{ submit_button("Create a user", "class": "btn btn-success red_btn") }}
                    </li>
                </ul>
                {{ content() }}
                <div class="center scaffold">
                    <h2>Create a User</h2>
                    <div class="span3">
                        <div class="clearfix">
                            <label for="email">{{ form.label('email') }}</label>
                            {{ form.render("email") }}
                        </div>
                        <div class="clearfix">
                            <label for="first_name">{{ form.label('first_name') }}</label>
                            {{ form.render("first_name") }}
                        </div>
                        <div class="clearfix">
                            <label for="last_name">{{ form.label('last_name') }}</label>
                            {{ form.render("last_name") }}
                        </div>
                        <div class="clearfix">
                            <label for="name">{{ form.label('name') }}</label>
                            {{ form.render("name") }}
                        </div>
                        <div class="clearfix">
                            <label for="business_name">{{ form.label('business_name') }}</label>
                            {{ form.render("business_name") }}
                        </div>
                        <div class="clearfix">
                            <label for="street_address">{{ form.label('street_address') }}</label>
                            {{ form.render("street_address") }}
                        </div>
                        <div class="clearfix">
                            <label for="suburb_town_city">{{ form.label('suburb_town_city') }}</label>
                            {{ form.render("suburb_town_city") }}
                        </div>
                        <div class="clearfix">
                            <label for="state">{{ form.label('state') }}</label>
                            {{ form.render("state") }}
                        </div>

                        <div class="clearfix">
                            <label for="country">{{ form.label('country') }}</label>
                            {{ form.render("country") }}
                        </div>
                    </div>
                        <div class="clearfix">
                            <label for="postcode">{{ form.label('postcode') }}</label>
                            {{ form.render("postcode") }}
                        </div>
                        <div class="clearfix">
                            <label for="country_code">{{ form.label('country_code') }}</label>
                            {{ form.render("country_code") }}
                        </div>
                        <div class="clearfix">
                            <label for="area_code">{{ form.label('area_code') }}</label>
                            {{ form.render("area_code") }}
                        </div>
                        <div class="clearfix">
                            <label for="phone">{{ form.label('phone') }}</label>
                            {{ form.render("phone") }}
                        </div>
                        <div class="clearfix">
                            <label for="business_type">{{ form.label('business_type') }}</label>
                            {{ form.render("business_type") }}
                        </div>

                        <div class="clearfix">
                            <label for="other_business_type">{{ form.label('other_business_type') }}</label>
                            {{ form.render("other_business_type") }}
                        </div>

                        <div class="clearfix">
                            {{ form.render('currently_import') }} {{ form.label('currently_import') }}
                        </div>
                        <div class="clearfix">
                            {{ form.render('currently_export') }} {{ form.label('currently_export') }}
                        </div>
                        <div class="clearfix">
                            <label for="profilesId">Profile</label>
                            {{ form.render("profilesId") }}
                        </div>

                        <div class="clearfix">
                            <label for="suspended">Suspended?</label>
                            {{ form.render("suspended") }}
                        </div>

                        <div class="clearfix">
                            <label for="banned">Banned?</label>
                            {{ form.render("banned") }}
                        </div>

                        <div class="clearfix">
                            <label for="active">Confirmed?</label>
                            {{ form.render("active") }}
                        </div>
                    <div class="clearfix"></div>
                    <div class="clearfix">
                        {{ submit_button("Create a user", "class": "btn btn-big btn-success red_btn") }}
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
