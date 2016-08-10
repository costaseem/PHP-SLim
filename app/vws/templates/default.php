<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>GRS | {% block title %}{% endblock %}</title>
	</head>
	<body>
		{% include 'templates/partials/messages.php' %}
		{% include 'templates/partials/navigation.php' %}
		{% block content %}{% endblock %}
	</body>
</html>
