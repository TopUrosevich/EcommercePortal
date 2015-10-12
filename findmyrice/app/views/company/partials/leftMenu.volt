{% set actionName = router.getActionName() %}
{% set activeClassIndex = '' %}
{% set activeClassEdit = '' %}
{% set activeClassPlsa = '' %}
{% set activeClassAdv = '' %}
{% set activeClassGallery = '' %}
{% set activeClassCa = '' %}
{% set activeClassConnection = '' %}
{% set activeClassMes = '' %}
{% set activeNewMessage = 'newMessageNotice' %}
{% set activeNewMessageFont = 'newMessageNoticeFont' %}
{% set activeClassMembershipF = '' %}
{% if (actionName == "index") %}
    {% set activeClassIndex = "active"  %}
{% elseif actionName == "edit" %}
    {% set activeClassEdit = "active"  %}
{% elseif actionName == "productListServiceArea" %}
    {% set activeClassPlsa = "active"  %}
{% elseif (actionName == "advertising"
            or actionName == "advertisingBanner"
            or actionName == "advertisingSelfService"
            or actionName == "advertisingMyCampaigns"
            or actionName == "badgeIcon") %}
    {% set activeClassAdv = "active"  %}

{% elseif actionName == "gallery" %}
    {% set activeClassGallery= "active"  %}
{% elseif actionName == "certificationAwards" %}
    {% set activeClassCa= "active"  %}
{% elseif actionName == "connection" %}
    {% set activeClassConnection= "active"  %}
{% elseif actionName == "messages" or actionName == "unread" or actionName == "reply" or actionName == "forward" or actionName == "sent" or actionName == "archive" or actionName == "trash" or actionName == "delete" or actionName == "detail"  or actionName == "new"  or actionName == "starred"  or actionName == "inmail"  or actionName == "blocked" %}
    {% set activeClassMes= "active"  %}
    {% set activeNewMessage = "newActiveMessageNotice" %}
    {% set activeNewMessageFont = "newActiveMessageNoticeFont" %}
{% elseif actionName == "membershipForm" %}
    {% set activeClassMembershipF = "active"  %}
{% else %}
    {% set activeClassIndex = "active"  %}
{% endif %}



<nav role="navigation" class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <p class="navbar-brand menu_txt">My Account</p>
    </div>
    <!-- Collection of nav links and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="left_menu nav navbar-nav">
            <li>{{ link_to('company/index','My Account', 'class': activeClassIndex ) }}</li>
            <li>{{ link_to('company/edit','Profile', 'class': activeClassEdit) }}</li>
            <li>{{ link_to('company/gallery','Gallery', 'class': activeClassGallery) }} </li>
            <li>{{ link_to('company/product-list-service-area','Product Lists &  Service Area', 'class':'long_world '~ activeClassPlsa ) }}</li>
            <li>{{ link_to('company/certification-awards','Certification & Awards', 'class':'long_world '~ activeClassCa) }}</li>
            {% if newMessageCount %} <li>{{ link_to('company/messages','Messages   <div class="'~activeNewMessage~'"><p class="'~activeNewMessageFont~'">'~newMessageCount~'</p></div>', 'class': activeClassMes) }}</li>{% else %}<li>{{ link_to('company/messages','Messages', 'class': activeClassMes) }}</li>{% endif %}
            <li>{{ link_to('company/connection','Connections', 'class': activeClassConnection) }}</li>
            {#<li>{{ link_to('company/membership-form','Membership Form', 'class':'long_world '~ activeClassMembershipF) }}</li>#}
            <li>{{ link_to('company/advertising','Advertising', 'class': activeClassAdv) }}</li>
            <li></li>
        </ul>
    </div>
</nav>
