<div class="row filter">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="form-group chosen-btn-group">
            {{ form.render('category', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="form-group chosen-btn-group">
            {{ form.render('country', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="form-group chosen-btn-group">
            {{ form.render('city', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <a href="#" class="red_txt" id="clear_filters">Clear filters</a>
    </div>
</div>