<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{{ Lang::get('authentify::emails.welcome.title') }}}</h2>

		<div>
			{{{ Lang::get('authentify::emails.welcome.body') }}} {{ URL::action ('AuthentifyController@getSignIn') }}.
		</div>
	</body>
</html>
