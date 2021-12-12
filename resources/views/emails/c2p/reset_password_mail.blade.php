<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="forgot-pass">
			<div class="logo-container" style="text-align: center;">
				<img src="{{ asset('images/c2p-logo.png') }}" style="min-width: 100px;max-width: 150px;">
			</div>
			<h3 style="color: #4e4e4e;font-weight: 600;font-size: 25px;padding-top: 75px;margin-bottom: 15px;">Hello {{ $user->name }},</h3>
			<p style="color: gray;font-weight: 500;">You have submitted a password reset request.</p>
			<p style="color: gray;font-weight: 500;margin-bottom:30px;">If it was you, please change your password within 30 minutes.</p>
			<a href="{{ route('reset.password', $token) }}" target="_blank" style="background: #00ac96;color: #ffff;border: none;margin: auto;display: block;padding: 2px 50px 2px 3px;border-radius: 0;margin-bottom: 50px;">Reset Password</a>
			<p style="color: gray;font-weight: 500;">Thank you.</p>
			<p style="color: #4e4e4e;font-weight: 600;">Cover2Protect</p>
			<p style="color: gray;font-weight: 500;margin: 50px 0 0 0;font-size: 13px;text-align: center;">&copy;2019 Cover2Protect Pte Ltd. All Rights Reserved.</p>
			<p style="color: #7b7b7b;font-weight: 600;text-align: center;font-size: 14px;margin:0;">AI Driven Predictive Care</p>
		</div>
	</div>	
</body>
</html>