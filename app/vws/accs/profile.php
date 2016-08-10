{% extends 'templates/default.php' %}

{% block title %}Update Profile{% endblock %}

{% block content %}
	<form action="{{ urlFor('acc.profile.post') }}" method="post" autocomplete="off">
		<div>
			<label for="email">Email</label>
			<input type="text" name="email" id="email" {% if request.post('email') %} value="{{ request.post('email') }}" {% endif %}>
			{% if errors.has('email') %} {{ errors.first('email') }} {% endif %}
		</div>

		<div>
			<label for="first_name">First Name</label>
			<input type="text" name="first_name" id="first_name" {% if request.post('first_name') %} value="{{ request.post('first_name') }}" {% endif %}>
			{% if errors.has('first_name') %} {{ errors.first('first_name') }} {% endif %}
		</div>

		<div>
			<label for="last_name">Last Name</label>
			<input type="text" name="last_name" id="last_name" {% if request.post('last_name') %} value="{{ request.post('last_name') }}" {% endif %}>
			{% if errors.has('last_name') %} {{ errors.first('last_name') }} {% endif %}
		</div>

		<div>
			<input type="submit" value="Update">
		</div>

		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
	</form>
{% endblock %}