<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0">
	<title>Find My Rice</title>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
	<!-- Bootstrap -->
    {{ assets.outputCss() }}
	{{ stylesheet_link('css/bootstrap.min.css') }}
	{{ stylesheet_link('css/style.css') }}
	{{ stylesheet_link('css/reset.css') }}
	{{ stylesheet_link('css/responsive.css') }}
	{{ stylesheet_link('css/dropzone.min.css') }}
	{{ stylesheet_link('css/quill.snow.css') }}
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
	{{ javascript_include("js/jquery.min.js") }}
    
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    
    <script src="https://s3.amazonaws.com/files.notifysnack.net/app/js/notifybar.js"></script>
    <script type="text/javascript">var notifyBarWidget = new NotifySnack();notifyBarWidget.init({hash:"nh56nw6"});</script>
    
    <noscript>To view this notification widget you need to have JavaScript enabled. This notification widget was easily created with <a href="http://www.notifysnack.com/" title="NotifySnack - Website bar">NotifySnack</a>.<br /></noscript>
    
</head>
<body>
<header>
	<div class="container wallaper">
		<ul class="login_menu {% if logged_in  %}login_menu_in{% else %}login_menu_out{% endif %}">
			{%- if logged_in  %}
			{% if profileRole == 'C' %}
				<li class="welcome_user">Welcome {{ profileName }}</li>
				<li class="sep_menu">|</li>
				<li class="logout_txt">{{ link_to('session/logout', 'Logout') }}</li>
				<li class="sep_menu">|</li>
				<li class="my_profile_txt">{{ link_to('company', 'My Profile') }}</li>
			{% elseif profileRole == 'A' %}
				<li class="welcome_user">Welcome {{ profileName }}</li>
				<li class="sep_menu">|</li>
				<li class="logout_txt">{{ link_to('session/logout', 'Logout') }}</li>
				<li class="sep_menu">|</li>
				<li class="my_profile_txt">{{ link_to('admin-dashboard', 'My Profile') }}</li>
				<li class="sep_menu">|</li>
				<li>{{ link_to('permissions', 'Permissions') }}</li>
			{% elseif profileRole == 'U' or profileRole == 'NC' %}
				<li class="welcome_user">Welcome {{ profileName }}</li>
				<li class="sep_menu">|</li>
				<li class="logout_txt">{{ link_to('session/logout', 'Logout') }}</li>
				<li class="sep_menu">|</li>
				<li class="my_profile_txt">{{ link_to('user', 'My Profile') }}</li>
			{% endif %}
			{% else %}
                <li>
                    <a href="#" class="log-in_menu">Login</a>
                    <form action="/session/login" class="form-search" method="post">
                        <div class="admin_login_box login_popup_box">
                            <div class="form-group">
                                <p>Login</p>
                                {{ login_form.render('email',['placeholder':'Suppliers username / Users email']) }}
                                {{ login_form.render('password') }}

                                {#<div align="center" class="remember">#}
                                {#{{ login_form.render('remember') }}#}
                                {#{{ login_form.label('remember') }}#}
                                {#</div>#}
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        {{ login_form.render('Login') }}
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 forgot_pass_txt">
                                        {{ link_to("session/forgotPassword", "Forgot your password?") }}
                                        {{ login_form.render('csrf', ['value': csrf_form]) }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </li>
			{#<li>{{ link_to('session/login', 'Login') }}</li>#}
				<li class="sep_menu">|</li>
			<li>{{ link_to('session/signupUser', 'Register') }}</li>
				<li class="sep_menu">|</li>
			<li>{{ link_to('lead', 'List Your Company') }}</li>
			{% endif %}
		</ul>
        <a onclick="img1()" href="#" id="mobile_navigation_button" class="visible-xs"><img src="/images/navicon.png"></a>
        <div class="clear"></div>
        <div id="menu_click">
            <ul class="menu_responsive">
                <li>{{  link_to("", "Home") }}</li>
                <li>{{  link_to("about", "About Us") }}</li>
                <li>{{  link_to("search/default", "Search") }}</li>
                <li>{{  link_to("events", "Events") }}</li>
                <li>{{  link_to("blog", "Blog") }}</li>
                <li>{{  link_to("contact-us", "Contact Us") }}</li>
                <li>{{  link_to("help", "Help") }}</li>
            </ul>
        </div>
	</div>
</header>

<div class="container wallaper">
    {%  if (not(error404Page is defined)) %}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 logo_box">
            <a href="/"><h1 class="logo"><img src="/images/logo.png" alt="logo"></h1></a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
            <ul class="social_box top_social_box">
                <li><a href="https://www.facebook.com/findmyrice"><img src="/images/fb_icon.png" alt="fb icon"></a></li>
                <li><a href="https://www.linkedin.com/company/find-my-rice"><img src="/images/linkedin_icon.png" alt="linkedin icon"></a></li>
                <li><a href="https://plus.google.com/100800607478397966028/posts"><img src="/images/g+_icon.png" alt="g+ icon"></a></li>
                <li><a href="https://twitter.com/findmyrice"><img src="/images/twitter_icon.png" alt="twitter icon"></a></li>
                <li><a href="https://www.pinterest.com/findmyrice/"><img src="/images/pinterest_icon.png" alt="pinterest icon"></a></li>
            </ul>
        </div>
    </div>
    {% endif %}

{{ content() }}

{% if (adminPage is empty) and (not(error404Page is defined)) %}
    {% include 'footer.volt' %}
{% endif %}
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{ javascript_include("js/bootstrap.min.js") }}
<!-- Custom scripts -->
{{ assets.outputJs() }}
{{ javascript_include("js/mobile_menu.js") }}
{{ javascript_include("js/login_popup.js") }}
</body>
</html>