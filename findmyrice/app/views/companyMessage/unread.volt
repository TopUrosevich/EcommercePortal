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
            <form method="post" autocomplete="off" id="unread_messages">
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
                                {% set active = "active" %}
                                <nav class="messages_menu">
                                    <ul>
                                        <li>{{ link_to('company/messages', 'Messages ') }} ({{ ct }})</li>
                                        <li>{{ link_to('companyMessage/sent', 'Sent') }}</li>
                                        <li>{{ link_to('companyMessage/trash', 'Trash') }}</li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 inbox_left_part">
                                <div class="row inbox_left_top">
                                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12" id="menuCustom">
                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Unread<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li>{{ link_to('company/messages', 'All messages') }}</li>
                                                <li>{{ link_to('companyMessage/unread', 'Unread') }}</li>
                                            </ul>
                                        </li>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <a href="#" onclick="unreadTrash()"><i class="fa fa-trash"></i>Trash</a>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" id="markCustom">
                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">More<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onclick="unreadMarkRead()">Mark read</a></li>
                                                <li><a href="#" onclick="unreadMarkUnread()">Mark Unread</a></li>
                                            </ul>
                                        </li>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                                        <input type="checkbox" id="all_check" onclick="check_all({{ page_num }})" />
                                    </div>
                                </div>
                                {% if messages %}
                                {% set i = 0 %}
                                {% 
                                    for message in messages
                                %}
                                {% set i += 1 %}
                                {% if ((page_num-1)*limit)<i and i<=(page_num*limit) %}
                                <div class="user_message" onMouseOver="eachMessageOver({{ i }})" onMouseOut="eachMessageOut({{ i }})" style="cursor:pointer;">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6" onclick="location.href='/companyMessage/detail/{{ message._id }}'" style="cursor:pointer;">
                                        {% if message.read == '1' %}<h2 id="messageName{{ i }}">{{ message.name }}</h2>{% else %}<h2 id="messageName{{ i }}" style="font-weight:bold;">{{ message.name }}</h2>{% endif %}
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 message_month" onclick="location.href='/companyMessage/detail/{{ message._id }}'" style="cursor:pointer;">
                                            {% if message.read == '1' %}<h5 id="messageCreatedAt{{ i }}">{{ message.created_at }}</h5>{% else %}<h5 id="messageCreatedAt{{ i }}" style="font-weight:bold;">{{ message.created_at }}</h5>{% endif %}
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 message_check">
                                            {{ form.render("each_check" ~ i) }}
                                            {{ form.render("messageId" ~ i, ["value" : message._id]) }}
                                        </div>
                                    </div>
                                    <div class="row mt10" onclick="location.href='/companyMessage/detail/{{ message._id }}'" style="cursor:pointer;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            {% if message.read == '1' %}<a href="#" class="active">{{ message.email }}</a>{% else %}<a href="#" class="active" style="font-weight:bold">{{ message.email }}</a>{% endif %}
                                        </div>
                                    </div>
                                    <div class="row mt10" onclick="location.href='/companyMessage/detail/{{ message._id }}'" style="cursor:pointer;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            {% if message.read == '1' %}<p id="messageMessage{{ i }}" style="word-wrap:break-word;">{{ message.message }}</p>{% else %}<p id="messageMessage{{ i }}" style="font-weight:bold; word-wrap:break-word;">{{ message.message }}</p>{% endif %}
                                        </div>
                                    </div>
                                    <div class="row mt10" id="icons{{ i }}" style="display:none;">
                                        <div class="col-lg-12 text-right">
                                            <ul class="messages_icon">
                                                <li><a href="/companyMessage/reply/{{ message._id }}"><img src="../../images/left_arrow_1.png" id="reply{{ i }}" onMouseOver="replyOver({{ i }})" onMouseOut="replyOut({{ i }})" alt=""/></a></li>
                                                <li><a href="/companyMessage/forward/{{ message._id }}"><img src="../../images/right_arrow_1.png" id="forward{{ i }}" onMouseOver="forwardOver({{ i }})" onMouseOut="forwardOut({{ i }})" alt=""/></a></li>
                                                <li><a href="/companyMessage/delete/{{ message._id }}"><img src="../../images/trash_icon_1.png" id="trash{{ i }}" onMouseOver="trashOver({{ i }})" onMouseOut="trashOut({{ i }})" alt=""/></a></li>
                                            </ul>
                                        </div>
                                        <div id="reply_popup{{ i }}" style="display:none; width:56px; height:31px; margin-left:505px;" ><img src="../../images/reply_popup.png" /></div>
                                        <div id="forward_popup{{ i }}" style="display:none; width:71px; height:31px; margin-left:535px;" ><img src="../../images/forward_popup.png" /></div>
                                        <div id="trash_popup{{ i }}" style="display:none; width:60px; height:31px; margin-left:580px;" ><img src="../../images/trash_popup.png" /></div>
                                    </div>
                                </div>
                                {% endif %}
                                {% endfor %}
                                {% else %}
                                <div class="user_message">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1"><p>There are no messages.</p></div>
                                    </div>
                                </div>
                                {% endif %}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        <p class="message_pagination">
                                            <a href="/companyMessage/unread/1"><i class="fa fa-fast-backward"></i></a>
                                            {% if page_num != 1 %}<a href="/companyMessage/unread/{{ page_num - 1 }}"> <i class="fa fa-caret-left"></i></a>
                                            {% else %}<a href="/companyMessage/unread/1"> <i class="fa fa-caret-left"></i></a>{% endif %}
                                            Page {{ page_num }} of {{ m_co }}
                                            {% if page_num != m_co %}<a href="/companyMessage/unread/{{ page_num + 1 }}"> <i class="fa fa-caret-right"></i></a>
                                            {% else %}<a href="/companyMessage/unread/{{ m_co }}"> <i class="fa fa-caret-right"></i></a>{% endif %}
                                            <a href="/companyMessage/unread/{{ m_co }}"><i class="fa fa-fast-forward"></i></a>
                                        </p>
                                    </div>
                                </div>
                                {{ form.render("m_ct", ["value" : m_ct]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>