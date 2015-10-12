{{ content() }}
{{ form('class': 'form-contributor') }}
<div class="container wallaper text-center">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4">
            <div class="registration_box registerContributor">
                <div class="form-group">
                    <p class="mb15">Register as a Contributor</p>
                    <button type="submit" class="fb_btn">{{ link_to('https://facebook.com', 'Register with Facebook') }}</button>
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
                    <span class="registration_txt">By signing up, you agree to our {{ link_to('terms', 'Terms & Conditions', 'class':'red_txt') }} and {{ link_to('privacy', 'Privacy Policy', 'class':'red_txt') }}.</span>
                    <div class="clearfix"></div>
                    {{ form.render('content_type') }}
                    {{ form.messages('content_type') }}
                      <div class="center_line"></div>
                      <span class="registration_txt1">Already have an account? {{ link_to('session/login', 'Log in', 'class':'red_txt') }}</span>
                    {{ form.render('csrf_contributor_set_up', ['value': csrf_form]) }}
                    {{ form.messages('csrf_contributor_set_up') }}
                </div>
            </div>

        </div>
    </div>
</div>
</form>