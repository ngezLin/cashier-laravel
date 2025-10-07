<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Po Depo | {{ ucfirst(Auth::user()->role) }}</title>
    <link rel="icon" href="{{ asset('dist/images/store.png') }}" type="image/gif">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" id="pushmenu" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('cashier.dashboard') }}" class="nav-link">
                    Home
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('cashier.dashboard') }}" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Klampis Depo</span>
        </a>

        <div class="sidebar">
            <!-- User Info -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dynamic Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    {{-- Admin Menu --}}
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="fa-solid fa-home"></i> <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.list') }}" class="nav-link">
                                <i class="fa-solid fa-box"></i> <p>New Transaction</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.drafts') }}" class="nav-link">
                                <i class="fa-solid fa-file"></i> <p>Drafts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions.index') }}" class="nav-link">
                                <i class="fa-solid fa-clock-rotate-left"></i> <p>Transaction History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link">
                                <i class="fa-solid fa-eye"></i> <p>View Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}" class="nav-link">
                                <i class="fa-solid fa-plus"></i> <p>Add Products</p>
                            </a>
                        </li>

                    {{-- Cashier Menu --}}
                    @elseif(Auth::user()->role === 'cashier')
                        <li class="nav-item">
                            <a href="{{ route('cashier.products.list') }}" class="nav-link">
                                <i class="fa-solid fa-plus"></i> <p>Transactions</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('cashier.products.index') }}" class="nav-link">
                                <i class="fa-solid fa-eye"></i> <p>View Products</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('cashier.transactions.index') }}" class="nav-link">
                                <i class="fa-solid fa-clock-rotate-left"></i> <p>Transaction History</p>
                            </a>
                        </li>
                    @endif

                    <!-- Logout -->
                    <li class="nav-item mt-auto">
                        <a href="#" class="nav-link text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off text-danger"></i> <p>Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Page Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                @yield('header')
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
</body>
</html>
