<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap.min.css') }}
        {% if styles is defined %}
            {% for css in styles %}
                {{ stylesheet_link('css/'~ css ~'.css') }}
            {% endfor %}
        {% endif %}
        {{ stylesheet_link('css/style.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your invoices">
        <meta name="author" content="Phalcon Team">
    </head>
    <body>
        {{ content() }}
        {{ javascript_include('js/jquery.min.js') }}
        {{ javascript_include('js/bootstrap.min.js') }}
        {{ javascript_include('js/utils.js') }}
        {% if scripts is defined %}
            {% for js in scripts %}
                {{ javascript_include('js/'~ js ~'.js') }}
            {% endfor %}
        {% endif %}
    </body>
</html>
