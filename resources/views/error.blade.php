<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Error | TW - Laundry</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/swiper.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/tw-logo.png') }}">

    <style>
        .header {
            overflow: visible;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
    
    <!-- Navigation -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">
            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="{{ url('/') }}"><img src="{{ asset('images/tw-logo.png') }}" alt="logo" style="max-width: 50px"></a> 
        </div>
    </nav>
    <!-- end of navigation -->

    <!-- Header -->
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1 class="h1-large">Error</h1>
                        <p class="p-large">Mohon maaf terjadi kesalahan teknis. *emot sungkem</p>
                    </div>
                </div> 
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ asset('images/error-500.jpg') }}" alt="alternative">
                    </div>
                </div> 
            </div>
        </div>
    </header>
    <!-- end of header -->
    	
    <!-- Scripts -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/purecounter.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/scripts.js') }}"></script>
</body>
</html>