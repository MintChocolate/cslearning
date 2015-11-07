@extends('layout')

@section('title')
	Profile
@stop

@section('javascript-extended')
	{{ HTML::script('js/file-input.js') }}
	{{ HTML::script('js/image-preview.js') }}
@stop

@section('content')
	<div class="page-header">
		<h1>{{ $name }}</h1>
	</div>

	<div class="row">
		<div class="col-xs-4">
			<h4>Image</h4>
			{{ Form::open(array('route' => 'ta.profile.image', 'files' => true)) }}
				<div class="form-group">
					<label>Image Preview:</label>
					<img id="image-preview" src="{{ asset('images/'.$profile['image']) }}" alt="{{ $name }}" class="img-thumbnail">
				</div>
				<div class="form-group">
					<label>Choose Image:</label>
					<button id="file" type="button" class="btn btn-default btn-block">No file chosen</button>
					<input type="file" name="file" accept="image/*" style="display:none;">
				</div>
				<div class="form-group">
					<button class="btn btn-purple btn-block">Upload</button>
				</div>
			{{ Form::close() }}
		</div>
		<div class="col-xs-4">
			<h4>Description</h4>
			{{ Form::open(array('route' => 'ta.profile.update', 'method' => 'PUT')) }}
				<div class="form-group">
					<label class="control-label" for="name">Name:</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ $name }}" required>
				</div>
				<div class="form-group">
					<label class="control-label" for="about">About:</label>
					<textarea class="form-control" id="about" name="profile[about]">{{ $profile['about'] }}</textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="graduate">Program:</label>
					<select name="profile[graduate]" required class="form-control" id="graduate">
						<option value="0">Undergraduate</option>
						<option value="1" {{ $profile->graduate ? "selected":""}} >Graduate</option>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label" for="year">Year:</label>
					<input type="number" class="form-control" min="1" id="year" max="8" name="profile[year]" required value="{{ $profile->year }}">
				</div>

{{-- 				<div class="form-group">
					<button class="btn btn-primary btn-block">Update</button>
				</div>

			{{ Form::close() }} --}}
		</div>
		<div class="col-xs-4">
			<h4>I can help with the following courses:</h4>
			<ul>
				@foreach ($added_courses as $added_course)
					<li><label class="control-label">{{$added_course}}</label></li>
				@endforeach
			</ul>

			<h4>Add more courses by selecting from the list:</h4>
			{{-- {{ Form::open(array('route' => 'ta.profile.update', 'method' => 'PUT')) }} --}}
				@foreach ($can_be_added_courses as $can_be_added_course)
					<div class="form-group">
						<input type="checkbox" id="selected_courses" name="{{$can_be_added_course['id']}}" value="{{$can_be_added_course['id']}}">
						<label class="control-label">{{$can_be_added_course['course_string']}}</label>
					</div>
				@endforeach	
				<h4>Or add a new course:</h4>
				<div class="form-group">
					<label class="control-label">Course ID:</label>
					CSCI <input type="number" id="new_course_id" name="new_course_id">
					<label class="control-label">Course Name:</label>
					<input type="text" id="new_course_name" name="new_course_name">
				</div>
				<div class="form-group">
					<button class="btn btn-primary btn-block">Update</button>
				</div>
{{-- 				<input type="hidden" class="form-control" id="name" name="name" value="{{ $name }}" required> --}}
			{{ Form::close() }}
		</div>
	</div>
@stop