<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>C2P | Doctor Dashboard</title>

	<!-- Bootstrap -->
	<link href="/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="/bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<!-- DataTables -->
	<link href="/bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="/bower_components/datatables/media/css/buttons.dataTables.css" rel="stylesheet">

	<!-- Select 2 -->
	<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">

	<link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

	<!-- bootstrap-wysiwyg -->
	<link href="/bower_components/gentelella/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

	<!-- iCheck -->
	<link href="/bower_components/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<link href="/css/selectric.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="/bower_components/gentelella/build/css/custom.min.css" rel="stylesheet">

	{{-- Sweet alert css --}}
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

	<link type="text/css" href="{{ asset('toastr/toastr.min.css') }}" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/dropify.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/dropify.ttf') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/dropify.woff') }}">

	@section('style')
	@show
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav class="" role="navigation">
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>
                        <div class="background-wrap"></div>
                        <ul class="nav navbar-nav admin-logo logo-header">
                        	<li>
                        		<a href="{{ route('doctor.patient.profile') }}" class="site_title"><i class="fa fa-user-md"></i> <span>C2P - Doctor</span></a>
                        	</li>
                        </ul>
                        <ul class="nav navbar-nav list-navigation">
							<li class="child_menu"><a href="{{ route('doctor.patient.profile') }}">Patient Profile</a></li>
							<li class="child_menu"><a href="{{ route('doctor.article') }}">Articles</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right admin-logo">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="{{ Auth::user()->profile_image }}" alt="">{{ Auth::user()->name }}
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li>
										<a href="{{ url('/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="row" style="width:100%;">
					@if (session('error'))
					<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						{{ session('error') }}
					</div>
					@endif

					@if (session('status'))
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						{{ session('status') }}
					</div>
					@endif
				</div>
				@yield('content')
			</div>
			<!-- /page content -->
		</div>
	</div>
{{-- @include('layouts.footer') --}}

<!-- Datatables -->
<script src="/bower_components/gentelella/vendors/jquery/dist/jquery.min.js"></script>
</script>
<script src="/bower_components/datatables/media/js/jquery.dataTables.js"></script>
<script src="/bower_components/datatables/media/js/dataTables.bootstrap.js"></script>

<script type="text/javascript" language="javascript" src="/bower_components/datatables/media/js/dataTables.buttons.js">
</script>

<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
</script>

<script type="text/javascript" language="javascript" src="/bower_components/datatables/media/js/buttons.html5.js"></script>

<!-- jQuery -->

<!-- Bootstrap -->
<script src="/bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap Bootbox -->
<script src="/bower_components/bootbox.js/bootbox.js"></script>

<!-- bootstrap-daterangepicker -->
<script src="/bower_components/gentelella/vendors/moment/min/moment.min.js"></script>
<!-- <script src="/bower_components/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script> -->

<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<!-- chart -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.2/Chart.min.js"></script>

<!-- Select 2 -->
<script src="/bower_components/select2/dist/js/select2.min.js"></script>

<!-- DatePicker -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Custom Theme Scripts -->
<script src="/bower_components/gentelella/build/js/custom.min.js"></script>

<!-- bootstrap-wysiwyg -->
<script src="/bower_components/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="/bower_components/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="/bower_components/gentelella/vendors/google-code-prettify/src/prettify.js"></script>

<!-- iCheck -->
<script src="/bower_components/gentelella/vendors/iCheck/icheck.min.js"></script>

<script src="/js/selectric.js"></script>

<script src="/js/main.js"></script>

<script type="text/javascript" src="{{ asset('toastr/toastr.js') }}"></script>

<script type="text/javascript" src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>

{{-- Ckeditor js --}}
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>

{{-- Dropify Js --}}
<script type="text/javascript" src="{{ asset('js/dropify.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
@include('sweet::alert')

@section('script')
<script src="{{ asset('js/app.js') }}"></script>
@show

<script type="text/javascript">
	$(document).ready(function(){
		$(".nav_menu ul li").click(function(){
            $(".nav_menu ul li").removeClass('active');
            $(this).addClass('active');
		})
	});
</script>
</body>
</html>