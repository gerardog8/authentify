@extends('authentify::layout')

@section('title')

	{{ Lang::get('authentify::labels.reset-password') }}

@stop

@section('content')

		{{ Form::open(array('action' => 'AuthentifyController@postRemind')) }} 

			<div class="form-group">
				{{ Form::label('authentify-email', Lang::get('authentify::labels.email')) }} 
				{{ Form::email('email', null, array('class' => 'form-control', 'id' => 'authentify-email')) }} 
				{{ $errors->has('email') ? Form::label('authentify-email', $errors->first('email'), array('class' => 'error')) : '' }} 
			</div>

			{{ Form::submit(Lang::get('authentify::labels.send'), array('class' => 'btn btn-block btn-lg btn-primary')) }}  

		{{ Form::close() }}

@stop