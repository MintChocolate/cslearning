@extends('layout')

@section('title')
	Availability
@stop

@if ($changes_allowed->value == "Yes")
@section('javascript-extended')
	{{ HTML::script('js/jquery-ui.min.js') }}
	{{ HTML::script('js/ta-availability.js')}}
	{{ HTML::style('css/jquery-ui.min.css')}}
@stop
@endif

@section('content')

	@if ($changes_allowed->value == "Yes")

	<h2>I can work</h2>
	<ul class="list-inline">
		@foreach ($days as $day)
			<li>
				<label>
					<input class="can-work" 
						type="checkbox" value="{{ $day }}" 
						{{ $cant_work[$day] or "checked" }}> {{ $day }}
			    </label>
			</li>
		@endforeach
	</ul>

	<h2>I want to work</h2>
	{{ Form::open(array('route' => 'ta.availability.hours')) }}
		<ul class="list-inline">
			<li><input type="number" name="hours" class="form-control" value="{{ $requested_hours or 4 }}" min="2" max="15" required></li>
			<li>hours per week</li>
			<li><button id="update-hours" class="btn btn-primary">Update</button></li>
		</ul>
		
		
	{{ Form::close() }}

	<h2>Select Highlighter</h2>
	<ul class="list-inline">
		<li>
			<input id="unavailable" name="highlighter" type="radio" value="Unavailable" checked>
			<label for="unavailable" class="btn btn-danger">
				<i class="glyphicon glyphicon-pencil"></i> Unavailable
			</label>
		</li>
		<li>
			<input id="available" name="highlighter" type="radio" value="Available">
			<label for="available" class="btn btn-warning">
				<i class="glyphicon glyphicon-pencil"></i> Available
			</label>
		</li>
		<li>
			<input id="preferred" name="highlighter" type="radio" value="Preferred">
			<label for="preferred" class="btn btn-success">
				<i class="glyphicon glyphicon-pencil"></i> Preferred
			</label>
		</li>
	</ul>

	<ul>
		<li>You can highlight multiple blocks at a time, even across days.</li>
		<li>You can use Ctrl/Command+Z to undo, or Ctrl/Command+Shift+Z to redo any changes.</li>
	</ul>

	

	{{ Form::open(array('route' => 'ta.availability.store')) }}
	<button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-floppy-disk"></i> Save Changes</button>

	@else
		<div class="alert alert-danger" role="alert">
			The Administrator has blocked changes to the availability.
		</div>
	@endif

	<table class="text-center table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th class="text-center">Time</th>
				@foreach ($days as $day)
					<th class="text-center">{{ $day }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@for ($time = $start; $time < $end; $time += 30)
				<tr>
					<td>{{ $times[$day][$time] }}</td>
					@foreach ($days as $day)
						<td id="{{ $day }}-{{ $time }}" data-day="{{ $day }}" 
							class="{{ $availabilities[$day][$time] == 0? "red" : ($availabilities[$day][$time] == 1? "yellow" : "green") }} @if ($changes_allowed->value == "Yes") selectable @endif"
							title="{{ $day }} {{ $times[$day][$time] }}">
							<input data-day="{{ $day }}" type="hidden" name="availabilities[{{ $day }}][{{ $time }}]" value="{{ $availabilities[$day][$time] or 1 }}">
							<span class="text">{{ $availabilities[$day][$time] == 0? "Unavailable" : ($availabilities[$day][$time] == 1? "Available" : "Preferred") }}</span>
						</td>
					@endforeach
				</tr>
			@endfor
		</tbody>
	</table>

	@if ($changes_allowed == "Yes")

	{{ Form::close() }}

	@endif
@stop