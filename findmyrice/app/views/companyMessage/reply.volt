
{{ content() }}
<div class="container wallaper profile_box">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="row title_my_account">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Inbox</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="inbox_box">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="row inbox_left_top">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="/companyMessage/new" class="edit_link"><i class="fa fa-pencil-square-o"></i>New</a>
                                    </div>
                                </div>
                                <nav class="messages_menu">
                                    <ul>
                                        <li>{{ link_to('company/messages', 'Messages ') }} ({{ ct }})</li>
                                        <li>{{ link_to('companyMessage/sent', 'Sent') }}</li>
                                        <li>{{ link_to('companyMessage/trash', 'Trash') }}</li>
                                    </ul>
                                </nav>
                            </div>
                            <form action="/companyMessage/reply" method="post">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 inbox_left_part">
                                {{ form.render("id") }}
                                <div class="user_message">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-12 col-sm-7 col-xs-7">
                                            {{ form.render("email") }}
                                            {{ form.messages("email") }}
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-lg-7 col-md-12 col-sm-7 col-xs-7">
                                            {{ form.render("subject") }}
                                            {{ form.messages("subject") }}
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-lg-7 col-md-12 col-sm-7 col-xs-7">
                                        {{ form.render("message") }}
                                        {{ form.messages("message") }}
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-lg-3 text-left">
                                        {{ form.render('send') }}
                                        </div>
                                        <div class="col-lg-3 text-left">
                                        {{ link_to('company/messages', '<input type="button" class="blue_btn" value="Cancel" />') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>