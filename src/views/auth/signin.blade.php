@extends('authentify::layout')

@section('title')

	{{ Lang::get('authentify::labels.sign-in') }}

@stop

@section('content')

		{{ Form::open(array('action' => 'AuthentifyController@postSignIn')) }} 

			<div class="form-group">
				{{ Form::label('authentify-email', Lang::get('authentify::labels.email')) }} 
				{{ Form::email('email', null, array('class' => 'form-control', 'id' => 'authentify-email')) }} 
				{{ $errors->has('email') ? Form::label('authentify-email', $errors->first('email'), array('class' => 'error')) : '' }} 
			</div>

			<div class="form-group">
				{{ Form::label('authentify-password', Lang::get('authentify::labels.password')) }} 
				{{ Form::password('password', array('class' => 'form-control', 'id' => 'authentify-password')) }} 
				{{ $errors->has('password') ? Form::label('authentify-password', $errors->first('password'), array('class' => 'error')) : '' }} 
			</div>

@if(Config::get('authentify::rememberable'))
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember" value="1">
						{{{ Lang::get('authentify::labels.remember-me') }}}
					</label>
				</div>
			</div>
@endif

			{{ Form::submit(Lang::get('authentify::labels.sign-in'), array('class' => 'btn btn-block btn-primary btn-lg')) }} 

		{{ Form::close() }}

@stop