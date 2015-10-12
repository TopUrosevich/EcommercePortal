{{ content() }}
<div class="container">
    <div class="help_container">
        <div class="container_heading">
            <h2>Help Menu</h2>
        </div>
        <div class="nav_manage">
            {% include 'help/partials/navManage.volt' %}
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form_description">
                            <span>Add New Help Menu</span>
                        </div>
                    </div>
                </div>
                <form method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {#{{ form.label('title') }}#}
                                {{ form.render('title',['class': 'form-control form_control', 'placeholder': 'Title']) }}
                                <span class="text-danger">
                            {{ form.hasMessagesFor('title') ? form.getMessagesFor('title')[0] : '' }}
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {#{{ form.label('alias') }}#}
                                {{ form.render('alias', ['class': 'form-control form_control', 'placeholder': 'Alias']) }}
                                <span class="text-danger">
                            {{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {#{{ form.label('parent_id') }}#}
                                {{ form.render('parent_id', ['class': 'form-control form_control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ submit_button('Save Category', 'class': 'primary_btn') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="rwd_table">
                    <form action="/help/manage/delete-categories" method="post">
                        <table id="manage-categories" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Category Title</th>
                                <th>Order</th>
                                <th>Parent</th>
                                <th>Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for category in categories %}
                            <tr>
                                <td style="cursor:pointer;">
                                    <input type="checkbox" name="category[{{ category._id }}]">
                                    <a href="/help/manage/categoriesEdit/{{ category._id }}">{{ category.title }}</a>
                                </td>
                                <td>
                                    {{ category.order }}
                                    {% if !loop.first %}
                                    <a href="/help/manage/swap-categories-order?cid={{ category._id }}&move=up">
                                        <span class="glyphicon glyphicon-arrow-up glyphicon_red" aria-hidden="true"></span>
                                    </a>
                                    {% endif %}
                                    {% if !loop.last %}
                                    <a href="/help/manage/swap-categories-order?cid={{ category._id }}&move=down">
                                        <span class="glyphicon glyphicon-arrow-down  glyphicon_red" aria-hidden="true"></span>
                                    </a>
                                    {% endif %}
                                </td>
                                <td>
                                    {% if category.parent_id %}
                                        {{ category.getParent().title }}
                                    {% endif %}
                                </td>
                                <td>
                                    {{ category.getTopicsCount() }}
                                </td>
                            </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                        <div class="div_table_btn">
                            {{ submit_button('Delete Category', 'class': 'primary_btn') }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
