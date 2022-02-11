<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Murni Sejati</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="pull-left image">
                <img src="/img/null-avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="pull-left info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if (auth()->user()->hasAnyPermission(['akses kategori', 'akses barang', 'akses akun', 'akses bank', 'akses pelanggan']))
                    <li
                        class="nav-item {{ request()->is('categories*') ||request()->is('products*') ||request()->is('banks*') ||request()->is('accounts') ||request()->is('customers*')? 'menu-open': '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-archive nav-icon"></i>
                            <p>
                                Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('akses kategori')
                                <li class="nav-item">
                                    <a href="{{ route('categories.index') }}"
                                        class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            @endcan

                            @can('akses barang')
                                <li class="nav-item">
                                    <a href="{{ route('products.index') }}"
                                        class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                            @endcan

                            @can('akses akun')
                                <li class="nav-item">
                                    <a href="./index2.html"
                                        class="nav-link {{ request()->is('accounts*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Akun</p>
                                    </a>
                                </li>
                            @endcan

                            @can('akses bank')
                                <li class="nav-item">
                                    <a href="./index2.html"
                                        class="nav-link {{ request()->is('banks*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bank</p>
                                    </a>
                                </li>
                            @endcan

                            @can('akses pelanggan')
                                <li class="nav-item">
                                    <a href="./index2.html"
                                        class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pelanggan</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif

                @can('akses pembayaran')
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link {{ request()->is('payments*') ? 'active' : '' }}">
                            <i class="far fa-solid fa-credit-card nav-icon"></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                @endcan

                @can('akses penjualan')
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link {{ request()->is('sales*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart nav-icon"></i>
                            <p>
                                Penjualan
                            </p>
                        </a>
                    </li>
                @endcan

                @can('akses jurnal umum')
                    <li class="nav-item">
                        <a href="pages/widgets.html"
                            class="nav-link {{ request()->is('general journal*') ? 'active' : '' }}">
                            <i class="fas fa-book nav-icon"></i>
                            <p>
                                Jurnal Umum
                            </p>
                        </a>
                    </li>
                @endcan

                @can('akses laporan')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-book-open nav-icon"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jurnal Umum</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Buku Besar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Neraca Saldo</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
