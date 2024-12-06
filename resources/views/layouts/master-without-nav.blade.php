<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | Content Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="Content Management System" />
        <meta name="author" content="Constant Cyber Forensic Solutions Pty Ltd" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
        <!-- Layout config Js -->
        <script src="{{ URL::asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ URL::asset('assets/css/app.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ URL::asset('assets/css/custom.min.css') }}"  rel="stylesheet" type="text/css" />
        {{-- @yield('css') --}}

        <style>
            body, h1, h2, h3, h4, h5, h6, ul, li, a, span, div {
                font-family: 'Quicksand', sans-serif;
            }
        </style>
    </head>

    @yield('body')
        @yield('content')
    </body>

    <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>

    <script type="text/javascript">
        var error = <?php echo json_encode(\Session::get('error')) ?>;

        if (error) {
            $(document).ready(function() {
                $("#modalAlertError").modal("show");
            });
        }
    </script>
</html>
