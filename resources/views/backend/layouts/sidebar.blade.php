<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <a href="{{ url('/') }}"> <img alt="image" src="{{ asset('images/tw-logo.png') }}" class="header-logo" />
            <span class="logo-name"> Laundry</span>
        </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @if(Auth::user()->role == 'customer')
            <li class="{{ (request()->is('tambah-pesanan*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('tambah-pesanan') }}"><i data-feather="plus-circle"></i><span>Tambah Pesanan</span></a>
            </li>
            @endif
            <li class="{{ (request()->is('list-pesanan*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('list-pesanan') }}"><i data-feather="list"></i><span>List Pesanan</span></a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li class="dropdown {{ (request()->is('laporan*')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file"></i><span>Laporan</span></a>
                <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ url('laporan/keuangan') }}">Keuangan</a></li>
                <li><a class="nav-link" href="{{ url('laporan/pesanan') }}">Pesanan</a></li>
                </ul>
            </li>
            <li class="menu-header">Data User</li>
            <li class="{ (request()->is('user/kurir*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('user/kurir') }}"><i data-feather="user"></i><span>Kurir</span></a>
            </li>
            <li class="{ (request()->is('user/customer*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('user/customer') }}"><i data-feather="users"></i><span>Customer</span></a>
            </li>
            @endif
        </ul>
    </aside>
</div>