<!doctype html>
<html>
<head>
    <title> @yield('title')</title>
    <meta charset="utf-8">
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link href="{{ URL::asset('/public/css/latoja.datepicker.css') }}" type="text/css" rel="stylesheet">

    <link href="{{ URL::asset('/public/css/frontend.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('/public/css/daterangepicker.css') }}" type="text/css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700' rel='stylesheet' type='text/css'>

    @yield('style')

</head>
<body>

<div id="main_wrapper" class="container">
    <div class="row">
        <header>
            <div class="Line"></div>
            <img class="Home_Logo" src="{{ URL::asset('/public/img/logo.png') }}"/>
        </header>
    </div>

    @yield('content')

</div>

<!-- Scripts -->
<script src='https://code.jquery.com/jquery-1.11.3.min.js'></script>
<script src="{{ url('public/js/jquery-ui-1.10.1.min.js') }}"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.js"></script>

<script src="{{ URL::asset('/public/js/moment.js') }}"></script>
<script src="{{ URL::asset('/public/js/daterangepicker.js') }}"></script>

@yield('script')

</body>
</html>
