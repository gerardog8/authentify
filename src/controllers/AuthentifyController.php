<?php

class AuthentifyController extends BaseController {
	
	public function __construct() {
		$this->beforeFilter('authentify.config:registerable', array('only' => array('getSignUp', 'postSignUp')));
		$this->beforeFilter('authentify.config:remindable', array('only' => array('getRemind', 'postRemind', 'getReset', 'postReset')));
		$this->beforeFilter('authentify.config:confirmable', array('only' => array('getActivate')));
		$this->beforeFilter('authentify.check', array('only' => array('getAccount', 'postAccount', 'postPassword', 'postSignOut')));
		$this->beforeFilter('authentify.guest', array('only' => array('getSignIn', 'postSignIn', 'getSignUp', 'postSignUp', 'getRemind', 'postRemind', 'getReset', 'postReset')));
	}

	public function getSignIn() {
		return View::make('authentify::auth.signin');
	}

	public function postSignIn() {
		$rules = array_only(User::getRules(), array('email', 'password'));
		$input = Input::only(array_keys($rules));

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::action('AuthentifyController@getSignIn')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} 
		else {
			$userdata = $input;
			$userdata['active'] = 1;

			if (Auth::attempt($userdata)) {
				return Redirect::intended(URL::to('/'));
			} 
			else {
				return Redirect::action('AuthentifyController@getSignIn')
					->withInput(Input::except('password'))
					->with('notice.message', Lang::get('authentify::messages.signin.error'))
					->with('notice.status', 'warning');
			}
		}
	}

	public function getSignUp() {
		return View::make('authentify::auth.signup');
	}

	public function postSignUp() {
		$rules = array_except(User::getRules(), 'id');
		$input = Input::only(array_keys($rules));

		$rules['email'] .= '|unique:users';

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::action('AuthentifyController@getSignUp')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else {
			$password = Input::get('password');

			$user_row = array_except($input, 'password_confirmation');

			if (!Config::get('authentify::confirmable')) {
				$user_row['active'] = 1;				
			}

			$user = User::create($user_row);

			if ($user) {
				$token = Crypt::encrypt($user->id);

				if (Config::get('authentify::confirmable')) {
					Mail::send('authentify::emails.activate', compact('user', 'password', 'token'), function ($message) use ($user) {
						$message->to($user->email, $user->name)->subject(Lang::get('authentify::emails.activate.subject'));
					});
				}
				elseif (Config::get('authentify::welcomeable')) {
					Mail::send('authentify::emails.welcome', compact('user', 'password'), function ($message) use ($user) {
						$message->to($user->email, $user->name)->subject(Lang::get('authentify::emails.welcome.subject'));
					});
				}

				return Redirect::action('AuthentifyController@getSignIn')
					->withInput(Input::only('email'))
					->with('notice.message', Lang::get('authentify::messages.signup.success'))
					->with('notice.status', 'success');
			}
			else {
				return Redirect::action('AuthentifyController@getSignUp')
					->withInput(Input::except('password', 'password_confirmation'))
					->with('notice.message', Lang::get('authentify::messages.signup.error'))
					->with('notice.status', 'warning');
			}
		}
	}

	public function getActivate($token) {
		$id = Crypt::decrypt($token);
		$user = User::find($id);

		if (!($user && !$user->active)) {
			App::abort(404);
		}

		$user->active = true;
		$user->save();

		if (Config::get('authentify::welcomeable')) {
			Mail::send('authentify::emails.welcome', compact('user', 'password', 'token'), function ($message) use ($user) {
				$message->to($user->email, $user->name)->subject(Lang::get('authentify::emails.welcome.subject'));
			});
		}

		return Redirect::action('AuthentifyController@getSignIn')
			->with('notice.message', Lang::get('authentify::messages.activate.success'))
			->with('notice.status', 'success');
	}

	public function getRemind() {
		return View::make('authentify::auth.remind');
	}

	public function postRemind() {
		$input = Input::only('email');
		$rules = array('email' => 'required|email|exists:' . Config::get('authentify::tables.users'));
		$validator = Validator::make($input, $rules);

		if ($validator->passes()) {
			$response = Password::remind($input, function ($message) {
				$message->subject(Lang::get('authentify::emails.remind.subject'));
			});

			switch($response) {
				case Password::INVALID_USER :
					return Redirect::action('AuthentifyController@getRemind')
						->with('notice.message', Lang::get($response))
						->with('notice.status', 'warning');
				break;
				case Password::REMINDER_SENT :
					return Redirect::action('AuthentifyController@getSignIn')
						->with('notice.message', Lang::get($response))
						->with('notice.status', 'success');
				break;
			}
		}
		else {
			return Redirect::action('AuthentifyController@getRemind')
				->withErrors($validator);
		}
	}

	public function getReset($token = NULL) {
		return View::make('authentify::auth.reset', compact('token'));
	}

	public function postReset() {
		$credentials = Input::only('email', 'password', 'password_confirmation', 'token');

		$response = Password::reset($credentials, function ($user, $password) {
			$user->password = $password;
			$user->save();
		});

		switch($response) {
			case Password::INVALID_PASSWORD :
			case Password::INVALID_TOKEN :
			case Password::INVALID_USER :
				return Redirect::action('AuthentifyController@getReset')
					->with('notice.message', Lang::get($response))
					->with('notice.status', 'warning');
			break;
			case Password::PASSWORD_RESET :
				return Redirect::action('AuthentifyController@getSignIn')
					->with('notice.message', Lang::get('authentify::messages.reset.success'))
					->with('notice.status', 'success');
			break;
		}
	}

	public function getAccount() {
		return View::make('authentify::auth.account');
	}

	public function postAccount() {
		$user = Auth::user();

		$rules = array_except(User::getRules(), array('password', 'password_confirmation'));
		$input = Input::only(array_keys($rules));

		$rules['email'] .= '|unique:users,email,' . $user->id;

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::action('AuthentifyController@getAccount')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else {
			if ($user->update($input)) {
				$notice = array('message' => Lang::get('authentify::messages.account.success'), 'status' => 'success');
			}
			else {
				$notice = array('message' => Lang::get('authentify::messages.account.error'), 'status' => 'warning');
			}

			return Redirect::action('AuthentifyController@getAccount')->with('notice', $notice);
		}
	}

	public function postPassword() {
		$rules = array_only(User::getRules(), array('password', 'password_confirmation'));
		$input = Input::only(array_keys($rules));

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::action('AuthentifyController@getAccount')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else {
			$password = Input::get('password');

			$user = Auth::user();
			$user->password = $password;

			if ($user->save()) {
				$notice = array('message' => Lang::get('authentify::messages.password.success'), 'status' => 'success');
			}
			else {
				$notice = array('message' => Lang::get('authentify::messages.password.error'), 'status' => 'warning');
			}

			return Redirect::action('AuthentifyController@getAccount')->with('notice', $notice);
		}
	}

	public function getSignOut() {
		Auth::logout();
		return Redirect::action('AuthentifyController@getSignIn');
	}
}
