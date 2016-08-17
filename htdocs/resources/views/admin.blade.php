<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Admin Panel</title>

  <link href="{{ asset('/css/admin_base.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/bootstrap-switch.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/spectrum.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/liveurl.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/admin_custom.css') }}" rel="stylesheet">

	<!-- Ext files -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">ShareWall admin panel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
              </a>
							<ul class="dropdown-menu" role="menu">
                <li><a class="topAvatar" href="{{ route('admin.user.edit', Auth::id()) }}"><img src="data:image/jpeg;base64,{{ Auth::user()->avatar }}" class="img-rounded" alt="Rounded Image"></a></li>
								<li><a href="{{ URL::route('admin.settings.index') }}">Settings</a></li>
                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-default">
          <div class="panel-heading">
            @if (Auth::check())
              <nav>
                <a href="{{ URL::route('admin.dashboard') }}" class="btn btn-sml btn-default {{ set_primary('admin') }} {{ set_primary('admin/dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
                
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle {{ set_primary('admin/post*') }}" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-inbox"></i> Posts <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ URL::route('admin.post.index') }}">View all posts</a></li>
                    <li><a href="#" data-ajax="filter">View by category</a></li>
                    <li><a href="{{ URL::route('admin.post.create') }}">Create new post</a></li>
                  </ul>
                </div>

                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle {{ set_primary('admin/category*') }}" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th-large"></i> Categories <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ URL::route('admin.category.index') }}">View all categories</a></li>
                    <li><a href="{{ URL::route('admin.category.create') }}">Create new category</a></li>
                  </ul>
                </div>

                <a href="{{ URL::route('admin.user.index') }}" class="btn btn-sml btn-default {{ set_primary('admin/user') }}"><i class="fa fa-users"></i> Manage users</a>
                <a href="{{ URL::route('admin.settings.index') }}" class="btn btn-sml btn-default {{ set_primary('admin/settings') }}"><i class="fa fa-cog"></i> Settings</a>
              </nav>
            @endif
          </div>
          <div class="panel-body">
            @if (Session::has('message'))
              <div class="alert alert-info">
                <p>{{ Session::get('message') }}</p>
              </div>
            @endif
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">
                <p>{{ $error }}</p>
              </div>
            @endforeach
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    
    <footer class="text-center"><p>Built at IBM Hursley by Daniel Ireson / Liam Mclear / Kurosh Beckett / John Knutson</p></footer>

  </div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script src="{{ asset('/js/bootstrap-switch.min.js') }}"></script>
  <script src="{{ asset('/js/spectrum.js') }}"></script>
  <script src="{{ asset('/js/bootbox.min.js') }}"></script>
  <script src="{{ asset('/js/jquery.liveurl.js') }}"></script>
  <script src="{{ asset('/js/admin_liveurl.js') }}"></script>
	<script src="{{ asset('/js/admin_main.js') }}"></script>

</body>
</html>
