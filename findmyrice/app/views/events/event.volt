{{ content() }}

{% set organiser = event.getOrganiser() %}

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            {{ link_to("events", '<i class="fa fa-chevron-left"></i> Back', 'class':'red_txt back_link') }}
        </div>
    </div>
    <div class="events_header">
        {% if event.image_origin %}
            <img src="{{ event.image_origin }}"  class="main_image">
        {% else %}
            <img src="/images/events/{{ category.alias }}/event.jpg" class="main_image">
        {% endif %}
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="info">
                    <div class="name">
                        {{ event.event_name }}
                    </div>
                    <div class="category">
                        {{ category.title }}
                    </div>
                    <div class="details">
                        {{ date('d', event.start_date) }} - {{ date('d M Y', event.end_date) }}
                        <span class="separate">|</span>
                        {{ event.venue }}
                        <span class="separate">|</span>
                        <span>{{ event.city }}, {{ event.country }}</span>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="events_container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="events_attend events_border">
                    <nav class="nav nav_top">
                        <ul>
                            <li><a href="#" data-toggle="modal" data-target="#attendModal">Remind me</a></li>|
                            <li>
                                <span id="like" style="cursor: pointer;" class="glyphicon glyphicon-heart glyphicon_red"></span>
                                <span id="like_count" event-id="{{ event._id }}">{{ event.getFavoritesCount() }}</span> Favorites
                            </li>|
                            <li>{{ event.getAttendingPeopleCount() }} People Attending</li>
                        </ul>
                    </nav>
                </div>
                <div class="events_description events_border">
                    {{ event.description }}
                </div>
                <div class="row">
                    <div class="events_share">
                        <div class="col-lg-1 col-md-1 col-xs-2">
                            <div class="share_label">Share</div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                            <ul class="social_box">
                                <li><a href="http://www.facebook.com/sharer.php?u={{ url(router.getRewriteUri()) }}&t={{ event.event_name }}">
                                        <img src="/images/fb_icon.png" alt="fb icon"></a></li>
                                <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url(router.getRewriteUri()) }}">
                                        <img src="/images/linkedin_icon.png" alt="linkedin icon"></a></li>
                                <li><a href="https://plusone.google.com/_/+1/confirm?hl=en&url={{ url(router.getRewriteUri()) }}">
                                        <img src="/images/g+_icon.png" alt="g+ icon"></a></li>
                                <li><a href="http://twitter.com/share?url={{ url(router.getRewriteUri()) }}&text={{ event.event_name }}">
                                        <img src="/images/twitter_icon.png" alt="twitter icon"></a></li>
                                <li><a href="http://www.pinterest.com/pin/create/button/?url={{ url(router.getRewriteUri()) }}&description={{ event.event_name }}&media={{ event.image_preview }}">
                                        <img src="/images/pinterest_icon.png" alt="pinterest icon"></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                            <div class="share_label">Invite a friend</div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                            <ul class="social_box">
                                <li><a href="#" data-toggle="modal" data-target="#sendEmailModal"><img src="/images/email_icon.png" alt="email icon"></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                            <div class="share_label">Add</div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-10 col-xs-10">
                            <div class="events_add_to_calendar">
                            <span class="addtocalendar atc-style-icon atc-style-menu-wb">
                                <a class="atcb-link">
                                    <img src="/images/cal_icon.png" width="32">
                                </a>
                                <var class="atc_event">
                                    <var class="atc_date_start">{{ date('Y-m-d h:m:s', event.start_date) }}</var>
                                    <var class="atc_date_end">{{ date('Y-m-d h:m:s', event.end_date) }}</var>
                                    {% if event.timezone %}
                                        <var class="atc_timezone">{{ event.timezone }}</var>
                                    {% else %}
                                        <var class="atc_timezone">Europe/London</var>
                                    {% endif %}
                                    <var class="atc_title">{{ event.event_name }}</var>
                                    <var class="atc_description">{{ event.description }}</var>
                                    <var class="atc_location">{{ event.venue }}</var>
                                    <var class="atc_organizer">{{ organiser.contact_name }}</var>
                                    <var class="atc_organizer_email">{{ event.enquiry_email }}</var>
                                </var>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="container_heading">
                            <span>Venue Information</span>
                        </div>
                        <div class="events_venue events_border">
                            <div class="events_text_primary">{{ event.venue }}</div>
                            <div class="events_text_secondary">
                                {{ event.street_address }}
                                <div class="events_text_secondary">{{ event.city }}, {{ event.country }}</div>
                                <div class="events_text_secondary">{{ event.time }}</div>
                            </div>
                            <div class="events_map">
                                {{ map }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="container_heading">
                            <span>Organiser</span>
                        </div>
                        <div class="events_organiser events_border">
                            <div class="events_text_primary">{{ organiser.organiser_name }}</div>
                            <div class="events_text_secondary">{{ organiser.contact_name }}</div>
                            <div class="events_text_secondary">{{ organiser.city }}, {{ organiser.country }}</div>

                            <div class="events_link_btn">
                               <button class="primary_btn" id="contact_organiser" type="button">Contact Organiser</button>
                            </div>

                            <div  id="contactOrganiser" style="display: none">
                                <div>
                                    <div class="content">
                                        <div class="header">
                                            <button type="button" class="close">
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </button>
                                            <h4 id="contactLabel">Contact Organiser</h4>
                                        </div>
                                        <form action="/events/contact-organiser" method="post">
                                            <div>
                                                <div class="events_contact_links">
                                                    <div class="row">{{ link_to(event.website, 'Website') }}</div>
                                                    {% if event.facebook %}
                                                        <div class="row">{{ link_to(event.facebook, 'Facebook') }}</div>
                                                    {% endif %}
                                                    {% if event.facebook %}
                                                        <div class="row">{{ link_to(event.twitter, 'Twitter') }}</div>
                                                    {% endif %}
                                                    {% if event.facebook %}
                                                        <div class="row">{{ link_to(event.instagram, 'Instagram') }}</div>
                                                    {% endif %}
                                                </div>
                                                {{ contactForm.render('event_id', ['value': event._id]) }}
                                                <div class="form-group">
                                                    {{ contactForm.render('name', ['class': 'form-control required', 'placeholder': 'Name']) }}
                                                    <span class="text-danger">
                            {{ contactForm.hasMessagesFor('name') ? contactForm.getMessagesFor('name')[0] : '' }}
                        </span>
                                                </div>
                                                <div class="form-group">
                                                    {{ contactForm.render('email', ['class': 'form-control required', 'placeholder': 'Email']) }}
                                                    <span class="text-danger">{{ contactForm.hasMessagesFor('email') ? contactForm.getMessagesFor('email')[0] : '' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    {{ contactForm.render('message', ['class': 'form-control required', 'rows': 5, 'placeholder': 'Message']) }}
                                                    <span class="text-danger">
                            {{ contactForm.hasMessagesFor('message') ? contactForm.getMessagesFor('message')[0] : '' }}
                        </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="primary_btn">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="container_heading">
                            <span>Related Events</span>
                        </div>
                        <div class="events_related events_border">
                            <div class="row">
                                <div class="events_inner">
                                    {% for related in relatedEvents %}
                                        <div class="col-lg-3 col-md-3">
                                            <div class="date">
                                                {{ date('d M', related.start_date) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="events_text_primary">
                                               <a href="/events/{{ category.alias }}/{{ related._id }}">{{ related.event_name }}</a>
                                                {#{{ related.event_name }}#}
                                            </div>
                                            <div class="events_text_secondary">
                                                {{ related.city }}, {{ related.country }}
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                            <div class="events_link_btn">
                                <a href="/events/filter/category/{{ category.alias }}">
                                    <button class="primary_btn" type="button">All {{ category.title }} Events</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="container_heading">
                            <span>More Events in {{ event.city }}</span>
                        </div>
                        <div class="events_more events_border">
                            <div class="row">
                                <div class="events_inner">
                                    {% for more in moreEvents %}
                                        <div class="col-lg-3 col-md-3">
                                            <div class="date">
                                                {{ date('d M', more.start_date) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="events_text_primary">
                                                <a href="/events/{{ category.alias }}/{{ more._id }}">{{ more.event_name }}</a>
                                                {#{{ more.event_name }}#}
                                            </div>
                                            <div class="events_text_secondary">
                                                {{ more.city }}, {{ more.country }}
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                            <div class="events_link_btn">
                                <a href="/events/filter/country/{{ more.country | lower }}/city/{{ more.city | lower }}">
                                    <button class="primary_btn" type="button">All Events in {{ more.city }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 left_events_box feature_events_box">
                <div class="container_heading text-center">
                    <span>Featured Events</span>
                </div>
                <div class="row">
                {% for featured in featuredEvents %}
                    <div class="col-lg-12 col-md-12 col-sm-6">
                        <a href="/events/{{ f_category.alias }}/{{ featured._id }}">
                            <div class="events_preview">
                                {% if featured.image_preview %}
                                    <img src="{{ featured.image_preview }}">
                                {% else %}
                                    <img src="/images/events/default-preview.jpg">
                                {% endif %}
                                {#<div class="venue">{{ featured.event_name }}</div>#}
                                <div class="venue">
                            {{ featured.event_name }}
                                </div>

                                <div class="date">
                                    {{ date('d', featured.start_date) }} - {{ date('d M Y', featured.end_date) }}
                                </div>
                                {% set f_category = featured.getCategory() %}
                                <div class="location">{{ featured.city }}, {{ featured.country }}</div>
                                <div class="category">{{ f_category.title }}</div>
                                <div class="explore">
                                    <p class="red_txt">Explore Event</p>
                                </div>
                            </div>
                        </a>
                    </div>
                {% endfor %}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attendModal" tabindex="-1" role="dialog"
     aria-labelledby="attendModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="attendLabel">Remind me</h4>
            </div>
            <form action="/events/attend" method="post">
                <div class="modal-body">
                    {{ attendForm.render('event_id', ['value': event._id ]) }}
                    <div class="form-group">
                        {{ attendForm.render('name', ['class': 'form-control form_control required', 'placeholder': 'Name']) }}
                        <span class="text-danger">
                            {{ attendForm.hasMessagesFor('name') ? attendForm.getMessagesFor('name')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ attendForm.render('email', ['class': 'form-control form_control required', 'placeholder': 'Email']) }}
                        <span class="text-danger">
                            {{ attendForm.hasMessagesFor('email') ? attendForm.getMessagesFor('email')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ attendForm.render('city', ['class': 'form-control form_control required', 'placeholder': 'City']) }}
                        <span class="text-danger">
                            {{ attendForm.hasMessagesFor('city') ? attendForm.getMessagesFor('city')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {{ attendForm.render('company', ['class': 'form-control form_control required', 'placeholder': 'Company']) }}
                        <span class="text-danger">
                            {{ attendForm.hasMessagesFor('company') ? attendForm.getMessagesFor('company')[0] : '' }}
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="primary_btn">Remind me</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog"
     aria-labelledby="sendEmailModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <h4 class="modal-title" id="sendEmailLabel">Send Email</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input id="email_for_sent" type="text" class="form-control form_control required" placeholder="Email">
                </div>
                <div class="form-group">
                    <input value="Event {{ event.event_name }}" id="subject_for_sent" type="text" class="form-control form_control required" placeholder="Subject">
                </div>
                <div class="form-group">
                    <textarea id="message_for_sent" rows="5" class="form-control form_control required" placeholder="Message">Event {{ event.event_name }}&#13;&#10;{{ event.venue }}&#13;&#10;{{ organiser.street_address }}, {{ organiser.city }}, {{ organiser.country }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button id="send_email" type="submit" class="primary_btn">Send</button>
            </div>
        </div>
    </div>
</div>

{{ mapJs }}