{{ content() }}
 {% for type, messages in flashSession.getMessages() %}
     {% for message in messages %}
         <div class="alert alert-{{ type }}">
             <button type="button" class="close" data-dismiss="alert">&times;</button>
             {{ message }}
         </div>
     {% endfor%}
 {% endfor %}
{#{{ flashSession.output() }}#}

<div class="container wallaper profile_box">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="row title_my_account">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Advertising</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="advertising_box">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-5">
                                {{ link_to('company/advertising','<button type="button" class="white_btn advertising_box_btn">Advertising Options</button>') }}
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-5">
                                {{ link_to('company/advertising-my-campaigns','<button type="button" class="red_btn">My Campaigns</button>') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Advertising on Find My Rice</h4>
                                <p class="advertisingBox_info">
                                    You can begin advertising on Find My Rice in just a few minutes. Whether you are looking to promote a new product or service, communicate with exisiting or new customers through our newsletters or have a prepared banner ad of your own we have a number of different low cost options to get you started.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Self-service Ads</h4>
                                <p class="advertisingBox_info">
                                    Shown on the right-hand side of each page self-service ads are the quickest and easiest form of advertising you can do. You can be set up in just a few minutes and have complete flexibility on the content of the ad. The ads are created using our easy to follow template so your ad will look consistent and most important professional.
                                    <a href="#" class="red_txt">View sample</a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-5">
                                {{ link_to('company/create-a-self-service-ad', '<button type="button" class="red_btn">Create self-service ad</button>') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Banner Ads</h4>
                                <p class="advertisingBox_info">
                                    If you already have your own ads banner ads are a great way to increase awareness of your brand or products. Banner ads can be highly visual and stand out from the rest of the page content. Banner ads can be found at the top of most pages on Find My Rice so are one of the first things a user will see.
                                    <a href="#" class="red_txt">View sample</a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-5">
                                {{ link_to('company/advertising-banner', '<button type="button" class="red_btn">Create banner ad</button>') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>