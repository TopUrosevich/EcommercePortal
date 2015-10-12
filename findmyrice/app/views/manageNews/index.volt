{{ content() }}

<div class="container wallaper news_blog_box">
    <div class="news_container">
        <div class="container_heading">
            <h2>News/Blog</h2>
        </div>
        <div class="nav_manage">
            {% include 'manageNews/partials/navManage.volt' %}
        </div>
        <div>
            <form action="/manageNews/delete" method="post">
                <div class="rwd_table">
                <table id="manage-news" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Article</th>
                        <th>Category</th>
                        <th>Total Views</th>
                        <th>Publish</th>
                        <th>Date Published</th>
                        <th class="changes_col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for article in articles %}
                        <tr>
                            <td>
                                <input type="checkbox" name="article[{{ article._id }}]">
                                {{ article.title }}
                            </td>
                            <td class="col-lg-2 col-md-2">
                                {{ article.getCategory().title }}
                            </td>
                            <td class="col-lg-2 col-md-2">
                                {{ article.total_views }}
                            </td>
                            <td class="col-lg-1 col-md-1">
                                <input type="checkbox" {{ article.publish ? 'checked' : '' }}>
                            </td>
                            <td class="col-lg-2 col-md-2">
                                {{ date('Y/m/d', article.date) }}
                            </td>
                            <td class="col-lg-1 col-md-1">
                                <a href="/manageNews/edit/{{ article._id }}">
                                    <span title="Edit" class="glyphicon glyphicon-edit glyphicon_red"></span>
                                </a>
                                <a href="/blog/{{ article.getCategory().alias }}/{{ article.alias }}">
                                    <span title="View" class="glyphicon glyphicon-eye-open glyphicon_red"></span>
                                </a>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
                    </div>
                <div class="div_table_btn">
                    {{ submit_button('Delete Article', 'class': 'primary_btn') }}
                </div>
            </form>
        </div>
    </div>
</div>