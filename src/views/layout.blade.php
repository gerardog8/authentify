<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('page-title', 'Authenfify')</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('packages/gerardog8/authentify/css/authentify.css') }}">
</head>
<body>
	<div class="authentify-container">
		<h1 class="text-center">@yield('title', 'Authentify')</h1>
		<div class="authentify-box">
@if(Session::has('notice.message'))
			<div class="alert alert-{{ Session::get('notice.status') }}">
				{{ Session::get('notice.message') }}
			</div>
@endif
			@yield('content')
		</div>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>