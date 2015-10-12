{{ content() }}
<div class="container wallaper user_profile_box">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9">
                {% include 'user/partials/headerBanner.volt' %}
                {% include 'user/partials/headerMenu.volt' %}
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
                                            <a href="/userMessage/new" class="edit_link"><i class="fa fa-pencil-square-o"></i>New</a>
                                        </div>
                                    </div>
                                    <nav class="messages_menu">
                                        <ul>
                                            <li>{{ link_to('userMessage/messages', 'Messages ') }} ({{ ct }})</li>
                                            <li>{{ link_to('userMessage/sent', 'Sent') }}</li>                                        
                                            <li>{{ link_to('userMessage/trash', 'Trash') }}</li>
                                        </ul>
                                    </nav>
                                </div>
                                {% if message %}
                                {% set i = 1 %}
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 inbox_left_part edit_link_right">
                                    <div class="row inbox_left_top">
                                        <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">All Messages<b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <li>{{ link_to('userMessage/messages', 'All messages') }}</li>
                                                    <li>{{ link_to('userMessage/unread', 'Unread') }}</li>
                                                </ul>
                                            </li>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 text-right">
                                            <ul class="messages_icon">
                                                <li><a href="/userMessage/reply/{{ message._id }}"><img src="../../images/detail_reply_1.png" id="reply{{ i }}" onMouseOver="replyOver_detail({{ i }})" onMouseOut="replyOut_detail({{ i }})" alt=""/><p id="pReply{{ i }}" onMouseOver="pReplyOver_detail({{ i }})" onMouseOut="pReplyOut_detail({{ i }})">Reply</p></a></li>
                                                <li><a href="/userMessage/forward/{{ message._id }}"><img src="../../images/detail_forward_1.png" id="forward{{ i }}" onMouseOver="forwardOver_detail({{ i }})" onMouseOut="forwardOut_detail({{ i }})" alt=""/><p id="pForward{{ i }}" onMouseOver="pForwardOver_detail({{ i }})" onMouseOut="pForwardOut_detail({{ i }})">Forward</p></a></li>
                                                <li><a href="/userMessage/delete/{{ message._id }}"><img src="../../images/detail_trash_1.png" id="trash{{ i }}" onMouseOver="trashOver_detail({{ i }})" onMouseOut="trashOut_detail({{ i }})" alt=""/><p id="pTrash{{ i }}" onMouseOver="pTrashOver_detail({{ i }})" onMouseOut="pTrashOut_detail({{ i }})">Trash</p></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="user_message">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-7">
                                                <h2>{{ message.name }}</h2>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 message_month">
                                                <h5>{{ message.created_at }}</h5>
                                            </div>
                                        </div>
                                        <div class="row mt10">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <a href="#" class="active">{{ message.email }}</a>
                                            </div>
                                        </div>
                                        <div class="row mt10">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <p style="word-wrap:break-word;">{{ message.message }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt10">
                                        </div>
                                    </div>
                                    <div class="row" id="beforUserClick" style="display: block;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                            <textarea rows="5" onclick="detailReply()" class="form-control" placeholder="click to reply"></textarea>
                                        </div>
                                    </div>
                                    <form action="/userMessage/detail" method="post" id="afterUserClick" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                            {{ form.render("id") }}
                                            {{ form.render("email") }}
                                            {{ form.render("subject") }}
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
                                                {{ link_to('userMessage/messages', '<input type="button" class="blue_btn" value="Cancel" />') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {% include 'user/partials/rightBanner.volt' %}
        </div>
    </div>
</div>