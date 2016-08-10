{% extends	'mail/templates/default.php' %}

{% block content %} 
	<p>You have registered!</p>

	<a href="{{ baseUrl }}{{ urlFor('activate') }}?m={{ user.email }}&id={{ identifier }}">Activate your account now!</a>
{% endblock %}