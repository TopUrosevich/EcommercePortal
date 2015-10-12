<div class="row user_search_box">
    <form action="/search" id="simple_search_form">
        <div class="col-lg-6 col-md-6 col-sm-6">
            {{ sp_form.render('name_pcck') }}
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="searchBox">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-11">
                        {{ sp_form.render('location') }}
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1 padding_all0">
                        <input type="submit" value="" class="primary_btn  newsletter_srch_btn">
                    </div>
                </div>
            </div>
        </div>
        {{ sp_form.render('simple_search') }}
    </form>
</div>
