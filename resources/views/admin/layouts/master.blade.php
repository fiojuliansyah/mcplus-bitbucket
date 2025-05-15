<!doctype html>
<html lang="en" data-bs-theme="dark" data-bs-theme-color="default" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Dashboard' }} | Mcplus Premium</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/admin/assets/images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="/admin/assets/css/core/libs.min.css">

    <link rel="stylesheet" href="/admin/assets/vendor/sheperd/dist/css/sheperd.css">

    <!-- Flatpickr css -->
    <link rel="stylesheet" href="/admin/assets/vendor/flatpickr/dist/flatpickr.min.css">








    <!-- streamit Design System Css -->
    <link rel="stylesheet" href="/admin/assets/css/streamit.min.css?v=5.2.1">

    <!-- Custom Css -->
    <link rel="stylesheet" href="/admin/assets/css/custom.min.css?v=5.2.1">
    <link rel="stylesheet" href="/admin/assets/css/dashboard-custom.min.css?v=5.2.1">

    <!-- RTL Css -->
    <link rel="stylesheet" href="/admin/assets/css/rtl.min.css?v=5.2.1">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="/admin/assets/css/customizer.min.css?v=5.2.1">

    <link rel="stylesheet" href="/admin/assets/vendor/swiperSlider/swiper-bundle.min.css">


    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/admin/assets/vendor/select2/dist/css/select2.min.css">
</head>

<body class="  ">
    @include('admin.layouts.partials.aside')
    <main class="main-content">
        @include('admin.layouts.partials.navbar')
        @yield('content')
        <!-- Footer Section Start -->
        @include('admin.layouts.partials.footer')
        <!-- Footer Section End -->
    </main>

    <!-- Library Bundle Script -->
    <script src="/admin/assets/js/core/libs.min.js"></script>
    <!-- Plugin Scripts -->
    <!-- Tour plugin Start -->
    <script src="/admin/assets/vendor/sheperd/dist/js/sheperd.min.js"></script>
    <script src="/admin/assets/js/plugins/tour.js" defer></script>


    <!-- Flatpickr Script -->
    <script src="/admin/assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
    <script src="/admin/assets/js/plugins/flatpickr.js" defer></script>



    <!-- Select2 Script -->
    <script src="/admin/assets/js/plugins/select2.js" defer></script>




    <!-- Slider-tab Script -->
    <script src="/admin/assets/js/plugins/slider-tabs.js"></script>





    <!-- SwiperSlider Script -->
    <script src="/admin/assets/vendor/swiperSlider/swiper-bundle.min.js"></script>
    <script src="/admin/assets/js/plugins/swiper-slider.js" defer></script>
    <!-- Lodash Utility -->
    <script src="/admin/assets/vendor/lodash/lodash.min.js"></script>
    <!-- Utilities Functions -->
    <script src="/admin/assets/js/iqonic-script/utility.min.js"></script>
    <!-- Settings Script -->
    <script src="/admin/assets/js/iqonic-script/setting.min.js"></script>
    <!-- Settings Init Script -->
    <script src="/admin/assets/js/setting-init.js"></script>
    <!-- External Library Bundle Script -->
    <script src="/admin/assets/js/core/external.min.js"></script>
    <!-- Widgetchart Script -->
    <script src="/admin/assets/js/charts/widgetcharts.js?v=5.2.1" defer></script>
    <!-- Dashboard Script -->
    <script src="/admin/assets/js/charts/dashboard.js?v=5.2.1" defer></script>
    <!-- qompacui Script -->
    <script src="/admin/assets/js/streamit.js?v=5.2.1" defer></script>
    <script src="/admin/assets/js/sidebar.js?v=5.2.1" defer></script>
    <script src="/admin/assets/js/chart-custom.js?v=5.2.1" defer></script>

    <script src="/admin/assets/js/plugins/select2.js?v=5.2.1" defer></script>

    <script src="/admin/assets/js/plugins/flatpickr.js?v=5.2.1" defer></script>

    <script src="/admin/assets/js/plugins/countdown.js?v=5.2.1" defer></script>
    @stack('js')

</body>

</html>
