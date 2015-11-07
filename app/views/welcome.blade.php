@extends('layout')

@section('title')
	Welcome
@stop

@section('javascript-extended')
	{{ HTML::script('js/popover-enable.js') }}
@stop

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="jumbotron text-center">
				<h1>Welcome to CSLearning!</h1>
			</div>
		</div>
		<div class="col-xs-12">
			<h1>Teaching Assistants</h1>

			<div class="row text-center">
				@foreach ($tas as $ta)
					<div class="col-xs-2">
						<div class="thumbnail">
							<img src="{{ asset('images/'.$ta->profile->image) }}" 
								class="img-responsive"
								data-toggle="popover" 
								data-trigger="hover"
								data-placement="bottom" 
								title="{{ $ta->name }}" 
								data-content="{{ $ta->profile->about }}">
						</div>
					</div>
				@endforeach
			</div>
		</div>
		<div class="col-xs-4">
			<h1>Courses</h1>
				@foreach ($courses as $course)
					<h4 data-toggle="popover" 
								data-trigger="hover"
								data-placement="bottom" 
								title="Teaching Assistants" 
								data-content="{{$course['tas']}}"
					><a>{{$course['course_string']}}</a></h4>
				@endforeach
		</div>		

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
									<td>
										<label data-toggle="popover" 
											data-trigger="hover"
											data-placement="bottom" 
											title="Courses" 
											data-content="{{ $schedule[$day][$time][0]['course'] }}">
											{{ $schedule[$day][$time][0]['name'] }}
										</label>
									</td>
									<td>
										<label data-toggle="popover" 
											data-trigger="hover"
											data-placement="bottom" 
											title="Courses" 
											data-content="{{ $schedule[$day][$time][1]['course'] }}">
											{{ $schedule[$day][$time][1]['name'] }}
										</label></td>
								@endif
							@endforeach
						</tr>
					@endfor
				</tbody>
			</table>
		</div>
	</div>
@stop