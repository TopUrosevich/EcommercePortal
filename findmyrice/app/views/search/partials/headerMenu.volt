<div class="row">
    <div class="col-lg-12">
        <nav role="navigation" class="navbar navbar-default main_menu">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse_supplier" data-toggle="collapse"
                        class="navbar-toggle">
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
                    <li>{{ link_to('user', 'Profile Home') }}</li>
                    <li class="menu_separate">|</li>
                    <li>{{ link_to('user/edit', 'Edit Profile') }}</li>
                </ul>
            </div>
        </nav>
    </div>
</div>