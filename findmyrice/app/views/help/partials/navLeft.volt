<div class="help_nav_left">
    <span>Help & FAQ's</span>
    <hr>
    <ul>
        <li><a href="/help/general/faq">General FAQ</a></li>
        {% for item in helpMenuCategories %}
            <li><a href="/help/{{ item.alias }}">{{ item.title }}</a></li>
        {% endfor %}
    </ul>

    <hr>
    <span>Need more Help?</span>
    <hr>
    <ul>
        <li>Read our support {{ link_to('help/general/faq', "FAQs") }}</li>
        <li>Or email as at {{ link_to('contact', 'findmyrice.com/contact') }}</li>
    </ul>
</div>

