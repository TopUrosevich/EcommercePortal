<div class="row" id="header_nav_menu_2">
        <div class="col-lg-12 text-center">
            <nav role="navigation" class="navbar navbar-default main_menu">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <p class="navbar-brand menu_txt">Menu</p>
                </div>
                <!-- Collection of nav links and other content for toggling -->
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>{{  link_to("", "Home") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("about", "About Us") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("search/default", "Search") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("events", "Events") }}</li>
                        {#<li class="menu_separate">|</li>#}
                        {#<li>{{  link_to("inspiration", "Inspiration") }}</li>#}
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("blog", "Blog") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("contact-us", "Contact Us") }}</li>
                        <li class="menu_separate">|</li>
                        <li>{{  link_to("help", "Help") }}</li>
                    </ul>
                </div>
            </nav>
        </div>
</div>
</div>
  {{ content() }}