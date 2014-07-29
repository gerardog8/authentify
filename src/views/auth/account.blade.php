@extends('authentify::layout')

@section('title')

	{{ Lang::get('authentify::labels.my-account') }}

@stop

@section('content')

		{{ Form::model(Auth::user(), array('action' => 'AuthentifyController@postAccount')) }} 
			<fieldset>
				<legend>{{ Lang::get('authentify::labels.my-account') }}</legend>

				<div class="form-group">
					{{ Form::label('authentify-email', Lang::get('authentify::labels.email')) }} 
					{{ Form::email('email', null, array('class' => 'form-control', 'id' => 'authentify-email')) }} 
					{{ $errors->has('email') ? Form::label('authentify-email', $errors->first('email'), array('class' => 'error')) : '' }} 
				</div>

				<div class="form-group">
					{{ Form::label('authentify-name', Lang::get('authentify::labels.name')) }} 
					{{ Form::text('name', null, array('class' => 'form-control', 'id' => 'authentify-name')) }} 
					{{ $errors->has('name') ? Form::label('authentify-name', $errors->first('name'), array('class' => 'error')) : '' }} 
				</div>

				{{ Form::submit(Lang::get('authentify::labels.update'), array('class' => 'btn btn-block btn-lg btn-primary')) }} 
			</fieldset>
		{{ Form::close() }} 
		<hr>
		{{ Form::model(Auth::user(), array('action' => 'AuthentifyController@postPassword')) }} 
			<fieldset>
				<legend>{{ Lang::get('authentify::labels.change-password') }}</legend>

				<div class="form-group">
					{{ Form::label('authentify-password', Lang::get('authentify::labels.password')) }} 
					{{ Form::password('password', array('class' => 'form-control', 'id' => 'authentify-password')) }} 
					{{ $errors->has('password') ? Form::label('authentify-password', $errors->first('password'), array('class' => 'error')) : '' }} 
				</div>

				<div class="form-group">
					{{ Form::label('authentify-password_confirmation', Lang::get('authentify::labels.password_confirmation')) }} 
					{{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'authentify-password_confirmation')) }} 
					{{ $errors->has('password_confirmation') ? Form::label('authentify-password_confirmation', $errors->first('password_confirmation'), array('class' => 'error')) : '' }} 
				</div>

				{{ Form::submit(Lang::get('authentify::labels.update'), array('class' => 'btn btn-block btn-lg btn-primary')) }} 
			</fieldset>
		{{ Form::close() }} 


@stop