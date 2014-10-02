@extends('layout')

@section('title')
	Availability
@stop

@section('javascript-extended')
	{{ HTML::script('js/jquery-ui.min.js') }}
	{{ HTML::script('js/ta-availability.js')}}
	{{ HTML::style('css/jquery-ui.min.css')}}
@stop

@section('content')

	<h2>I can work</h2>
	<ul class="list-inline">
		@foreach ($days as $day)
			<li>
				<label>
					<input class="can-work" type="checkbox" value="{{ $day }}" checked> {{ $day }}
			    </label>
			</li>
		@endforeach
	</ul>

	<h2>Select Marker</h2>
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
			@for ($time = 600; $time < 1200; $time += 30)
				<tr>
					<td>
						{{ floor($time/60) }}:{{ str_pad($time%60,2,0) }}
						 - 
						{{ floor(($time+30)/60) }}:{{ str_pad(($time+30)%60,2,0) }}
					</td>
					@foreach ($days as $day)
						<td class="{{ $day }} yellow selectable">Available</td>
					@endforeach
				</tr>
			@endfor
		</tbody>
	</table>
@stop