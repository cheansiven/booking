<!doctype html>
<html>
<head>
    <title> @yield('title')</title>
    <meta charset="utf-8">
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel='stylesheet prefetch'  href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

    <link href="{{ URL::asset('/public/css/backend.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('/public/css/daterangepicker.css') }}" type="text/css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    @yield('style')
</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="nav_container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="home_nav active"><a href="{{ URL::to('rooms') }}">Rooms</a></li>
                <li class="home_nav"><a href="{{ URL::to('addon') }}">Add Ons</a></li>
                <li class="home_nav"><a href="{{ URL::to('reservations') }}">reservations</a></li>
                <li class="home_nav"><a href="{{ URL::to('rooms/recap') }}">rooms recap</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0">
                <li class="home_nav"><a class="logout" href="{{ URL::to('admin/logout') }}">
                        <img class="logout_img" src="{{asset('public/img/logout.jpg')}}"></a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="col-sm-12">
    @if(Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>

            {{ Session::get('flash_message') }}
        </div>
        <br>
    @endif

    @yield('content')

</div>

<footer class="footer">
    <div class="col-sm-10">
        <p class="col-sm-2">You are login as <br>{{Auth::user()->name}}</p>

    </div>
    <div class="col-sm-2">
        <a class="logout" href="{{ URL::to('admin/logout') }}"> Log Out</a>
    </div>
</footer>

<!-- Scripts -->
<script src='https://code.jquery.com/jquery-1.11.3.min.js'></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('/public/js/moment.js') }}"></script>
<script src="{{ URL::asset('/public/js/daterangepicker.js') }}"></script>

@yield('script')

</body>
</html>
