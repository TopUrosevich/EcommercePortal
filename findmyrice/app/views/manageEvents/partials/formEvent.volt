<form method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="event_name">Event Name<span class="asterisk"></span></label>
                {{ form.render('event_name',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('event_name') ? form.getMessagesFor('event_name')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="venue">Venue<span class="asterisk"></span></label>
                {{ form.render('venue',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('venue') ? form.getMessagesFor('venue')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    {#<div class="row">#}
        {#<div class="col-md-8 col-lg-8">#}
            {#<div class="form-group">#}
                {#<label for="alias">Alias<span class="asterisk"></span></label>#}
                {#{{ form.render('alias',['class': 'form-control form_control required']) }}#}
                {#<span class="text-danger">#}
                    {#{{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}#}
                {#</span>#}
            {#</div>#}
        {#</div>#}
    {#</div>#}
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="organiser_id">Organiser<span class="asterisk"></span></label>
                {{ form.render('organiser_id',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('organiser_id') ? form.getMessagesFor('organiser_id')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <label for="category_id">Category<span class="asterisk"></span></label>
                {{ form.render('category_id',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('category_id') ? form.getMessagesFor('category_id')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="country">Country<span class="asterisk"></span></label>
                {{ form.render('country',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('country') ? form.getMessagesFor('country')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <label for="city">City<span class="asterisk"></span></label>
                {{ form.render('city',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('city') ? form.getMessagesFor('city')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="timezone">Timezone<span class="asterisk"></span></label>
                {{ form.render('timezone',['class': 'form-control form_control', 'placeholder': 'Region/City']) }}
                <span class="text-danger">
                {{ form.hasMessagesFor('timezone') ? form.getMessagesFor('timezone')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="street_address">Street Address<span class="asterisk"></span></label>
                {{ form.render('street_address',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('street_address') ? form.getMessagesFor('street_address')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Time">Time{#<span class="asterisk"></span>#}</label>
                {{ form.render('time',['class': 'form-control form_control', 'placeholder': '00:00 AM - 00:00 AM']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('time') ? form.getMessagesFor('time')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="start_date">Start Date<span class="asterisk"></span></label>
                {{ form.render('start_date',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('start_date') ? form.getMessagesFor('start_date')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="end_date">End Date<span class="asterisk"></span></label>
                {{ form.render('end_date',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('end_date') ? form.getMessagesFor('end_date')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                {#<label for="enquiry_email">Enquiry Email<span class="asterisk"></span></label>#}
                <label for="enquiry_email">Enquiry Email</label>
                {{ form.render('enquiry_email',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('enquiry_email') ? form.getMessagesFor('enquiry_email')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                {#<label for="website">Website<span class="asterisk"></span></label>#}
                <label for="website">Website</label>
                {{ form.render('website',['class': 'form-control form_control required']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('website') ? form.getMessagesFor('website')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="facebook">Facebook</label>
                {{ form.render('facebook',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('facebook') ? form.getMessagesFor('facebook')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <label for="twitter">Twitter</label>
                {{ form.render('twitter',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('twitter') ? form.getMessagesFor('twitter')[0] : '' }}
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <label for="instagram">Instagram</label>
                {{ form.render('instagram',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('instagram') ? form.getMessagesFor('instagram')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="description">Description<span class="asterisk"></span></label>
                {{ form.render('description',['class': 'form-control form_control required', 'rows': 7]) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('description') ? form.getMessagesFor('description')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="image_preview">Upload Preview Image(210 x 130 px)<span class="asterisk"></span></label>
                <div class="image_uploader_preview">
                    <p>Drag Image to upload</p>
                    <img src="">
                </div>
                {{ form.render('image_preview',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('image_preview') ? form.getMessagesFor('image_preview')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="image_origin">Upload Image(1370 x 250 px)<span class="asterisk"></span></label>
                <div class="image_uploader_origin">
                    <p>Drag Image to upload</p>
                    <img src="">
                </div>
                {{ form.render('image_origin',['class': 'form-control form_control']) }}
                <span class="text-danger">
                    {{ form.hasMessagesFor('image_origin') ? form.getMessagesFor('image_origin')[0] : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
                {{ form.label('approval') }}
                <input type="checkbox" id="publish" name="approval" {{ (event is defined and event.approval) ? 'checked' : '' }}>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
                {{ form.render('submit', ['class': 'primary_btn']) }}
            </div>
        </div>
    </div>
</form>