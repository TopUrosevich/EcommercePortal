{{ content() }}
<div class="container wallaper news_blog_box">
    <div class="container_heading">
        <h2>News/Blog</h2>
    </div>
    <div class="nav_manage">
        {% include 'manageNews/partials/navManage.volt' %}
    </div>
    <div>
        <form action="/manageNews/deleteContributors" method="post">
            <div class="rwd_table">
                <table id="manage-contributors" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>News Contributors</th>
                            <th>Total Articles</th>
                            <th>Country</th>
                            <th>Last Published</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for contributor in contributors %}
                        <tr>
                            <td>
                                <input type="checkbox" name="contributor[{{ contributor._id }}]">
                                {{ contributor.first_name }} {{ contributor.last_name }}
                            </td>
                            <td>
                                {{ contributor.getTotalArticles() }}
                            </td>
                            <td>
                                {{ contributor.country }}
                            </td>
                            <td>
                                {{ contributor.getLastPublished() }}
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
            <div class="div_table_btn">
                {{ submit_button('Delete Contributor', 'class': 'primary_btn') }}
            </div>
        </form>
    </div>
</div>