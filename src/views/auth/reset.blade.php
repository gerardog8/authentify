@extends('authentify::layout')

@section('title')

	{{ Lang::get('authentify::labels.reset-password') }}

@stop

@section('content')

		{{ Form::open(array('action' => 'AuthentifyController@postReset')) }} 
			{{ Form::hidden('token', $token) }} 

			<div class="form-group">
				{{ Form::label('authentify-email', Lang::get('authentify::labels.email')) }} 
				{{ Form::email('email', null, array('class' => 'form-control', 'id' => 'authentify-email')) }} 
				{{ $errors->has('email') ? Form::label('authentify-email', $errors->first('email'), array('class' => 'error')) : '' }} 
			</div>

			<div class="form-group">
				{{ Form::label('authentify-password', Lang::get('authentify::labels.new-password')) }} 
				{{ Form::password('password', array('class' => 'form-control', 'id' => 'authentify-password')) }} 
				{{ $errors->has('password') ? Form::label('authentify-password', $errors->first('password'), array('class' => 'error')) : '' }} 
			</div>

			<div class="form-group">
				{{ Form::label('authentify-password_confirmation', Lang::get('authentify::labels.new-password_confirmation')) }} 
				{{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'authentify-password_confirmation')) }} 
				{{ $errors->has('password_confirmation') ? Form::label('authentify-password_confirmation', $errors->first('password_confirmation'), array('class' => 'error')) : '' }} 
			</div> 

			{{ Form::submit(Lang::get('authentify::labels.send'), array('class' => 'btn btn-block btn-lg btn-primary')) }} 
		{{ Form::close() }}

@stop