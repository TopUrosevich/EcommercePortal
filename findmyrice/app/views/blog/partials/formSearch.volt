{#
<div class="news_search row">
    <form class="form form-inline" action="/blog/search">
        <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
            <div class="form-group">
                <input class="form-control form_control" type="text" name="query"
                       placeholder="Search by: Keyword, Company Name, Country, City etc.">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
                {{ submit_button('Search', 'class': 'primary_btn') }}
            </div>
        </div>
    </form>
</div>#}
<div class="news_search row">
    <form class="form form-inline" action="/blog/search">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
            <div class="searchBox slider_box_basic row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-11">
                    <input class="form_control srch_input" type="text" name="query"
                           placeholder="Search by: Keyword, Company Name, Country, City etc.">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1 padding_all0">
                    {{ submit_button('', 'class': 'primary_btn newsletter_srch_btn') }}
                </div>
            </div>
            </div>
        </form>
    </div>
