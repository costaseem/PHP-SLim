{% if auth %}
	<p>Hello, {{ auth.getFullNameOrUsername }}!</p>
{% endif %}

<ul>
	<li><a href="{{ urlFor('home') }}">Home</a></li>

	{% if auth %}
		<li><a href="{{ urlFor('signout') }}">Sign Out</a></li>
		<li><a href="{{ urlFor('user.profile', {username: auth.username}) }}">Profile</a></li>
		<li><a href="{{ urlFor('pass.change') }}">Change Password</a></li>
		<li><a href="{{ urlFor('acc.profile') }}">Update Profile</a></li>
		{% if auth.isAdmin %}
			<li><a href="{{ urlFor('admin.dash') }}">Admin area</a></li>
		{% endif %}
	{% else %}
		<li><a href="{{ urlFor('signup') }}">Sign Up</a></li>
		<li><a href="{{ urlFor('signin') }}">Sign In</a></li>
	{% endif %}
	<li><a href="{{ urlFor('user.all') }}">All Users</a></li>
</ul>