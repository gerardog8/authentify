<?php

Route::filter('authentify.check', function () {
	if (Auth::guest()) {
		if (Request::ajax()) {
			return Response::make('Unauthorized', 401);
		}
		else {
			return Redirect::guest(URL::action('AuthentifyController@getSignIn'));
		}
	}
});

Route::filter('authentify.guest', function () {
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('authentify.config', function ($route, $request, $param) {
	$param = 'authentify::' . $param;

	if (!Config::get($param)) {
		App::abort(404);
	}
});

Route::filter('authentify.permission', function ($route, $request, $param) {
	if (!(Auth::check() && Auth::user()->can($param))) {
		App::abort(404);
	}
});

Route::filter('authentify.role', function ($route, $request, $param) {
	if (!(Auth::check() && Auth::user()->hasRoles($param))) {
		App::abort(404);
	}
});

Event::listen('auth.login', function($user) {
	$user->login_at = new DateTime;
	$user->save();
});
