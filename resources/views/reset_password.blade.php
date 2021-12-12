<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="forgot-pass" style="border: 1px solid #6e6e6e;

		width: 75%;
		margin: 10px auto;">
		<h3 class="header" style="background: #2a3f54;height: 40px; color: #ffffff; padding:5px;">Reset Password</h3>
		<div class="" style="padding: 30px;">
			<div class="logo-container" style="text-align: center;">
				<img src="{{ asset('images/c2p-logo.png') }}" style="min-width: 100px;max-width: 150px;">
			</div>{{-- 
			<h6 style="font-size: 18px;font-weight: 600;color: #2a3f54;text-align: center;">Reset Password:</h6> --}}
			<form action="{{ route('reset.password.store') }}" method="POST" style="margin: auto; width: 70%;">
				{{ csrf_field() }}

				<input type="hidden" name="token" value={{ $token }}>

				<div class=" form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
					@include('components.error', ['index' => 'email'])
				</div>

				<div class=" form-group">
					<label for="password">New Password:</label>
					<input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
					@include('components.error', ['index' => 'password'])
				</div>

				<div class=" form-group">
					<label for="confirm-password">Confirm Password:</label>
					<input type="password" class="form-control" id="confirm-password" name="confirm_password" value="{{ old('confirm_password') }}">
					@include('components.error', ['index' => 'confirm_password'])
				</div>

				<button type="submit" class="btn" style="background: #2a3f54;color: #ffffff;">Reset Password</button>
			</form>
		</div>
	</div>	
</body>
</html>