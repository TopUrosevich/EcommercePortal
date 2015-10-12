<div class="row">
    <div class="col-lg-12 text-right">
        <a href="#" class="red_txt advanced_search_btn">Advanced Search</a>
    </div>
</div>
<div class="row mt10" id="advanced_search" style="display: none;">
    <div class="col-lg-12">
        <div class="advanced_search_box">
            <div class="col-lg-12">
                <h2 class="red_txt mt10 mb10">Advanced Search</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="get" action="search">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ ad_form.render('company_name') }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ ad_form.render('product_or_service') }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group chosen-btn-group">
                                        {{ ad_form.render('company_category') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group chosen-btn-group">
                                        {{ ad_form.render('business_type') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group chosen-btn-group">
                                        {{ ad_form.render('country') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                    <div class="flaticon-a2cornerdwnrt enter_arrow"></div>
                                </div>
                                <div class="col-lg-11 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group chosen-btn-group">
                                        {{ ad_form.render('state') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-1">
                                    <div class="flaticon-a2cornerdwnrt enter_arrow"></div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-9">
                                    <div class="form-group chosen-btn-group">
                                        {{ ad_form.render('city') }}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row mt10">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt10">
                                            <label class="checkbox-inline">
                                                {{ ad_form.render('importers') }}
                                                Importers
                                            </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt10">
                                            <label class="checkbox-inline">
                                                {{ ad_form.render('exporters') }}
                                                Exporters
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right user_search_btn">
                                    <button type="submit" class="red_btn">Search</button>
                                </div>
                            </div>
                        </div>
                        {{ ad_form.render('advanced_search') }}
                    </form>
                </div>
            </div>


        </div>
    </div>


</div>