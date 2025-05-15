<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Beranda' }} | MCPlus Premium</title>
    <!-- Google Font Api KEY-->
    <meta name="google_font_api" content="AIzaSyBG58yNdAjc20_8jAvLNSVi9E4Xhwjau_k">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/frontend/assets/images/favicon.ico" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="/frontend/assets/css/core/libs.min.css" />

    <!-- font-awesome css -->
    <link rel="stylesheet" href="/frontend/assets/vendor/font-awesome/css/all.min.css" />

    <!-- Iconly css -->
    <link rel="stylesheet" href="/frontend/assets/vendor/iconly/css/style.css" />

    <!-- Animate css -->
    <link rel="stylesheet" href="/frontend/assets/vendor/animate.min.css" />

    <!-- SwiperSlider css -->
    <link rel="stylesheet" href="/frontend/assets/vendor/swiperSlider/swiper.min.css">





    <!-- Streamit Design System Css -->
    <link rel="stylesheet" href="/frontend/assets/css/streamit.min.css?v=5.2.1" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="/frontend/assets/css/custom.min.css?v=5.2.1" />

    <!-- Rtl Css -->
    <link rel="stylesheet" href="/frontend/assets/css/rtl.min.css?v=5.2.1" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300&display=swap"
        rel="stylesheet">

</head>

<body class="  ">
    <span class="screen-darken"></span>
    <!-- loader Start -->
    <!-- loader Start -->
    <div class="loader simple-loader">
        <div class="loader-body">
            <img src="/frontend/assets/images/loader.gif" alt="loader" class="img-fluid " width="300">
        </div>
    </div>
    <!-- loader END --> <!-- loader END -->
    <main class="main-content">
        @include('frontend.layouts.partials.header')

        @yield('content')

    </main>

    @include('frontend.layouts.partials.footer')

    <div id="back-to-top" style="display: none;">
        <a class="p-0 btn bg-primary btn-sm position-fixed top border-0 rounded-circle text-white" id="top"
            href="#top">
            <i class="fa-solid fa-chevron-up"></i>
        </a>
    </div>
    <!-- Wrapper End-->
    <!-- Library Bundle Script -->
    <script src="/frontend/assets/js/core/libs.min.js"></script>
    <!-- Plugin Scripts -->


    <!-- SwiperSlider Script -->
    <script src="/frontend/assets/vendor/swiperSlider/swiper.min.js"></script>




    <!-- Lodash Utility -->
    <script src="/frontend/assets/vendor/lodash/lodash.min.js"></script>
    <!-- External Library Bundle Script -->
    <script src="/frontend/assets/js/core/external.min.js"></script>
    <!-- countdown Script -->
    <script src="/frontend/assets/js/plugins/countdown.js"></script>
    <!-- utility Script -->
    <script src="/frontend/assets/js/utility.js"></script>
    <!-- Setting Script -->
    <script src="/frontend/assets/js/setting.js"></script>
    <script src="/frontend/assets/js/setting-init.js" defer></script>
    <!-- Streamit Script -->
    <script src="/frontend/assets/js/streamit.js" defer></script>
    <script src="/frontend/assets/js/swiper.js" defer></script>
</body>

</html>
