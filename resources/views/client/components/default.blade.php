<!doctype html>
<html class="no-js" lang="en">
	
<!-- Mirrored from htmldemo.net/latest/latest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 06:35:18 GMT -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Home one || Latest</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}">
		<!-- Place favicon.ico in the root directory -->

		<!-- all css here -->
		<!-- bootstrap v3.3.6 css -->
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
		<!-- animate css -->
		<link rel="stylesheet" href="{{asset('css/animate.css')}}">
		<!-- jquery-ui.min css -->
		<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
		<!-- meanmenu css -->
		<link rel="stylesheet" href="{{asset('css/meanmenu.min.css')}}">
		<!-- owl carousel css -->
		<link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
		<!-- slick css -->
		<link rel="stylesheet" href="{{asset('css/slick.css')}}">
		<!-- lightbox css -->
		<link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
		<!-- material-design-iconic-font css -->
		<link rel="stylesheet" href="{{asset('css/material-design-iconic-font.css')}}">
		<!-- All common css of theme -->
		<link rel="stylesheet" href="{{asset('css/default.css')}}">
		<!-- style css -->
		<link rel="stylesheet" href="{{asset('style.css')}}">
        <!-- shortcode css -->
        <link rel="stylesheet" href="{{asset('css/shortcode.css')}}">	
		<!-- responsive css -->
		<link rel="stylesheet" href="{{asset('css/responsive.css')}}">
		<!-- modernizr css -->
		<script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>

		@stack('styles')
	</head>
	<body>
		<!-- WRAPPER START -->
		<div class="wrapper">
			<!-- HEADER-AREA START -->
			
			@include('client.components.header')

			<!-- HEADER-AREA END -->			
			
			@yield('content')

			<!-- FOOTER START -->
			@include('client.components.footer')
			<!-- FOOTER END -->
			<!-- QUICKVIEW PRODUCT -->
			
			@include('client.components.quickview')
			<!-- END QUICKVIEW PRODUCT -->

		</div>

		<!-- jquery latest version -->
		<script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
		<!-- bootstrap js -->
		<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
		<!-- jquery.meanmenu js -->
		<script src="{{asset('js/jquery.meanmenu.js')}}"></script>
		<!-- slick.min js -->
		<script src="{{asset('js/slick.min.js')}}"></script>
		<!-- jquery.treeview js -->
		<script src="{{asset('js/jquery.treeview.js')}}"></script>
		<!-- lightbox.min js -->
		<script src="{{asset('js/lightbox.min.js')}}"></script>
		<!-- jquery-ui js -->
		<script src="{{asset('js/jquery-ui.min.js')}}"></script>
		<!-- owl.carousel js -->
		<script src="{{asset('js/owl.carousel.min.js')}}"></script>
		<!-- jquery.nicescroll.min js -->
		<script src="{{asset('js/jquery.nicescroll.min.js')}}"></script>
		<!-- countdon.min js -->
		<script src="{{asset('js/countdon.min.js')}}"></script>
		<!-- wow js -->
		<script src="{{asset('js/wow.min.js')}}"></script>
		<!-- plugins js -->
		<script src="{{asset('js/plugins.js')}}"></script>
		<!-- main js -->
		<script src="{{asset('js/main.js')}}"></script>

		@stack('script')
	</body>

<!-- Mirrored from htmldemo.net/latest/latest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 06:35:35 GMT -->
</html>
