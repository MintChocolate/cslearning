@extends('layout')

@section('title')
	Availability
@stop

@section('javascript-extended')
	{{ HTML::script('js/danger-check.js') }}
	{{ HTML::script('js/file-input.js') }}
	{{ HTML::script('js/reminder.js') }}
@stop

@section('content')
	<div class="page-header">
		<h1>Availability</h1>
	</div>

		<ol class="breadcrumb pull-right">
			<li>
				<a href="#import" data-toggle="modal" data-target="#import">Import</a>
			</li>
			<li>
				<a href="#export" class="btn-link" data-toggle="modal" data-target="#export">Export</a>
			</li>
		</ol>

	{{ Form::open(array('route' => 'admin.settings.store','class' => 'form-inline')) }}
		<label><abbr title="Teaching Assitants allowed to make changes to their availability?">Changes Allowed</abbr>:</label>
		<input type="hidden" name="setting[name]" value="Availability Changes Allowed">
		<label>
			<input type="radio" name="setting[value]" value="Yes" @if ($changes_allowed->value == "Yes") checked @endif > Yes
		</label>
	
		<label>
			<input type="radio" name="setting[value]" value="No" @if ($changes_allowed->value == "No") checked @endif> No
		</label>
	
		<button class="btn btn-primary">Save</button>
	{{ Form::close() }}

	<div class="modal fade" id="import" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4>Import</h4>
				</div>
				{{ Form::open(array('route' => 'admin.availability.import', 'files' => true)) }}
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label" for="import-day">Choose Day:</label>
						<select class="form-control" name="day" id="import-day">
							@foreach ($days as $day)
								<option value="{{ $day }}">{{ $day }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="file">Choose file:</label>
						<button id="file" type="button" class="btn btn-default btn-block">No file chosen</button>
						<input type="file" name="file" accept=".csv" style="display:none;">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-purple btn-block">Import</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

				
	<div class="modal fade" id="export" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4>Export</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label" for="import-day">Choose Day:</label>
						<select class="form-control" name="day" id="import-day">
							<option value="All">All</option>
							@foreach ($days as $day)
								<option value="{{ $day }}">{{ $day }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					{{ link_to_route('admin.availability.export','Export', array(), array('class' => 'btn btn-primary btn-block')) }}
				</div>
			</div>
		</div>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th class="text-center">Hours Requested</th>
				<th class="text-center">Updated At</th>
				<th colspan="2" class="text-center">Options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<a href="{{ route('admin.availability.remind', "All") }}" class="btn btn-info btn-block remind">Remind All</a>
				</td>
				{{ Form::open(array('route' => array('admin.availability.reset', "All") )) }}
				<td>
					<button data-name="All" data-action="reset" class="btn btn-danger btn-block">Reset All</button>
				</td>
				{{ Form::close() }}
			</tr>
			@foreach ($tas as $ta)
				<tr>
					<td>{{ $ta->name }}</td>
					<td class="text-center">{{ $ta->profile->requested_hours }}</td>
					<td class="text-center">
						@if ($ta->availabilities()->first())
							{{ date("F j, Y", strtotime( $ta->availabilities()->first()->updated_at)) }}
						@else
							- - -
						@endif
					</td>
					<td>
						<a href="{{ route('admin.availability.remind', $ta->name) }}" class="btn btn-info btn-block remind">Remind</a>
					</td>
					{{ Form::open(array('route' => array('admin.availability.reset', $ta->name) )) }}
					<td>
						<button data-name="Andrey Kulakevich" data-action="reset" class="btn btn-danger btn-block">Reset</button>
					</td>
					{{ Form::close() }}
				</tr>
			@endforeach
		</tbody>
	</table>
@stop