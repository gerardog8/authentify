@extends('authentify::layout')

@section('title')

	{{ Lang::get('authentify::labels.sign-up') }}

@stop

@section('content')

		{{ Form::open(array('action' => 'AuthentifyController@postSignUp')) }} 

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

			<div class="form-group">
				{{ Form::label('authentify-password_confirmation', Lang::get('authentify::labels.password_confirmation')) }} 
				{{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'authentify-password_confirmation')) }} 
				{{ $errors->has('password_confirmation') ? Form::label('authentify-password_confirmation', $errors->first('password_confirmation'), array('class' => 'error')) : '' }} 
			</div> 

			<div class="form-group">
				{{ Form::label('authentify-name', Lang::get('authentify::labels.name')) }} 
				{{ Form::text('name', null, array('class' => 'form-control', 'id' => 'authentify-name')) }} 
				{{ $errors->has('name') ? Form::label('authentify-name', $errors->first('name'), array('class' => 'error')) : '' }} 
			</div>

			{{ Form::submit(Lang::get('authentify::labels.send'), array('class' => 'btn btn-block btn-lg btn-primary')) }} 

		{{ Form::close() }}

@stop