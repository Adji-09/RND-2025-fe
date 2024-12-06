<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-layout-mode="{{ Session::get('data_layout_mode') }}"
    data-topbar="{{ Session::get('data_topbar') }}" data-sidebar="{{ Session::get('data_sidebar') }}" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ Session::get('title_apps') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Content Management System" />
    <meta name="author" content="Constant Cyber Forensic Solutions Pty Ltd" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">

    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
