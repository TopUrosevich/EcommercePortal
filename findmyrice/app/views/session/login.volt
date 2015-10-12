{{ content() }}
{{ form('class': 'form-search') }}
<div class="container wallaper text-center">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4">
            <div class="admin_login_box">
                <div class="form-group">
                    <p>Login</p>
                    {{ form.render('email',['placeholder':'Suppliers username / Users email']) }}
                    {{ form.render('password') }}
                    <p class="red_txt">{{ link_to("session/forgotPassword", "Forgot Username or Password?") }}</p>
                    {{ form.render('csrf', ['value': security.getToken()]) }}
                    {#<div align="center" class="remember">#}
                        {#{{ form.render('remember') }}#}
                        {#{{ form.label('remember') }}#}
                    {#</div>#}
                    {{ form.render('Login') }}

                </div>
            </div>

        </div>
    </div>
</div>
</form>