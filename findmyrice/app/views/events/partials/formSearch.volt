<form class="form form-inline" action="/events/search">
    <div class="row search">
        <div class="col-lg-8 col-lg-offset-2  col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="searchBox slider_box_basic row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <input class="form-control" type="text" name="query"
                       placeholder="Search by: Country, City, Event type or event name">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding_all0">
                    {{ submit_button('', 'class': 'primary_btn newsletter_srch_btn') }}
                </div>
            </div>
        </div>
    </div>
</form>
