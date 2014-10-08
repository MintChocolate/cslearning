@extends('layout')

@section('title')
	Teaching Assistants
@stop

@section('javascript-extended')
	{{ HTML::script('js/danger-check.js') }}
@stop

@section('content')
	<div class="page-header">
		<h1>Teaching Assistants</h1>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>name</th>
				<th>Email</th>
				<th colspan="2" class="text-center">Options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				{{ Form::open(array('route' => 'admin.tas.store')) }}
					<td>
						<input name="ta[name]" type="text" class="form-control" 
							value="{{ Input::old('ta')['name'] }}" autofocus>
					</td>
					<td>
						<input name="ta[email]" type="email" class="form-control"
							value="{{ Input::old('ta')['email'] }}">
					</td>
					<td colspan="2">
						<button type="submit" class="btn btn-success btn-block">Add</button>
					</td>
				{{ Form::close() }}
			</tr>
			@foreach ($tas as $ta)
				<tr>
					{{ Form::open(array('route' => 'admin.tas.update', 'method' => 'put')) }}
						<input type="hidden" name="ta[id]" value="{{ $ta->id}}">
					<td>
						<input name="ta[name]" type="text" class="form-control" 
							value="{{ $ta->name }}">
					</td>
					<td>
						<input name="ta[email]" type="email" class="form-control"
							value="{{ $ta->email }}">
					</td>
					<td>
						<button type="" class="btn btn-primary btn-block">Update</button>
					</td>
					{{ Form::close() }}
					{{ Form::open(array('route' => 'admin.tas.update', 'method' => 'delete')) }}
					<td>
						<input type="hidden" name="id" value="{{ $ta->id }}">
						<button type="submit" data-name="{{ $ta->name }}" data-action="remove" class="btn btn-danger btn-block">Remove</button>
					</td>
					{{ Form::close() }}
				</tr>
			@endforeach
		</tbody>
	</table>
@stop