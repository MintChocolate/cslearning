@extends('layout')

@section('title')
	Manage Schedule
@stop

@section('javascript-extended')
	{{ HTML::script('js/danger-check.js') }}
	{{ HTML::script('js/file-input.js') }}
	{{ HTML::script('js/reminder.js') }}
@stop

@section('content')
	<div class="page-header">
		<h1>Manage Schedule</h1>
	</div>

	{{ Form::open(array('route' => 'admin.schedule.index')) }}
		{{ Form::label('day', 'Select Day:') }}
		<select id="day_select" name="day_select">
			@foreach ($days as $day)
				<option value="{{$day}}">{{$day}}</option>
			@endforeach
		</select>

		{{ Form::label('start_time', 'Select Start Time:') }}
		<select id="start_time_select" name="start_time_select">
			@foreach ($start_times as $start_time)
				<option value="{{$start_time}}">{{$start_time}}</option>
			@endforeach
		</select>

		{{ Form::label('end_time', 'Select End Time:') }}
		<select id="end_time_select" name="end_time_select">
			@foreach ($end_times as $end_time)
				<option value="{{$end_time}}">{{$end_time}}</option>
			@endforeach
		</select>

		{{ Form::label('ta', 'Select Teaching Assistant:') }}

		<select id="ta_index_select" name="ta_index_select">
			<option value=0>First TA</option>
			<option value=1>Second TA</option>
		</select>

		<select id="ta_select" name="ta_select">
			<option value=0>None</option>
			@foreach ($tas as $ta)
				<option value="{{$ta->id}}">{{$ta->name}}</option>
			@endforeach
		</select>

		<button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-floppy-disk"></i> Save Changes</button>


	{{ Form::close() }}

			<div class="col-xs-12">
			<h1>Schedule</h1>
			<table class="text-center table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">Time</th>
						@foreach ($days as $day)
							<th colspan="2" class="text-center">{{ $day }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@for ($time = $start; $time < $end; $time += 30)
						<tr>
							<td>{{ $times[$day][$time] }}</td>
							@foreach ($days as $day)
								@if ($schedule[$day][$time] == "Closed")
									<td colspan="2" class="red" title="{{ $day }} {{ $time[$day][$time] }}">Closed</td>
								@else
									<td>{{ $schedule[$day][$time][0] }}</td>
									<td>{{ $schedule[$day][$time][1] }}</td>
								@endif
							@endforeach
						</tr>
					@endfor
				</tbody>
			</table>
		</div>
	</div>
@stop