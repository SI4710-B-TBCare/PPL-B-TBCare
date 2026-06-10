@props(['title', 'head' => '', 'script' => ''])

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ $title }}</title>
        <link href="{{ asset('dist/img/logo/logo2.png') }}" rel="shortcut icon" type="image/x-icon">
        <link href="{{ asset('dist/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dist/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dist/css/ruang-admin.min.css') }}" rel="stylesheet">
        {{ $head }}
    </head>

    <body id="page-top">
        <div id="wrapper">

            {{-- Sidebar putih seperti admin --}}
            <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
                    <div class="sidebar-brand-icon">
                        <img src="{{ asset('dist/img/logo/logo2.png') }}" width="40">
                    </div>
                    <div class="sidebar-brand-text mx-3">TBCare</div>
                </a>
                <hr class="sidebar-divider my-0">
                <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('users.prediksi*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.prediksi.create') }}">
                        <i class="fas fa-fw fa-heartbeat"></i>
                        <span>Prediksi Risiko TBC</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('users.prediksi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.prediksi.index') }}">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Prediksi Saya</span>
                    </a>
                </li>
                <hr class="sidebar-divider mb-0">
            </ul>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content" class="pb-5">

                    {{-- Navbar atas ungu seperti admin --}}
                    <nav class="navbar navbar-expand navbar-dark bg-navbar-custom topbar mb-4 static-top shadow"
                        style="background-color: #5a67d8;">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars text-white"></i>
                        </button>
                        <button id="sidebarToggle" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars text-white"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-white small">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <img class="img-profile rounded-circle" width="32" height="32"
                                        src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('dist/img/undraw_profile.svg') }}">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                        {{ $slot }}
                        <x-modal-logout/>
                    </div>
                </div>
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="{{ asset('dist/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dist/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('dist/js/ruang-admin.min.js') }}"></script>
        <script src="{{ asset('dist/vendor/chart.js/Chart.min.js') }}"></script>
        {{ $script }}
    </body>
</html>