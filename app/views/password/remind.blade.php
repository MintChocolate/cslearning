@extends('layout')

@section('title')
	Password Reminder
@stop
@section('content')
	<div class="row">
		<div class="col-xs-12">
			<h1>@yield('title')</h1>	
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			{{ Form::open(array('action' => 'PasswordController@postRemind','role' => 'form')) }}
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" name="email">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Send Reminder</button>
				</div>
			    
			{{ Form::close() }}	
		</div>
	</div>
@stop