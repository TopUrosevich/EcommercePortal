{{ content() }}
{{ javascript_include("js/alias_generator.js") }}

<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="news_container">
        <div class="container_heading">
            <h2>News/Blog</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageNews/partials/navManage.volt' %}
        </div>
        <div class="form_description">
            <span>Edit Article</span>
        </div>
        <div class="col-lg-9 col-md-9">
            <form method="post" autocomplete="off">
                <div class="row">
                    <div class="form-group">
                        {#{{ form.label('title') }}#}
                        {{ form.render('title',['class': 'form-control form_control', 'placeholder': 'Title']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('title') ? form.getMessagesFor('title')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        {#{{ form.label('alias') }}#}
                        {{ form.render('alias', ['class': 'form-control form_control', 'placeholder': 'Alias']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('alias') ? form.getMessagesFor('alias')[0] : '' }}
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                {{ form.render('category_id', ['class': 'form-control form_control']) }}
                                <span class="text-danger">
                                {{ form.hasMessagesFor('category_id') ? form.getMessagesFor('category_id')[0] : '' }}
                            </span>
                            </div>
                            <div class="col-lg-2 col-md-2"></div>
                            <div class="col-lg-4 col-md-4">
                                {{ form.render('date', ['class': 'form-control form_control']) }}
                                <span class="text-danger">
                                {{ form.hasMessagesFor('date') ? form.getMessagesFor('date')[0] : '' }}
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ form.render('image',['class': 'form-control form_control', 'placeholder': 'Main Image URL']) }}
                        <span class="text-danger">
                            {{ form.hasMessagesFor('image') ? form.getMessagesFor('image')[0] : '' }}
                            </span>
                    </div>
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
                    <div class="form-group">
                        {{ form.label('publish') }}
                        <input type="checkbox" id="publish" name="publish" {{ article.publish ? 'checked' : '' }}>
                    </div>
                    <div class="form-group">
                        {{ form.render('submit', ['class': 'primary_btn']) }}
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3">
            <form action="/manageNews/uploadImage" class="dropzone dz-clickable" id="images_dropzone">
                <div class="dz-message">
                    Drop images here or click to upload.<br>
                    (728 x 380 px)
                </div>
            </form>
        </div>
    </div>
</div>
