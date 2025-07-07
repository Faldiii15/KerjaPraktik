
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ url("img/favicon.ico") }}" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href={{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css') }} rel="stylesheet">
    <link href={{ url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css") }} rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href={{ url("lib/owlcarousel/assets/owl.carousel.min.css") }} rel="stylesheet">
    <link href={{ url("lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css") }} rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href={{ url("css/bootstrap.min.css") }} rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href={{ url("css/style.css") }} rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-tools me-2"></i>MyJAK</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        {{-- <img class="rounded-circle" class="fa fa-user" alt="" style="width: 40px; height: 40px;"> --}}
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="{{ url('alat') }}" class="nav-item nav-link"><i class="fa fa-tractor me-2"></i> Alat Berat</a>
                    <a href="{{ url('anggota') }}" class="nav-item nav-link"><i class="fa fa-user"></i> Anggota</a>
                    <a href="{{ url('peminjaman') }}" class="nav-item nav-link"><i class="fa fa-industry me-2"></i>Peminjaman Alat</a>
                    <a href="{{ url('pengembalian') }}" class="nav-item nav-link"><i class="fa fa-truck"></i>Pengembalian Alat</a>
                    @if (auth()->user()->role == 'A') 
                    <a href="{{ url('pemeliharaan') }}" class="nav-item nav-link"><i class="fa fa-truck"></i>Pemeliharaan Alat</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-file me-2"></i>Laporan
                        </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ url('laporan/alat') }}" class="dropdown-item">
                               <i class="fa fa-file me-2"></i>Laporan Alat Berat
                            </a>
                            <a href="{{ url('laporan/peminjaman') }}" class="dropdown-item">
                                <i class="fa fa-file me-2"></i>Laporan Peminjaman
                            </a>
                            <a href="{{ url('laporan/pengembalian') }}" class="dropdown-item">
                                <i class="fa fa-file me-2"></i>Laporan Pengembalian
                            </a>
                            <a href="{{ url('laporan/pemeliharaan') }}" class="dropdown-item">
                                <i class="fa fa-file me-2"></i>Laporan Pemeliharaan
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                {{-- <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form> --}}
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex fa fa-user">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            {{-- <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a> --}}
                            {{-- <a href="{{ url("logout") }}" class="dropdown-item">Log Out</a> --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                </a>
                                </li>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src={{ url("https://code.jquery.com/jquery-3.4.1.min.js") }}></script>
    <script src={{ url("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js") }}></script>
    <script src={{ url("lib/chart/chart.min.js") }}></script>
    <script src={{ url("lib/easing/easing.min.js") }}></script>
    <script src={{ url("lib/waypoints/waypoints.min.js") }}></script>
    <script src={{ url("lib/owlcarousel/owl.carousel.min.js") }}></script>
    <script src={{ url("lib/tempusdominus/js/moment.min.js") }}></script>
    <script src={{ url("lib/tempusdominus/js/moment-timezone.min.js") }}></script>
    <script src={{ url("lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js") }}></script>

    <!-- Template Javascript -->
    <script src={{ url("js/main.js") }}></script>
</body>

</html>