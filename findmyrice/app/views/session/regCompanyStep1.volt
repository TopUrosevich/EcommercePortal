{{ form('action':'session/register-company-step1','id': 'form-register') }}
{{ content() }}
<div class="register_box wallaper container">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<h2 class="company_txt">Company Details</h2>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 text-right step_box">
			<ul class="step_block">
				<li>Step</li>
				<li><a href="#" class="active">1</a></li>
				<li>of</li>
				<li><a href="#">3</a></li>
                {#<li>{{ link_to('','Back','class':"back_btn" ,'id':"back_btn_1" ) }}</li>#}
			</ul>

		</div>
	</div>

	<div class="row register_form">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-5 col-md-6 col-sm-6">
				<div class="form-group">
					{{ form.label('first_name') }}
					{{ form.render('first_name') }}
					{{ form.messages('first_name') }}

				</div>
				<div class="form-group">
					{{ form.label('name') }}
					{{ form.render('name') }}
					{{ form.messages('name') }}
				</div>
				<div class="form-group">
					{{ form.label('email') }}
					{{ form.render('email') }}
					{{ form.messages('email') }}
				</div>
				<div class="form-group">
                    {{ form.label('password') }}
					{{ form.render('password') }}
					{{ form.messages('password') }}
				</div>
		</div>
		<div class="col-lg-5 col-md-6 col-sm-6">
				<div class="form-group">
					{{ form.label('last_name') }}
					{{ form.render('last_name') }}
					{{ form.messages('last_name') }}
				</div>
				<div class="form-group">
					{{ form.label('confirmUsername') }}
					{{ form.render('confirmUsername') }}
					{{ form.messages('confirmUsername') }}
				</div>
				<div class="form-group">
					{{ form.label('confirmEmail') }}
					{{ form.render('confirmEmail') }}
					{{ form.messages('confirmEmail') }}
				</div>
				<div class="form-group">
					{{ form.label('confirmPassword') }}
					{{ form.render('confirmPassword') }}
					{{ form.messages('confirmPassword') }}
				</div>
		</div>
	</div>
	<div class="row register_form">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-5 col-md-6 col-sm-6">
				<div class="form-group">
					{{ form.label('business_name') }}
					{{ form.render('business_name') }}
					{{ form.messages('business_name') }}
				</div>
				<div class="form-group">
					{{ form.label('country') }}
					{{ form.render('country') }}
                    {#<input id="country" name="country" class="field form-control"/>#}
					{{ form.messages('country') }}
				</div>
				<div class="form-group">
					{{ form.label('suburb_town_city') }}
					{{ form.render('suburb_town_city') }}
					{{ form.messages('suburb_town_city') }}
				</div>
                <div class="form-group">
                    {{ form.label('business_type') }}
                    {{ form.render('business_type') }}
                    {{ form.messages('business_type') }}
                </div>
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="form-group">
							{{ form.label('country_code') }}
							{{ form.render('country_code') }}
							{{ form.messages('country_code') }}
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-group">
							{{ form.label('area_code') }}
							{{ form.render('area_code') }}
							{{ form.messages('area_code') }}
						</div>
					</div>
				</div>
		</div>
		<div class="col-lg-5 col-md-6 col-sm-6">
				<div class="form-group">
                    {{ form.label('type_address') }}
                    {{ form.render('type_address') }}
                    {{ form.messages('type_address') }}
				</div>
                <div class="form-group">
					{{ form.label('street_address') }}
					{{ form.render('street_address') }}
					{{ form.messages('street_address') }}
				</div>
				<div class="form-group">
					{{ form.label('state') }}
					{{ form.render('state') }}
					{{ form.messages('state') }}
				</div>
				<div class="form-group">
					{{ form.label('postcode') }}
					{{ form.render('postcode') }}
					{{ form.messages('postcode') }}
				</div>
				<div class="form-group">
					{{ form.label('phone') }}
					{{ form.render('phone') }}
					{{ form.messages('phone') }}
				</div>
				<div class="form-group">
					{{ form.label('primary_product_service') }}
					{{ form.render('primary_product_service') }}
					{{ form.messages('primary_product_service') }}
				</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-1 col-xs-2"></div>
		<div class="col-lg-11 col-xs-8">
			<div class="checkbox">
				{{ form.render('currently_import') }} {{ form.label('currently_import') }}
				{{ form.messages('currently_import') }}
			</div>
			<div class="checkbox">
				{{ form.render('currently_export') }} {{ form.label('currently_export') }}
				{{ form.messages('currently_export') }}
			</div>
			<div class="checkbox">
				{{ form.render('terms') }} {{ form.label('terms') }}
				{{ form.messages('terms') }}
			</div>
			<div class="checkbox">
				{{ form.render('subscribe_news') }} {{ form.label('subscribe_news') }}
				{{ form.messages('subscribe_news') }}
			</div>
			{#{{ form.render('csrf', ['value': security.getToken()]) }}#}
			{{ form.render('csrf', ['value': csrf_form]) }}
			{{ form.messages('csrf') }}
			<div class="next_btn_box">{{ form.render('Next >') }}</div>
		</div>
		<div class="col-xs-2">

		</div>
	</div>
</div>
</form>
