<div class="row filter">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="form-group chosen-btn-group">
            {{ form.render('category', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="form-group chosen-btn-group">
            {{ form.render('country', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="form-group chosen-btn-group">
            {{ form.render('city', ['class': 'select_btn form-control form_control']) }}
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <a href="#" class="red_txt" id="clear_filters">Clear filters</a>
    </div>
</div>