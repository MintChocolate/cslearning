<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('home') }}">CSLearning</a>
		</div>

		<div class="collapse navbar-collapse">
			@if ( Auth::check() )
				<ul class="nav navbar-nav">
					@foreach ($navigation as $link)
						<li {{ $link['active'] }}>{{ link_to_route($link['route'], $link['name']) }}</li>
					@endforeach
				</ul>
			@endif

			@if ( Auth::check() )
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="@{{ route('profile', Auth::user()->profile) }}">Profile</a></li>							
						</ul>
					</li>
					<li><a href="{{ url('users/logout') }}">Logout</a></li>
				</ul>
			@else
				{{ Form::open(array('url' => 'users/login', 'class' => 'navbar-form navbar-right')) }}
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-success">Login</button>
				{{ Form::close() }}
			@endif
		</div>
	</div>
</nav>