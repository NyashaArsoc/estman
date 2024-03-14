<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <link rel="icon" type="image/svg" href="{{ asset('img/icon.svg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>@yield('title', 'ESTMAN')</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/home/bootstrap.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset ('css/home/core.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset ('css/home/theme/themify-icons.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset ('css/home/waves.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset ('css/home/morris.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset ('css/home/jquery-ui.css') }}">
    <!--===============================================================================================-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css" rel="stylesheet">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/popupforms/msg.css') }}" />
</head>

<body style="background-color:#fff;">
@yield ('content')
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset ('js/home/jquery-1.12.3.min.js') }}"></script>
    <script src="{{ asset ('js/home/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/detectmobilebrowser.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/jquery.mousewheel.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/mwheelIntent.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/jquery.jscrollpane.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/jquery.fullscreen-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/waves.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/raphael.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/morris.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset ('js/home/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/home/app.js') }}"></script>
    @yield ('additional js')
    

</body>

</html>