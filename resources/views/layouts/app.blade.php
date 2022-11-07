<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/shop-2.png') }}" type="image/x-icon">
    <title>{{ $title ?? config('app.name') }} - Ecommerce</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
    .form-control:focus {
        color: #6e707e;
        background-color: #fff;
        border-color: #375dce;
        outline: 0;
        box-shadow: none
    }

    .form-group label {
        font-weight: bold
    }

    #wrapper #content-wrapper {
        background-color: #e2e8f0;
        width: 100%;
        overflow-x: hidden;
    }

    .card-header {
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background-color: #4e73de;
        border-bottom: 1px solid #e3e6f0;
        color: white;
    }
    </style>
    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <!-- sweet alert -->
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fab fa-apple"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Ecommerce</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('dashboard*') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>DASHBOARD</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-12">
            <!-- Heading -->
            <div class="sidebar-heading">
                PRODUK
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li
                class="nav-item {{ Request::is('category*') ? ' active' : '' }} {{ Request::is('product*') ? ' active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria- controls="collapseTwo">
                    <i class="fa fa-shopping-bag"></i>
                    <span>PRODUK</span>
                </a>
                <div id="collapseTwo"
                    class="collapse {{ Request::is('category*') ? ' show' :'' }} {{ Request::is('product*') ? ' show' :'' }}"
                    aria- labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">KATEGORI & PRODUK</h6>
                        <a class="collapse-item {{ Request::is('category*') ? ' active' : '' }}"
                            href="{{ route('category.index')  }}">KATEGORI</a>
                        <a class="collapse-item {{ Request::is('product*') ? ' active' : '' }}"
                            href="{{ route('product.index') }}">PRODUK</a>
                    </div>
                </div>
            </li>
            <div class="sidebar-heading">
                ORDERS
            </div>
            <li class="nav-item {{ Request::is('order*') ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-shopping-cart"></i>
                    <span>ORDERS</span></a>
            </li>
            <li class="nav-item {{ Request::is('customer*') ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-users"></i>
                    <span>CUSTOMERS</span></a>
            </li>
            <li class="nav-item {{ Request::is('slider*') ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-laptop"></i>
                    <span>SLIDERS</span></a>
            </li>
            <li class="nav-item {{ Request::is('profile*') ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-user-circle"></i>
                    <span>PROFILE</span></a>
            </li>
            <li class="nav-item {{ Request::is('user*') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i>
                    <span>USERS</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria- haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ auth()->user()->avatar_url }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="{{ route('logout') }}" style="cursor: pointer"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 "></i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Hak Cipta Dilindungi &copy; 2022 Laravel | IAMAntaRiksa </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>