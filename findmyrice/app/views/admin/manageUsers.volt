{{ content() }}
<div class="container wallaper manage_users_box">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    {{ link_to("admin/create", "<i class='icon-plus-sign'></i> Create Users", "class": "btn btn-primary red_btn") }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ url("admin/search") }}" autocomplete="off">
                        <div class="center scaffold">
                            <h2>Search Users or Companies</h2>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="name">Name</label>
                                    {{ form.render("name") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="email">E-Mail</label>
                                    {{ form.render("email") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="profilesId">Profile</label>
                                    {{ form.render("profilesId") }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    {{ submit_button("Search", "class": "btn btn-primary red_btn mt10") }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>