<!DOCTYPE html> 
<html lang="en">
	<head>
	
		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Mcplus Premium is a powerful Learning Management System template designed for educators, training institutions, and businesses. Manage courses, track student progress, conduct virtual classes, and enhance e-learning experiences with an intuitive and feature-rich platform.">
		<meta name="keywords" content=" Premium template, Learning Management System, e-learning software, online course platform, student management, education portal, virtual classroom, training management system, course tracking, online education">
		<meta name="author" content="MCPlus Technologies">
		<meta name="robots" content="index, follow">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<title>Mcplus | Platform Elearning</title>

		<!-- Favicon -->
		<link rel="shortcut icon" href="/frontpage/assets/img/favicon.png"> 
		<link rel="apple-touch-icon" href="/frontpage/assets/img/apple-icon.png">

		<!-- Theme Settings Js -->
		<script src="/frontpage/assets/js/theme-script.js"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/frontpage/assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="/frontpage/assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="/frontpage/assets/plugins/fontawesome/css/all.min.css">

		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="/frontpage/assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="/frontpage/assets/css/owl.theme.default.min.css">

		<!-- isax css -->
		 <link rel="stylesheet" href="/frontpage/assets/css/iconsax.css">
		
		<!-- Slick CSS -->
		<link rel="stylesheet" href="/frontpage/assets/plugins/slick/slick.css">
		<link rel="stylesheet" href="/frontpage/assets/plugins/slick/slick-theme.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="/frontpage/assets/plugins/select2/css/select2.min.css">
		
		<!-- Aos CSS -->
		<link rel="stylesheet" href="/frontpage/assets/plugins/aos/aos.css">

		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="/frontpage/assets/plugins/feather/feather.css">

		<!-- Tabler Icon CSS -->
		<link rel="stylesheet" href="/frontpage/assets/plugins/tabler-icons/tabler-icons.css">

		<!-- Main CSS -->
		<link rel="stylesheet" href="/frontpage/assets/css/style.css">
		@stack('styles')
		<style>
		.header-icon-container {
			display: flex;
			align-items: center;
			gap: 1rem;
		}

		.header-icon-container .icon-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			margin: 0 !important;
		}

		.header-icon-container .icon-btn a {
			display: flex;
			align-items: center;
			justify-content: center;
			vertical-align: middle;
		}

		.header-icon-container .icon-btn i {
			font-size: 18px;
		}

		.payment-card-select .form-check-input {
			display: none;
		}

		.payment-card {
			border: 2px solid #e9ecef;
			border-radius: 0.5rem; 
			padding: 1rem;
			cursor: pointer;
			transition: all 0.2s ease-in-out;
			height: 100%;
			display: flex;
			align-items: center;
		}

		.payment-card:hover {
			border-color: #adb5bd;
			transform: translateY(-3px);
			box-shadow: 0 4px 12px rgba(0,0,0,0.08);
		}

		.payment-card-select .form-check-input:checked + .payment-card {
			border-color: #FF4667;
			box-shadow: 0 4px 15px rgba(255, 0, 76, 0.25);
			background-color: #f4f8ff;
		}

		.payment-card img {
			max-width: 80px;
			height: 60px; 
			object-fit: contain;
			margin-right: 1rem;
		}
		</style>
	</head>
	<body>

		<div class="main-wrapper">
		
			<div class="home-3">
				@yield('content')
			</div>
		   
		</div>
	   <!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="/frontpage/assets/js/jquery-3.7.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="/frontpage/assets/js/bootstrap.bundle.min.js"></script>
		
		<!-- counterup JS -->
		<script src="/frontpage/assets/js/jquery.waypoints.js"></script>
		<script src="/frontpage/assets/js/jquery.counterup.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="/frontpage/assets/plugins/select2/js/select2.min.js"></script>

		<!-- Owl Carousel -->
		<script src="/frontpage/assets/js/owl.carousel.min.js"></script>	

		<!-- Slick Slider -->
		<script src="/frontpage/assets/plugins/slick/slick.js"></script>
		
		<!-- Aos -->
		<script src="/frontpage/assets/plugins/aos/aos.js"></script>
		
		<!-- Custom JS -->
		<script src="/frontpage/assets/js/script.js"></script>
		@stack('scripts')
	</body>
</html>