{{ content() }}

<div class="container wallaper_935 admin_dashboard_box">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_widgets_box">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb10 col-xs-6">
                    <a href="#" title=""><img src="/images/dashboard_admin.png" alt="" /></a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                    <a href="#" title=""><img src="/images/dashboard_advertising.png" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 center_widgets_box">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12  col-xs-6 mb10">
                    <a href="#" title=""></a>
                    {{ link_to('admin/manage-users','<img src="/images/dashboard_user_management.png" alt="" />','title':'Manage users') }}
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12  col-xs-6">
                    {{ link_to('manageNews','<img src="/images/dashboard_news.png" alt="" />','title':'Manage news') }}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right_widgets_box">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 mb10">
                    {{ link_to('manageEvents','<img src="/images/dashboard_events.png" alt="" />','title':'Manage events') }}
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                    {{ link_to('help/manage/categories','<img src="/images/dashboard_help.png" alt="" />','title':'Manage help') }}
                </div>
            </div>
        </div>
    </div>
</div>