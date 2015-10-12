<div class="recipes_pagination">
    <a href="{{ paginationUrl ~ 1 }}">First</a>
    {% for number in [page.current-2,page.current-1,page.current,page.current+1,page.current+2]
    if (number > page.current and number <= page.last) or (number < page.current and number >= page.first) or (number == page.current) %}
        <a href="{{ paginationUrl ~ number }}">{{ number }}</a>
    {% endfor %}
    <a href="{{ paginationUrl ~ page.next }}">Next</a>
</div>