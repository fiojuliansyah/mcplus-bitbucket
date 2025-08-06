<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MCPlus Premium</title>
    <meta name="google_font_api" content="AIzaSyBG58yNdAjc20_8jAvLNSVi9E4Xhwjau_k">
    <link rel="shortcut icon" href="/frontend/assets/images/fav.avif" />
    <link rel="stylesheet" href="/frontend/assets/css/core/libs.min.css" />
    <link rel="stylesheet" href="/frontend/assets/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="/frontend/assets/vendor/iconly/css/style.css" />
    <link rel="stylesheet" href="/frontend/assets/vendor/animate.min.css" />
    <link rel="stylesheet" href="/frontend/assets/css/streamit.min.css?v=5.2.1" />
    <link rel="stylesheet" href="/frontend/assets/css/custom.min.css?v=5.2.1" />
    <link rel="stylesheet" href="/frontend/assets/css/rtl.min.css?v=5.2.1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300&display=swap"
        rel="stylesheet">
    @stack('css')

</head>

<body class="  ">
    <span class="screen-darken"></span>
        <div class="floating-alert-container">
        @if (session('success'))
            <div class="floating-alert alert alert-success alert-dismissible fade show" role="alert"
                style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="floating-alert alert alert-danger alert-dismissible fade show" role="alert"
                style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="floating-alert alert alert-danger alert-dismissible fade show" role="alert"
                style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>Whoops!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="loader simple-loader">
        <div class="loader-body">
            <img src="/frontend/assets/images/loader.gif" alt="loader" class="img-fluid " width="300">
        </div>
    </div>
    <main class="main-content">

       @yield('content')

    </main>

    <div id="back-to-top" style="display: none;">
        <a class="p-0 btn bg-primary btn-sm position-fixed top border-0 rounded-circle text-white" id="top"
            href="#top">
            <i class="fa-solid fa-chevron-up"></i>
        </a>
    </div>
    <script src="/frontend/assets/js/core/libs.min.js"></script>
    <script src="/frontend/assets/vendor/lodash/lodash.min.js"></script>
    <script src="/frontend/assets/js/core/external.min.js"></script>
    <script src="/frontend/assets/js/plugins/countdown.js"></script>
    <script src="/frontend/assets/js/utility.js"></script>
    <script src="/frontend/assets/js/setting.js"></script>
    <script src="/frontend/assets/js/setting-init.js" defer></script>
    <script src="/frontend/assets/js/streamit.js" defer></script>
    <script src="/frontend/assets/js/swiper.js" defer></script>
    @stack('js')
</body>

</html>
