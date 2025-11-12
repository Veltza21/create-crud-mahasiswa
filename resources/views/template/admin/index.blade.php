<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>CRUD MAHASISWA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{-- <link href="{{asset('template_admin')}}/assets/img/favicon.png" rel="icon"> --}}
    <link rel="shortcut icon" href="{{ asset('template-pinterest') }}/docs/assets/img/logo.png" type="image/x-icon">

    <link href="{{ asset('template_admin') }}/assets/img/logo.png" rel="icon">

    <link href="{{ asset('template_admin') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('template_admin') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ asset('template_admin') }}/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('template_admin') }}/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
* Template Name: CRUD MAHASISWA - v2.4.1
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
    @yield('css_admin')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="{{ asset('template_admin') }}/assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">CRUD MAHASISWA</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            {{-- <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form> --}}
            {{-- @include('waktu.index') --}}
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-clock-history"></i>
                    </a>
                </li><!-- End Search Icon-->
                          

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                    data-bs-toggle="dropdown">
                    <img src="{{ asset('template_admin') }}/assets/img/profile-img.jpg" alt="Profile"
                        class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2" style="text-transform: capitalize">{{ auth()->user()->name}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6 style="text-transform: capitalize">{{ auth()->user()->name}}</h6>
                        <span>Web Designer</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>
                        <form action="{{ url('logout') }}" method="Post"
                            class="dropdown-item d-flex align-items-center">
                            @csrf
                            <i class="bi bi-box-arrow-right"></i>
                            <button class="btn">Sign Out</button>
                        </form>

                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">


            <li class="nav-item">
                <a class="nav-link @if (!request()->is('dashboard')) collapsed @endif"
                    href="{{ url('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @if(auth()->user()->is_admin == 1)
                <li class="nav-item">
                    <a class="nav-link @if (!request()->is('user')) collapsed @endif"
                        href="{{ url('user') }}">
                        <i class="bi bi-person"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (!request()->is('jurusan')) collapsed @endif"
                        href="{{ url('jurusan') }}">
                        <i class="bi bi-broadcast"></i>
                        <span>Jurusan</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->is_admin == 1)

            <li class="nav-item">
                <a class="nav-link @if (!request()->is('mahasiswa')) collapsed @endif"
                    href="{{ url('mahasiswa') }}">
                    <i class="bi bi-geo-fill"></i>
                    <span>Mahasiswa</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->is_admin == 0)

            <li class="nav-item">
                <a class="nav-link @if (!request()->is('mahasiswa_role_mahasiswa')) collapsed @endif"
                    href="{{ url('mahasiswa_role_mahasiswa') }}">
                    <i class="bi bi-geo-fill"></i>
                    <span>Mahasiswa</span>
                </a>
            </li>
            @endif
         
          



           

            
      



   


    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">
    @yield('content_admin')
</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>CRUD MAHASISWA</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="{{ url('/') }}">CRUD MAHASISWA</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('template_admin') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/chart.js/chart.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/echarts/echarts.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/quill/quill.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="{{ asset('template_admin') }}/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="{{ asset('template_admin') }}/assets/js/main.js"></script>

</body>

</html>
