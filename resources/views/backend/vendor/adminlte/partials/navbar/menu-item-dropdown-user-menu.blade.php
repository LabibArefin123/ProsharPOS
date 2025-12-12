@php
    $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout');
    // Set profile URL to the named route 'profile'
    $profile_url = route('user_profile_show');
@endphp

@if (config('adminlte.usermenu_profile_url', false))
    @php($profile_url = Auth::user()->adminlte_profile_url())
@endif

@if (config('adminlte.use_route_url', false))
    @php($profile_url = $profile_url ? route($profile_url) : '')
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($profile_url = $profile_url ? url($profile_url) : '')
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if (config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}" class="user-image img-circle elevation-2"
                alt="{{ Auth::user()->name }}">
        @endif
        <span @if (config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        <li class="user-header bg-primary">

            {{-- User Image --}}
            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('images/default.jpg') }}"
                class="img-circle elevation-2 mb-2" style="width: 90px; height: 90px; object-fit: cover;">

            {{-- User Name --}}
            <p class="mb-1">
                {{ Auth::user()->name }}
            </p>

            {{-- Account Created At --}}
            <small>Account created: {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') }}</small>
            <br>
        </li>


        {{-- Menu Items --}}
        <li class="user-body p-0">

            {{-- Profile --}}
            <a href="{{ route('user_profile_show') }}" class="dropdown-item">
                <i class="fa fa-user text-primary mr-2"></i> Profile
            </a>

            {{-- Settings --}}
            <a href="{{ route('settings.index') }}" class="dropdown-item">
                <i class="fa fa-cog text-warning mr-2"></i> Settings
            </a>

            {{-- Logout --}}
            <a href="#" class="dropdown-item"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-power-off text-danger mr-2"></i> Log Out
            </a>

            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @csrf
                @if (config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
            </form>

        </li>

    </ul>


</li>
