<form method="post" autocomplete="off">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="organiser_name">Organiser Name<span class="asterisk"></span></label>
                {{ form.render('organiser_name',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('organiser_name') ? form.getMessagesFor('organiser_name')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="contact_name">Contact Name<span class="asterisk"></span></label>
                {{ form.render('contact_name',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('contact_name') ? form.getMessagesFor('contact_name')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="email">Email<span class="asterisk"></span></label>
                {{ form.render('email',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('email') ? form.getMessagesFor('email')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <input id="cityAutocomplete" class="form-control form_control" type="text" placeholder="Suburb/Town/City (Autocomplete)">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="street_address">Street Address<span class="asterisk"></span></label>
                {{ form.render('street_address',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('street_address') ? form.getMessagesFor('street_address')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="country">Country<span class="asterisk"></span></label>
                {{ form.render('country',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('country') ? form.getMessagesFor('country')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="state">State<span class="asterisk"></span></label>
                {{ form.render('state',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('state') ? form.getMessagesFor('state')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="form-group">
                <label for="city">Suburb/Town/City<span class="asterisk"></span></label>
                {{ form.render('city',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('city') ? form.getMessagesFor('city')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="zip_code">Zip Code<span class="asterisk"></span></label>
                {{ form.render('zip_code',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('zip_code') ? form.getMessagesFor('zip_code')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="country_code">Country Code<span class="asterisk"></span></label>
                {{ form.render('country_code',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('country_code') ? form.getMessagesFor('country_code')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="area_code">Area Code<span class="asterisk"></span></label>
                {{ form.render('area_code',['class': 'form-control form_control']) }}
                <span class="text-danger">
                        {{ form.hasMessagesFor('area_code') ? form.getMessagesFor('area_code')[0] : '' }}
                        </span>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="form-group">
                <label for="phone">Phone<span class="asterisk"></span></label>
                {{ form.render('phone',['class': 'form-control form_control']) }}
                <span class="text-danger">
                        {{ form.hasMessagesFor('phone') ? form.getMessagesFor('phone')[0] : '' }}
                        </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                {{ form.render('submit', ['class': 'primary_btn']) }}
            </div>
        </div>
    </div>
</form>