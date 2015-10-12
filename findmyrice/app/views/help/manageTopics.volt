{{ content() }}
{{ javascript_include("js/help/tinymce/js/tinymce/tinymce.min.js") }}
{{ javascript_include("js/help/manage_tinymce.js") }}
<div class="container wallaper">
    <div class="help_container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="container_heading">
                    <h2>Help Menu</h2>
                </div>
                <div class="nav_manage">
                    {% include 'help/partials/navManage.volt' %}
                </div>
                <form method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form_description">
                                        <span>Add New Topic</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {{ form.render('title', [
                                        'class': 'form-control form_control',
                                        'placeholder': 'Enter title here'
                                        ]) }}
                                        <span class="text-danger">
                                {{ form.hasMessagesFor('title') ? form.getMessagesFor('title')[0] : '' }}
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {{ form.render('alias', [
                                        'class': 'form-control  form_control',
                                        'placeholder': 'Enter alias here'
                                        ]) }}
                                        <span class="text-danger">
                                {{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}
                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {{ form.render('content',[
                                        'class': 'form-control  form_control',
                                        'placeholder': 'Help content...',
                                        'rows': 10
                                        ]) }}
                                        <span class="text-danger">
                                {{ form.hasMessagesFor('content') ? form.getMessagesFor('content')[0] : '' }}
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {{ form.label('top_faq') }}
                                        {{ form.render('top_faq', ['class': 'checkbox checkbox-inline']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="div_table_head">
                                        <div>Category</div>
                                    </div>
                                </div>
                            </div>
                                {% for category in categories %}
                                    <div class="row div_table_row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            {{ form.render('category_id', ['value': category._id]) }}
                                            {{ category.title }}
                                        </div>
                                    </div>
                                {% endfor %}
                                <div class="row div_table_row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <span class="text-danger">
                                           {{ form.hasMessagesFor('category_id') ? form.getMessagesFor('category_id')[0] : '' }}
                                        </span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ submit_button('Add New Help Topic', 'class': 'primary_btn') }}
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="/help/manage/delete-topics" method="post">
                    <div class="rwd_table">
                        <table id="manage-topics" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Topic Title</th>
                                <th>Help Category</th>
                                <th>Top FAQ</th>
                                <th>Order</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for topic in topics %}
                            <tr>
                                <td style="cursor:pointer; ">
                                    <input type="checkbox" name="topic[{{ topic._id }}]">
                                    <a href="/help/manage/topicsEdit/{{ topic._id }}">{{ topic.title }}</a>
                                </td>
                                <td>
                                    {{ topic.getCategory().title }}
                                </td>
                                <td>
                                    <input type="checkbox" {{ topic.top_faq ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ topic.order }}
                                </td>
                                <td>
                                    {% if !loop.first %}
                                    <a href="/help/manage/swap-topics-order?tid={{ topic._id }}&move=up">
                                        <span class="glyphicon glyphicon-arrow-up glyphicon_red" aria-hidden="true"></span>
                                    </a>
                                    {% endif %}
                                    {% if !loop.last %}
                                    <a href="/help/manage/swap-topics-order?tid={{ topic._id }}&move=down">
                                        <span class="glyphicon glyphicon-arrow-down  glyphicon_red" aria-hidden="true"></span>
                                    </a>
                                    {% endif %}
                                </td>
                            </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                    </div>

                    <div class="div_table_btn">
                        {{ submit_button('Delete Topic', 'class': 'primary_btn') }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>