{% extends 'templates/default.php' %}

{% block title %}Sign In{% endblock %}

{% block content %}
	<form action="{{ urlFor('signin.post') }}" method="post" autocomplete="off">
		<div>
			<label for="Identifier">Username/Email</label>
			<input type="text" name="identifier" id="identifier" {% if request.post('identifier') %} value="{{ request.post('identifier') }}" {% endif %}>
			{% if errors.has('identifier') %} {{ errors.first('identifier') }} {% endif %}
		</div>

		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password">
			{% if errors.has('password') %} {{ errors.first('password') }} {% endif %}
		</div>

		<div>
			<input type="checkbox" name="remember" id="remember"> <label for="remember">Remember Me</label>
		</div>

		<div>
			<input type="submit" value="Sign In">
		</div>

		<a href="{{ urlFor('pass.recover') }}">Forgot Password?</a>

		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
	</form>
{% endblock %}