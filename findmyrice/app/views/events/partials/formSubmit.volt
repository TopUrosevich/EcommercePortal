<form method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="organiser_name">Organiser Name<span class="asterisk"></span></label>
                    {{ organisersForm.render('organiser_name',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('organiser_name') ? organisersForm.getMessagesFor('organiser_name')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="contact_name">Contact Name<span class="asterisk"></span></label>
                    {{ organisersForm.render('contact_name',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('contact_name') ? organisersForm.getMessagesFor('contact_name')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="email">Email<span class="asterisk"></span></label>
                    {{ organisersForm.render('email',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('email') ? organisersForm.getMessagesFor('email')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 "></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <input id="cityAutocomplete" class="form-control form_control" type="text" placeholder="Suburb/Town/City (Autocomplete)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="street_address">Street Address<span class="asterisk"></span></label>
                    {{ organisersForm.render('street_address',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('street_address') ? organisersForm.getMessagesFor('street_address')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="country">Country<span class="asterisk"></span></label>
                    {{ organisersForm.render('country',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('country') ? organisersForm.getMessagesFor('country')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="state">State<span class="asterisk"></span></label>
                    {{ organisersForm.render('state',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('state') ? organisersForm.getMessagesFor('state')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-5 col-lg-5">
                <div class="form-group">
                    <label for="city">Suburb/Town/City<span class="asterisk"></span></label>
                    {{ organisersForm.render('city',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('city') ? organisersForm.getMessagesFor('city')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="zip_code">Zip Code<span class="asterisk"></span></label>
                    {{ organisersForm.render('zip_code',['class': 'form-control form_control', 'placeholder': 'Postcode/Zip Code']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('zip_code') ? organisersForm.getMessagesFor('zip_code')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="country_code">Country Code<span class="asterisk"></span></label>
                    {{ organisersForm.render('country_code',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('country_code') ? organisersForm.getMessagesFor('country_code')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="area_code">Area Code<span class="asterisk"></span></label>
                    {{ organisersForm.render('area_code',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('area_code') ? organisersForm.getMessagesFor('area_code')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-5 col-lg-5">
                <div class="form-group">
                    <label for="phone">Phone<span class="asterisk"></span></label>
                    {{ organisersForm.render('phone',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ organisersForm.hasMessagesFor('phone') ? organisersForm.getMessagesFor('phone')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="event_name">Event Name<span class="asterisk"></span></label>
                    {{ eventsForm.render('event_name',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('event_name') ? eventsForm.getMessagesFor('event_name')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="venue">Venue<span class="asterisk"></span></label>
                    {{ eventsForm.render('venue',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('venue') ? eventsForm.getMessagesFor('venue')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="form-group">
                    <label for="alias">Alias<span class="asterisk"></span></label>
                    {{ eventsForm.render('alias',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('alias') ? eventsForm.getMessagesFor('alias')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="category_id">Category<span class="asterisk"></span></label>
                    {{ eventsForm.render('category_id',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('category_id') ? eventsForm.getMessagesFor('category_id')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="country">Country<span class="asterisk"></span></label>
                    {{ eventsForm.render('country',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('country') ? eventsForm.getMessagesFor('country')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="city">City<span class="asterisk"></span></label>
                    {{ eventsForm.render('city',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('city') ? eventsForm.getMessagesFor('city')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="timezone">Timezone<span class="asterisk"></span></label>
                    {{ eventsForm.render('timezone',['class': 'form-control form_control', 'placeholder': 'Region/City']) }}
                    <span class="text-danger">
                    {{ organisersForm.hasMessagesFor('timezone') ? organisersForm.getMessagesFor('timezone')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="street_address">Street Address<span class="asterisk"></span></label>
                    {{ eventsForm.render('street_address',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('street_address') ? eventsForm.getMessagesFor('street_address')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="Time">Time<span class="asterisk"></span></label>
                    {{ eventsForm.render('time',['class': 'form-control form_control', 'placeholder': '00:00 AM - 00:00 AM']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('time') ? eventsForm.getMessagesFor('time')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 ">
                <div class="form-group">
                    <label for="start_date">Start Date<span class="asterisk"></span></label>
                    {{ eventsForm.render('start_date',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('start_date') ? eventsForm.getMessagesFor('start_date')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="end_date">End Date<span class="asterisk"></span></label>
                    {{ eventsForm.render('end_date',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('end_date') ? eventsForm.getMessagesFor('end_date')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 ">
                <div class="form-group">
                    <label for="enquiry_email">Enquiry Email<span class="asterisk"></span></label>
                    {{ eventsForm.render('enquiry_email',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('enquiry_email') ? eventsForm.getMessagesFor('enquiry_email')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="website">Website<span class="asterisk"></span></label>
                    {{ eventsForm.render('website',['class': 'form-control form_control required']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('website') ? eventsForm.getMessagesFor('website')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    {{ eventsForm.render('facebook',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('facebook') ? eventsForm.getMessagesFor('facebook')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    {{ eventsForm.render('twitter',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('twitter') ? eventsForm.getMessagesFor('twitter')[0] : '' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 ">
                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    {{ eventsForm.render('instagram',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('instagram') ? eventsForm.getMessagesFor('instagram')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="description">Description<span class="asterisk"></span></label>
                    {{ eventsForm.render('description',['class': 'form-control form_control required', 'placeholder': 'Enter description of the event', 'rows': 7]) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('description') ? eventsForm.getMessagesFor('description')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="image_preview">Upload Preview Image(210 x 130 px)<span class="asterisk"></span></label>
                    <div class="image_uploader_preview">
                        <p>Drag Image to upload</p>
                        <img src="">
                    </div>
                    {{ eventsForm.render('image_preview',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('image_preview') ? eventsForm.getMessagesFor('image_preview')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="image_origin">Upload Image(1370 x 250 px)<span class="asterisk"></span></label>
                    <div class="image_uploader_origin">
                        <p>Drag Image to upload</p>
                        <img src="">
                    </div>
                    {{ eventsForm.render('image_origin',['class': 'form-control form_control']) }}
                    <span class="text-danger">
                        {{ eventsForm.hasMessagesFor('image_origin') ? eventsForm.getMessagesFor('image_origin')[0] : '' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            {{ submit_button('Submit an Event', 'class': 'primary_btn') }}
        </div>
    </div>
</form>