<nav class="nav_top text-center">
    <hr>
    <ul>
        {% for category in categories  %}
        <li><a href="/blog/{{ category.alias }}">{{ category.title }}</a> </li>
        {% if !loop.last %}
        <li class="menu_separate">|</li>
        {% endif %}
        {% endfor %}
    </ul>
    <hr>
</nav>