{{ form('class': 'form-search') }}
{{ content() }}

<div class="container wallaper text-center">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4">
            <div class="registration_box">
                <div class="form-group">
                        <button type="submit" class="fb_btn">{{ link_to('https://facebook.com', 'Register with Facebook') }}</button>
                        <button type="submit" class="google_btn">{{ link_to('https://plus.google.com', 'Register with Google+') }}</button>
                        <button type="submit" class="linkedin_btn">{{ link_to('https://www.linkedin.com', 'Register with Linkdin') }}</button>
                        <div class="center_line_or"></div>
                        <span class="txt_or">or</span>
                        {{ form.render('first_name') }}
                        {{ form.messages('first_name') }}
                        {{ form.render('email') }}
                        {{ form.messages('email') }}
                        {{ form.render('password') }}
                        {{ form.messages('password') }}
                        {{ form.render('Register') }}
                        <span class="registration_txt">By signing up, I agree to our {{ link_to('terms', 'Terms & Conditions', 'class':'red_txt') }} and {{ link_to('privacy', 'Privacy Policy', 'class':'red_txt') }}.</span>
                        <div class="clearfix"></div>
                        <div class="checkbox">
                            <label>
                                {{ form.render('subscribe_news') }} Yes, i would like to receive news from Find My Rice
                            </label>
                            {{ form.messages('subscribe_news') }}
                        </div>
                        <div class="center_line"></div>
                        <span class="registration_txt1">Already have an account? {{ link_to('session/login', 'Login', 'class':'red_txt') }}</span>
                    {#{{ form.render('csrf_user_set_up', ['value': security.getToken()]) }}#}
                    {{ form.render('csrf_user_set_up', ['value': csrf_form]) }}
                    {{ form.messages('csrf_user_set_up') }}

                </div>
            </div>

        </div>
    </div>
</div>
</form>