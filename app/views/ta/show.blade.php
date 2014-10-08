@extends('layout')

@section('title')
	Profile
@stop

@section('content')
	<div class="page-header">
		<h1>{{ $ta->name }}</h1>
	</div>

	<div class="row">
		<div class="col-xs-4">
			<img id="image-preview" src="{{ asset('images/'.$profile['image']) }}" alt="{{ $ta->name }}" class="img-thumbnail">
		</div>
		<div class="col-xs-4">
			<h4>About</h4>
			<p>{{ $profile['about'] }}</p>

			<h4>Program</h4>
			<p>{{ $profile->graduate ? "Graduate" : "Undergraduate" }}</p>

			<h4>Year</h4>
			<p>{{ $profile->year }}</p>
		</div>
	</div>
@stop