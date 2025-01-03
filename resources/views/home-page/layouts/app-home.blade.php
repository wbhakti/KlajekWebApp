
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Food Order</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <!-- Bootstrap icons-->
        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>

        <style>
            body {
                padding-top: 56px; /* Sesuaikan nilai ini dengan tinggi navbar */
            }
            .navbar-expand {
                background-color: #FFF212; 
                color: white;
            }
            .navbar-expand .btn-outline-dark {
                color: #033800;
                border-color: #033800;
            }
            .navbar-expand .btn-outline-dark:hover {
                background-color: #033800;
                color: #842029;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <!-- Navigation-->
        <!-- <nav class="navbar custom-navbar fixed-top"> -->
        <nav class="sb-topnav navbar navbar-expand fixed-top">
            <div class="container px-4 px-lg-5">
                
                <!-- Sidebar Toggle-->
                @if(Request::is('/'))
                <ul class="navbar-nav ms-md-0">
                    <li class="nav-item dropdown">
                        <a class="navbar-brand dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/petunjuk') }}">Petunjuk Penggunaan</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('/contact') }}">Hubungi Kami</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#">Pendaftaran Mitra</a></li>
                        </ul>
                    </li>
                </ul> 
                @else
                <a class="navbar-brand" href="{{ url('/') }}" style="color: #033800;"><b>Home</b></a>
                @endif
                    
                <form class="d-flex" action="/cart" method="GET">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span id="cart-badge" class="badge bg-dark text-white ms-1 rounded-pill">{{ $cartCount }}</span>
                    </button>
                </form>               
            </div>
        </nav>
        
        <!-- Section-->
        @yield('content')
        
        <!-- Footer-->
        <footer class="py-5 bg-dark" style="background-color: #FFF212 !important;">
            <div class="container"><p class="m-0 text-center">Copyright &copy; Klajek 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="{{ asset('frontend-vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
