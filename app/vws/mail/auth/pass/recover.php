{% extends	'mail/templates/default.php' %}

{% block content %} 
	<p>You requested a password change.</p>
	<p><a href="{{ baseUrl }}{{ urlFor('pass.reset') }}?m={{ user.email }}&id={{ identifier }}">Click here to reset your password!</a></p>
{% endblock %}