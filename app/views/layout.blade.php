<html>
	<head>
		<title>CSLearning - @yield('title')</title>
		<meta name="author" content="Andrey Kulakevich">
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::script('js/jquery-1.11.1.min.js') }}
		{{ HTML::script('js/bootstrap.js') }}
	</head>
    <body>
    	<div class="container">
    		<!-- Navigation -->
    		@include('navigation')

			<!-- Messages -->
			@if ( Session::has( 'status' ) )
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ Session::get('status') }}
						</div>
					</div>
				</div>
			@endif

			<!-- Multiple Errors -->
			@if ( Session::has( 'errors' ) )
				<div class="row">
					@foreach ( Session::has( 'errors' ) as $error)
						<div class="col-xs-12">
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								{{ $error }}
							</div>
						</div>
					@endforeach
				</div>
			@endif

			<!-- Single Error -->
			@if ( Session::has( 'error' ) )
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ Session::get( 'error' ) }}
						</div>
					</div>
				</div>
			@endif

	        @yield('content')
    	</div>
    	
    </body>
</html>