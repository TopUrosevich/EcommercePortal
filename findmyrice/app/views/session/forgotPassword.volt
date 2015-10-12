{{ content() }}
<div class="container wallaper forgotPassword_box">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
            {{ form('class': 'form-search') }}
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Forgot Password?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{ form.render('email', ["class": "form-control"])}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{ form.render('Send', ["class": "red_btn"]) }}
                </div>
            </div>
            </form>
        </div>
    </div>
</div>