@props(['title', 'head' => '', 'script' => ''])

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ $title }}</title>
        <link href="{{ asset('dist/img/logo/logo.png') }}" rel="shortcut icon" type="image/x-icon">
        <link href="{{ asset('dist/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dist/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dist/css/ruang-admin.min.css') }}" rel="stylesheet">
        {{ $head }}
    </head>

    <body id="page-top">
        <div id="wrapper">

            <x-sidebar></x-sidebar>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content" class="pb-5">
                    <x-topbar></x-topbar>
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