{{ form('class': 'form-search') }}
{{ content() }}

<div class="center scaffold">
	<div align="left">
		<h2>Company Details</h2>
	</div>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#A" data-toggle="tab">Step 1</a></li>
		<li><a href="#B" data-toggle="tab">Step 2</a></li>
		<li><a href="#C" data-toggle="tab">Step 3</a></li>
	</ul>

	<div class="tabbable">
		<div class="tab-content">
			<div class="tab-pane active" id="A">

		<table class="signup">
			<tr>
				<td align="right">{{ form.label('first_name') }}</td>
				<td>
					{{ form.render('first_name') }}
					{{ form.messages('first_name') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('last_name') }}</td>
				<td>
					{{ form.render('last_name') }}
					{{ form.messages('last_name') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('name') }}</td>
				<td>
					{{ form.render('name') }}
					{{ form.messages('name') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('confirmUsername') }}</td>
				<td>
					{{ form.render('confirmUsername') }}
					{{ form.messages('confirmUsername') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('email') }}</td>
				<td>
					{{ form.render('email') }}
					{{ form.messages('email') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('confirmEmail') }}</td>
				<td>
					{{ form.render('confirmEmail') }}
					{{ form.messages('confirmEmail') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('password') }}</td>
				<td>
					{{ form.render('password') }}
					{{ form.messages('password') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('confirmPassword') }}</td>
				<td>
					{{ form.render('confirmPassword') }}
					{{ form.messages('confirmPassword') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('business_name') }}</td>
				<td>
					{{ form.render('business_name') }}
					{{ form.messages('business_name') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('street_address') }}</td>
				<td>
					{{ form.render('street_address') }}
					{{ form.messages('street_address') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('country') }}</td>
				<td>
					{{ form.render('country') }}
					{{ form.messages('country') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('state') }}</td>
				<td>
					{{ form.render('state') }}
					{{ form.messages('state') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('suburb_town_city') }}</td>
				<td>
					{{ form.render('suburb_town_city') }}
					{{ form.messages('suburb_town_city') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('postcode') }}</td>
				<td>
					{{ form.render('postcode') }}
					{{ form.messages('postcode') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('country_code') }}</td>
				<td>
					{{ form.render('country_code') }}
					{{ form.messages('country_code') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('area_code') }}</td>
				<td>
					{{ form.render('area_code') }}
					{{ form.messages('area_code') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('phone') }}</td>
				<td>
					{{ form.render('phone') }}
					{{ form.messages('phone') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('business_type') }}</td>
				<td>
					{{ form.render('business_type') }}
					{{ form.messages('business_type') }}
				</td>
			</tr>
			{#<tr>#}
				{#<td align="right">{{ form.label('other_business_type') }}</td>#}
				{#<td>#}
					{#{{ form.render('other_business_type') }}#}
					{#{{ form.messages('other_business_type') }}#}
				{#</td>#}
			{#</tr>#}
			<tr>
				<td align="right">{{ form.label('primary_product_service') }}</td>
				<td>
					{{ form.render('primary_product_service') }}
					{{ form.messages('primary_product_service') }}
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td>
					{{ form.render('currently_import') }} {{ form.label('currently_import') }}
					{{ form.messages('currently_import') }}
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td>
					{{ form.render('currently_export') }} {{ form.label('currently_export') }}
					{{ form.messages('currently_export') }}
				</td>
			</tr>

			<tr>
				<td align="right"></td>
				<td>
					{{ form.render('terms') }} {{ form.label('terms') }}
					{{ form.messages('terms') }}
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td>
					{{ form.render('subscribe_news') }} {{ form.label('subscribe_news') }}
					{{ form.messages('subscribe_news') }}
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td>
				<div>{{ form.render('Register') }}</div>
				{#<button value="#B">Next</button>#}
				</td>
			</tr>
			{#<tr>#}
				{#<td align="right"></td>#}
				{#<td>{{ form.render('Register') }}</td>#}
			{#</tr>#}
		</table>

		{{ form.render('csrf', ['value': security.getToken()]) }}
		{{ form.messages('csrf') }}

		<hr>
			</div>
			<div class="tab-pane" id="B">
				Step 2
			</div>
			<div class="tab-pane" id="C">
				Step 3
					<div>{{ form.render('Register') }}</div>
			</div>
		</div>

	</div>
	</div>
	</form>