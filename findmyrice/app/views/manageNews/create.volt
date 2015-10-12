{{ content() }}
<div class="container wallaper news_blog_box" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="container_heading">
                <h2>News/Blog</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="nav_manage">
                {% include 'manageNews/partials/navManage.volt' %}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form_description">
                <span>Submit Article</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <form method="post" autocomplete="off">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    </div>
                </div>
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
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                    {{ form.render('category_id', ['class': 'form-control form_control']) }}
                                    <span class="text-danger">
                                {{ form.hasMessagesFor('category_id') ? form.getMessagesFor('category_id')[0] : '' }}
                                </span>
                                </div>
                                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-offset-0 col-sm-5 col-xs-12">
                                    {{ form.render('date', ['class': 'form-control form_control']) }}
                                    <span class="text-danger">
                        {{ form.hasMessagesFor('date') ? form.getMessagesFor('date')[0] : '' }}
                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            {{ form.render('image',['class': 'form-control form_control', 'placeholder': 'Main Image URL']) }}
                            <span class="text-danger">
                                {{ form.hasMessagesFor('image') ? form.getMessagesFor('image')[0] : '' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {% include 'manageNews/partials/quill.volt' %}
                        <div class="form-group" style="display: none;">
                            {{ form.render('content', [
                            'class': 'form-control  form_control',
                            'placeholder': 'Article content...',
                            'rows': 15
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
                            {{ form.render('publish', ['class': 'checkbox checkbox-inline checkbox_inline']) }}
                            {{ form.label('publish') }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            {{ form.render('submit', ['class': 'primary_btn']) }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <form action="/manageNews/uploadImage" class="dropzone dz-clickable" id="images_dropzone">
                <div class="dz-message">
                    Drop images here or click to upload.<br>
                    (728 x 380 px)
                </div>
            </form>
        </div>
    </div>
</div>