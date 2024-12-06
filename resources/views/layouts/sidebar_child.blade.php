@if(!empty($menus->menu))
    @foreach($menus->menu as $keys => $sub_menu)
        <li class="nav-item">
            <a href="{{ URL("".$sub_menu->module_url."") }}" class="nav-link {{ Request::is("".$sub_menu->module_url."*") ? 'active' : '' }}">
                <span class="fs-15">{{ $sub_menu->module_name }}</span>
            </a>
        </li>

        @if(!empty($sub_menu->menu))
            @include('layouts.sidebar_child', ['menus' => $sub_menu])
        @endif
    @endforeach
@endif
