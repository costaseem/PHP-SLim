{% extends 'templates/default.php' %}

{% block title %} {{ user.getFullNameOrUsername }} {% endblock %}

{% block content %}
	<h2>{{ user.getUsername }}</h2>
	<dl>
		{% if user.getFullName %}
			<dt>Full Name</dt>
			<dd>{{ user.getFullName }}</dd>
		{% endif %}

		<dt>Email</dt>
		<dd>{{ user.email }}</dd>
	</dl>
{% endblock %}