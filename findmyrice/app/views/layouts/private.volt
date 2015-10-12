<div class="row">
    <div class="col-lg-12 text-right">
        <ul class="secondary_menu">
            <li>{{  link_to("contact-us", "Contact Us") }}</li>
            <li>{{  link_to("help", "Help") }}</li>
            {% if profileRole == 'A' %}
                <li>{{ link_to("admin-dashboard", 'Back to Main Menu', 'class':'back_link') }}</li>
            {% endif %}
        </ul>
    </div>
</div>
</div>
  {{ content() }}