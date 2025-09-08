<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MCP WEBSITE</title>
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet" />
    <!-- TAILWINDCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/frontend/assets/js/tailwind.config.js"></script>
    <script src="/frontend/assets/css/app.css"></script>
    <!-- ICONIFY -->
    <script src="https://code.iconify.design/iconify-icon/1.0.5/iconify-icon.min.js"></script>
    <!-- SWIPERJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/styles/index.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/index.js" defer></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- INTERNAL CSS -->
    <link rel="stylesheet" href="/frontend/assets/css/app.css" />

    @stack('styles')
</head>
<body class="bg-black text-white">
    @include('frontend.layouts.partials.navbar')

    @yield('content')

    @include('frontend.layouts.partials.footer')

    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6 text-white border border-gray-700">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-900 border border-green-700">
                    <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-semibold leading-6" id="modal-title">Success</h3>
                <div class="mt-2">
                    <p id="successModalMessage" class="text-sm text-gray-400"></p>
                </div>
            </div>
            <div class="mt-6 flex justify-center">
                <button type="button" id="closeSuccessModalButton" class="rounded-full bg-gray-50 text-black px-8 py-2 text-sm font-semibold shadow-sm hover:bg-gray-200">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        const swiperClassPreview = new Swiper('.swiper-class-previews', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: false
            },
            initialSlide: 1,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 5
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        const swiperQuickStudy = new Swiper('.swiper-quick-study', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: false
            },
            initialSlide: 1,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 5
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        const swiperNewsUpdate = new Swiper('.swiper-news-update', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: false
            },
            initialSlide: 1,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 5
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileTrigger = document.getElementById('profile-trigger');
            const profileDropdown = document.getElementById('profile-dropdown');
            const chevronIcon = document.getElementById('chevron-icon');

            profileTrigger.addEventListener('click', function (event) {
                event.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                chevronIcon.classList.toggle('rotate-180');
            });

            window.addEventListener('click', function (event) {
                if (!profileDropdown.classList.contains('hidden')) {
                    profileDropdown.classList.add('hidden');
                    chevronIcon.classList.remove('rotate-180');
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const successModal = document.getElementById('successModal');
                const successModalMessage = document.getElementById('successModalMessage');
                const closeButton = document.getElementById('closeSuccessModalButton');

                successModalMessage.textContent = "{{ session('success') }}";
                successModal.classList.remove('hidden');

                const hideModal = () => {
                    successModal.classList.add('hidden');
                };

                closeButton.addEventListener('click', hideModal);

                successModal.addEventListener('click', (event) => {
                    if (event.target === successModal) {
                        hideModal();
                    }
                });
            });
        </script>
    @endif
    @stack('scripts')
</body>
</html>