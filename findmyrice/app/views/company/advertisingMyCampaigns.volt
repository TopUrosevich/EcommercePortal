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
    <div class="row title_my_account">
        <div class="col-lg-7 col-lg-offset-2 col-md-7 col-md-offset-2 col-xs-12"><h2>Advertising</h2></div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 left_menu_box">
            {% include 'company/partials/leftMenu.volt' %}
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
            <div class="advertising_box">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        {{ link_to('company/advertising','<button type="button" class="red_btn">Advertising Options</button>') }}
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        {{ link_to('company/advertising-my-campaigns','<button type="button" class="white_btn advertising_box_btn">My Campaigns</button>') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Campaign Reporting</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="campaign_reporting_container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <p class="month_stats_txt">Last Month Stats</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="row graphic_report">
                                    <div class="graphic_report_title">
                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                            <h2>Stats Chart</h2>
                                            <button type="button">ALL</button>
                                            <button type="button">MONTH</button>
                                            <button type="button">WEEK</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 text-right">
                                            <button type="button">HITS</button>
                                            <button type="button">VIEWS</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <img src="<?php echo SITE_URL; ?>/images/advertising_graphic.png" alt="Advertising Graphic" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="row graphic_report">
                                    <div class="graphic_report_title">
                                        <div class="col-lg-12">
                                            <h2>Averages</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 averages_report">
                                            <p><strong>Views</strong><span> 254</span></p>
                                            <p><strong>Clicks</strong><span> 24</span></p>
                                            <p><strong>CTR</strong><span> 10.6%</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="month_stats_txt">Complete Stats</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product_list_area">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Views</th>
                                            <th>Hits</th>
                                            <th>CTR</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>2011-12-01</td>
                                            <td>230</td>
                                            <td>23</td>
                                            <td>10.00%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-02</td>
                                            <td>250</td>
                                            <td>30</td>
                                            <td>12.00%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-03</td>
                                            <td>255</td>
                                            <td>29</td>
                                            <td>11.37%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-04</td>
                                            <td>240</td>
                                            <td>21</td>
                                            <td>8.75%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-05</td>
                                            <td>293</td>
                                            <td>22</td>
                                            <td>7.51%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-06</td>
                                            <td>247</td>
                                            <td>29</td>
                                            <td>11.74%</td>
                                        </tr>
                                        <tr>
                                            <td>2011-12-07</td>
                                            <td>265</td>
                                            <td>24</td>
                                            <td>9.06%</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>