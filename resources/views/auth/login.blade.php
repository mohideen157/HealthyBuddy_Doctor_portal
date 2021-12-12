<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>C2P | Login</title>

		<!-- Bootstrap -->
		<link href="/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="/bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- Animate.css -->
		<link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

		<!-- Custom Theme Style -->
		<link href="/bower_components/gentelella/build/css/custom.min.css" rel="stylesheet">
	</head>

	<body class="login">
		<div>

			<div class="login_wrapper">
				<div class="animate form login_form">
							<a href="javascript:">
								<img class="img-responsive" src="/images/c2p-logo.png" width="200">
							</a>
					<section class="login_content">
						<form role="form" method="POST" action="{{ url('/login') }}">
							{{ csrf_field() }}

							{{-- <h1>(my)<sup>ai</sup> BUD Login</h1> --}}
							<div class="row">
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">

									@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="row">
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input id="password" type="password" class="form-control" name="password" placeholder="Password">

									@if ($errors->has('password'))
										<span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<div class="col-md-6">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> Remember Me
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<div class="col-md-6">
										<button type="submit" class="btn btn-default submit">
											Login
										</button>
									</div>
									{{-- <div class="col-md-6">
										<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
									</div> --}}
								</div>
							</div>

							<div class="clearfix"></div>
						</form>
					</section>
				</div>
			</div>
		</div>
	</body>
</html>