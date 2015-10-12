<div class="row mt10 mb10">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
        {%  if events_count == 1 %}
            <span class="all_events">{{ events_count }} event was found.</span>
        {% elseif events_count == 0 %}
            <span class="all_events">No event was found.</span>
        {%  elseif events_count != 1 %}
            <span class="all_events">{{ events_count }} events was found.</span>
        {%  endif %}
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-5 text-right">
        <div class="btn-group btn-group-sm grid_list" role="group" aria-label="View">
            <a href="?view=grid" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-th-large"></span> Grid
            </a>
            <a href="?view=list" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-th-list"></span> List
            </a>
        </div>
    </div>
</div>
<div class="row mb10">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div>
            <span>Sort by: </span>
            <select>
                <option value="category">Category</option>
                <option value="country">Country</option>
                <option value="city">City</option>
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 items_page">
        <span>Items per page: </span>
        <select>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
        </select>
        <button type="button" class="filter_view_all">View All</button>
    </div>
</div>
<div class="row mb10">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <span>Showing 1-12 of 43 Results</span>
    </div>
    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 pagination_events">
            <ul>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>|</li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </a>
                </li>
            </ul>
    </div>
</div>
