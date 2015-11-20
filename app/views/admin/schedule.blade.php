@extends('layout')

@section('title')
	Manage Schedule
@stop

@section('javascript-extended')
	{{ HTML::script('js/jquery-ui.min.js') }}
	{{ HTML::script('js/admin-schedules.js')}}
	{{ HTML::style('css/jquery-ui.min.css')}}
@stop

@section('content')
	<div class="page-header">
		<h1>Manage Schedule</h1>
	</div>

	{{ Form::open(array('route' => 'admin.schedule.index')) }}
		<h1>Select Teaching Assistant:</h1>
		<ul class="list-inline">
			<li>
				<input id="0" name="ta_select" type="radio" value="0" checked>
				<label for="0">None</label>
			</li>
			@foreach ($tas as $ta)
				<li>
					<input id="{{$ta->id}}" name="ta_select" type="radio" value="{{$ta->id}}">
					<label for="{{$ta->id}}">{{$ta->name}}</label>
				</li>
			@endforeach
			
		</ul>

		<button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-floppy-disk"></i> Save Changes</button>

		<div class="col-xs-12">
			<h1>Schedule</h1>
			<table class="text-center table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">Time</th>
						@foreach ($days as $day)
							<th colspan="2" class="text-center">{{$day}}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@for ($time = $start; $time < $end; $time += 30)
						<tr>
							<td>{{ $times[$day][$time] }}</td>
							@foreach ($days as $day)
								@if ($schedule[$day][$time] == "Closed")
									<td colspan="2" class="red">Closed</td>
								@else
									<td id="{{ $day }}-{{ $time }}-{{"0"}}" data-day="{{ $day }}" 
										class="selectable">
										<label>{{ $schedule[$day][$time][0]['name']}}</label>
										<input data-day="{{ $day }}" type="hidden" name="schedule[{{$day}}][{{$time}}][0]" 
										value="{{ $schedule[$day][$time][0]['id']}}"></td>
									<td id="{{ $day }}-{{ $time }}-{{"1"}}" data-day="{{ $day }}" 
										class="selectable">
										<label>{{ $schedule[$day][$time][1]['name']}}</label>
										<input data-day="{{ $day }}" type="hidden" name="schedule[{{$day}}][{{$time}}][1]" 
										value="{{ $schedule[$day][$time][1]['id']}}"></td>
								@endif
							@endforeach
						</tr>
					@endfor
				</tbody>
			</table>
		</div>
		{{ Form::close() }}
	</div>
@stop