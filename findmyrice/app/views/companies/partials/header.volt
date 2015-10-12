{{ content() }}
<div class="wallaper container supplier_profile_box">
    <div class="row">
        <div class="col-lg-12">
            {{ link_to("", '<i class="fa fa-chevron-left"></i> Back', 'class':'red_txt back_link') }}
        </div>
    </div>
</div>
<div class="col-lg-12 supplier_images">
    <div class="supplier_main_img">
        <img src="{{ profile.profile_image }}" alt="supplier profile" />
    </div>
    <div class="wallaper container">
        <div class="supplier_logo_img">
            <img src="{{ profile.logo }}" alt="supplier logo" />
        </div>
    </div>
</div>
<div class="wallaper container supplier_profile_box">
    <div class="row supplier_main">
        <div class="col-lg-12 text-center">
            <nav role="navigation" class="navbar navbar-default main_menu">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse_supplier" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <p class="navbar-brand menu_txt">Menu</p>
                </div>
                <!-- Collection of nav links and other content for toggling -->
                <div id="navbarCollapse_supplier" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>{{ link_to("companies/about/"~company_id, "About") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{ link_to("companies/"~create_alias(profile.title)~"/gallery/"~company_id, "Gallery") }}</li>
                        <li class="menu_separate">|</li>
                        <li><a href="#">250 Connections</a></li>
                        <li class="menu_separate">|</li>
                        <li><a href="#"><span id="like_count" company-id="{{ company._id }}">{{ company.getFavoritesCount() }}</span> Favourites</a></li>
                        <li class="menu_separate">|</li>
                        <li><a href="#"><span id="like">+ Favourite Supplier</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="widgets top_widgets_box">
                <h2>{{ profile.title }}</h2>
                <em class="dfn">{{ profile.tagline }}</em>
                <em class="dfn">{{ profile.short_description }}</em>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <p class="red_txt">Produce - {{ company.business_type }}</p>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-right widgets_social">

                        <p class="red_txt">Connect</p>
                        <ul class="social_box">
                            <li><a href="{{ profile.facebook }}"><img src="/images/fb_icon_mini.png" alt="fb icon"></a></li>
                            <li><a href="{{ profile.linkdin }}"><img src="/images/linkedin_icon_mini.png" alt="linkedin icon"></a></li>
                            <li><a href="{{ profile.google_plus }}"><img src="/images/g+_icon_mini.png" alt="g+ icon"></a></li>
                            <li><a href="{{ profile.twitter }}"><img src="/images/twitter_icon_mini.png" alt="twitter icon"></a></li>
                            <li><a href="{{ profile.pinterest }}"><img src="/images/pinterest_icon_mini.png" alt="fb icon"></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>