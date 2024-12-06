<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu border-end">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ URL('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo/logo-sm.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo/logo-sm.png') }}" alt="" width="50" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ URL('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo/logo-sm.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo/logo-sm.png') }}" alt="" width="50" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                @if (Session::get('access_token'))
                    @php
                        $menu = API::getModule();
                    @endphp

                    @foreach ($menu as $val)
                        @foreach ($val as $data)
                            @if ($data->module_nav == 1)
                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ Request::is("".$data->module_url."*") ? 'active' : '' }}" href="{{ URL("".$data->module_url."") }}">
                                        <i class="{{ $data->module_icon }}"></i> <span class="fs-15">{{ $data->module_name }}</span>
                                    </a>
                                </li>
                            @elseif ($data->module_nav == 2)
                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ Request::is("".$data->module_url."*") ? 'active' : '' }}" href="#{{ $data->module_url }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::is("".$data->module_url."*") ? 'true' : 'false' }}" aria-controls="{{ $data->module_url }}">
                                        <i class="{{ $data->module_icon }}"></i> <span class="fs-15">{{ $data->module_name }}</span>
                                    </a>

                                    <div class="menu-dropdown collapse {{ Request::is("".$data->module_url."*") ? 'show' : '' }}" id="{{ $data->module_url }}">
                                        <ul class="nav nav-sm flex-column">
                                            @if(!empty($data->menu))
                                                @include('layouts.sidebar_child', ['menus' => $data])
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <script>window.location = "/login";</script>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
