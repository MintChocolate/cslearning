@extends('layout')

@section('title')
	Password Reset
@stop

@section('content')
	<div class="row">
		<div class="col-xs-4">
			<div class="row">
				<div class="col-xs-12">
					<h1>@yield('title')</h1>	
				</div>
			</div>
			{{ Form::open(array('action' => 'PasswordController@postReset')) }}
				<input type="hidden" name="token" value="{{ $token }}">
				<div class="form-group">
					<label for="email">Email</label>
					<input id="email" type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input id="password" type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="password_confirmation">Password Confirmation</label>
					<input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Reset Password</button>
			{{ Form::close() }}
		</div>	
	</div>
	
@stop