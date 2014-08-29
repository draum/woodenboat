<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>
			@section('title')
			WoodenBoat Database
			@show
		</title>
		<meta name="keywords" content="woodenboat, boat, kit, plan, sailing" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">        
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ URL::asset('assets/css/site.css') }}" rel="stylesheet">                
        <style type="text/css">
        @section('styles')
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        @show
        </style>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>        
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script src="{{ URL::asset('assets/js/site.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.validate.min.js') }}"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        @yield('head')        
	</head>

	<body>
		<!-- Navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
                    <a class="brand" href="#">Wooden Boat DB</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li {{{ (Request::is('/') ? 'class="active"' : '') }}}><a href="{{{ URL::to('') }}}">Home</a></li>                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/boat">Boats</a></li>
                                    <li><a href="/designer">Designers</a></li>                                    
                                </ul>
                            </li>
                            
						</ul>
                        
						<ul class="nav pull-right">
							@if (Sentry::check())
							<li class="navbar-text">Logged in as {{{ Auth::user()->fullName() }}}</li>
							<li class="divider-vertical"></li>
							<li {{{ (Request::is('account') ? 'class="active"' : '') }}}><a href="{{{ URL::to('account') }}}">Account</a></li>
							<li><a href="{{{ URL::to('account/logout') }}}">Logout</a></li>
							@else
							<li {{{ (Request::is('account/login') ? 'class="active"' : '') }}}><a href="{{{ URL::to('account/login') }}}">Login</a></li>
							<li {{{ (Request::is('account/register') ? 'class="active"' : '') }}}><a href="{{{ URL::to('account/register') }}}">Register</a></li>
							@endif
                            <form action="/boat/search" method="post" class="navbar-search pull-right dropdown">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input id="searchText" name="searchText" type="search" class="search-query dropdown-toggle" placeholder="Search" autocomplete="off">
                            <ul class="dropdown-menu"></ul></form>
						</ul>                        
					</div>
					<!-- ./ nav-collapse -->
				</div>
			</div>
		</div>
		<!-- ./ navbar -->

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->

            <footer>
            
            </footer>
		</div>
		<!-- ./ container -->
	</body>
</html>
