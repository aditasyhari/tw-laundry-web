<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Webpage Title -->
    <title>Twingky Wingky Laundry</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/swiper.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="icon" href="{{ asset('images/tw-logo.png') }}">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
    
    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="#"><img src="{{ asset('images/tw-logo.png') }}" alt="logo" style="max-width: 60px"></a> 

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#header">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#orders">Alur Pemesanan</a>
                    </li>
                </ul>
                <span class="nav-item">
                    <a class="btn-solid-sm" href="{{ url('/login') }}">Login</a>
                </span>
            </div>
        </div>
    </nav>
    <!-- end of navigation -->

    <!-- Header -->
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <div class="section-title">Selamat Datang di</div>
                        <h1 class="h1-large">Twingky Wingky Laundry</h1>
                        <p class="p-large">Melayani jasa cuci untuk pakaian dan barang-barang yang digunakan setiap harinya.</p>
                        <button class="btn-solid-lg">Mulai Laundry</button>
                    </div>
                </div> 
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ asset('frontend/images/header-illustration.svg') }}" alt="alternative">
                    </div>
                </div> 
            </div>
        </div>
    </header>
    <!-- end of header -->

    <!-- About -->
    <div class="basic-2" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h4>Visi</h4>
                        <p class="p-large">Menjadikan Twingky Wingky Laundry selalu menjadi yang terdepan, menjadi pilihan yang terpercaya dengan pelayanan terbaiknya untuk setiap pelanggan.</p><hr>
                        <h4>Misi</h4>
                        <ul class="text-white">
                            <li><p class="p-large" style="text-align: left">Memberikan pelayanan yang terbaik untuk pelanggan.</p></li>
                            <li><p class="p-large" style="text-align: left">Memberikan harga yang terjangkau disetiap kalangan dengan hasil kualitas yang tinggi.</p></li>
                            <li><p class="p-large" style="text-align: left">Menjadikan mitra terbaik dalam memberikan pelayanan yang ramah kepada pelanggan.</p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of About -->

    <!-- Services -->
    <div class="cards-1" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <h2><span>Layanan</span><br> Twingky Wingky.</h2><br>
                        <p>Banyak paket yang ditawarkan di Twingky Wingky Laundry mulai dari paket kiloan, per item.</p>
                        <p>Menyediakan jasa antar atau ambil pesanan yang mempermudah pelanggan dalam melakukan pesanan.</p>
                    </div>

                    <!-- Card -->
                    <div class="card">
                        <div class="card-icon blue">
                            <span class="fas fa-weight-hanging"></span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Paket Kiloan</h5>
                            <p>List Paket</p>
                            <ul class="list-unstyled li-space-lg">
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering</div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering + Setrika</div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Setrika</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-icon yellow">
                            <span class="fas fa-list"></span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Paket Per Item</h5>
                            <p>List Paket</p>
                            <ul class="list-unstyled li-space-lg">
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering + Setrika Bedcover</div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering + Setrika Seprei</div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering + Setrika Selimut</div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-check"></i>
                                    <div class="flex-grow-1">Cuci Kering Boneka</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end of card -->

                </div>
            </div>
        </div>
    </div>
    <!-- end of Services -->

    <!-- Footer -->
    <div class="footer bg-gray">
        <img class="decoration-city" src="{{ asset('frontend/images/decoration-city.svg') }}" alt="alternative">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Hubungi Kami</h4>
                    <ul class="list-unstyled li-space-lg">
                        <li><i class="fas fa-map-marker-alt"></i> &nbsp; Kaliboyo Kopen, RT 01 RW 05, Desa Kradenan, Kec. Purwoharjo, Kab. Banyuwangi</li>
                    </ul>
                    <div class="social-container">
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-instagram fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-whatsapp fa-stack-1x"></i>
                            </a>
                        </span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <!-- end of footer -->  

    <!-- Copyright -->
    <div class="copyright bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small statement">Copyright © <a href="#">Twingky Wingky Laundry</a></p>
                </div> 
            </div>
        </div>
    </div>

    <!-- Back To Top Button -->
    <button onclick="topFunction()" id="myBtn">
        <img src="{{ asset('frontend/images/up-arrow.png') }}" alt="alternative">
    </button>
    <!-- end of back to top button -->
    	
    <!-- Scripts -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/purecounter.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/scripts.js') }}"></script>
</body>
</html>