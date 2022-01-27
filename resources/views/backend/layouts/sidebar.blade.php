<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <a href="{{ url('/') }}"> <img alt="image" src="{{ asset('images/tw-logo.png') }}" class="header-logo" />
            <span class="logo-name"> Laundry</span>
        </a>
        </div>
        <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown active">
            <a href="{{ url('/') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li><a class="nav-link" href="#"><i data-feather="user"></i><span>List Pesanan</span></a></li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file"></i><span>Laporan</span></a>
            <ul class="dropdown-menu">
            <li><a class="nav-link" href="#">Keuangan</a></li>
            <li><a class="nav-link" href="#">Pesanan</a></li>
            </ul>
        </li>
        <li class="menu-header">Data User</li>
        <li><a class="nav-link" href="#"><i data-feather="user"></i><span>Customer</span></a></li>
        <li><a class="nav-link" href="#"><i data-feather="user"></i><span>Kurir</span></a></li>
        </ul>
    </aside>
</div>