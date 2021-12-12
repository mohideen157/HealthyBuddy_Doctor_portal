<!-- #Register Model -->

<div ng-controller="loginRegisterCtrl">
	<div class="modal fade she-modal" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header loginModalheader">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<center>
					<ul class="nav nav-tabs text-center" role="tablist">
						<li role="presentation" class="active"><a href="#signin" aria-controls="signin" role="tab" data-toggle="tab"><span>SIGN IN</span></a></li>
						<li role="presentation"><a href="#signup" aria-controls="signup" role="tab" data-toggle="tab"><span>SIGN UP</span></a></li>
					</ul>
				</center>
			</div>
			<div>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="signin">
						<div class="ind-she-login">
							<form ng-submit="processLogin()">
								<p>Sign In As</p>
								<ul class="list-inline">
									<li>
										<div class="radio">
											<input id="patient" type="radio" name="loginas" ng-model="login.role" value="4" checked>
											<label for="patient">Patient</label>
										</div>
									</li>
									<li>
										<div class="radio">
											<input id="doctor" type="radio" name="loginas" ng-model="login.role" value="2">
											<label for="doctor">Doctor</label>
										</div>
									</li>
								</ul>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter Your Mail/Phone Number" ng-model="login.email">
								</div>
								<div class="form-group" style="margin-bottom: 15%">
									<input type="password" class="form-control" placeholder="Password" ng-model="login.password">
									<p class="text-right">
										<a href="javascript:void(0);" style="color: #939393;">Forget Password?</a>
									</p>
								</div>
								<div class="form-group">
									<button type="submit" class="btn ind-she-common-btn">SIGN IN</button>
									<p class="text-center">By Logging in you agree to our <a href="javascript:void(0);">T&C</a> and <a href="javascript:void(0);">Privacy Policy. </a>
									</p>
								</div>
							</form>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="signup">
						<div class="ind-she-login">
							<form ng-submit="processRegisterForm()">

								<p>Sign Up As</p>
								<ul class="list-inline">
									<li>
										<div class="radio">
											<input id="new_patient" class="signUpAs" type="radio" name="register" ng-model="register.role" value="4" checked>
											<label for="new_patient">Patient</label>
										</div>
									</li>
									<li>
										<div class="radio">
											<input id="new_doctor" class="signUpAs" type="radio"  name="register" ng-model="register.role" value="2">
											<label for="new_doctor">&nbsp;&nbsp;Doctor</label>
										</div>
									</li>
								</ul>

								<div id="signupPatientFields" ng-show="register.role == 4">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Enter Your Name" ng-model="patient.name">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Enter Your Mail ID" ng-model="patient.email">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Mobile Number" ng-model="patient.mobile">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" placeholder="Choose Password" ng-model="patient.password">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" placeholder="Confirm Password" ng-model="patient.confirmpassword">
									</div>
								</div>

								<div id="signupDoctorFields" ng-show="register.role == 2">
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Enter Your Name" ng-model="doctor.name">
											</div>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Enter Your Mail Id" ng-model="doctor.email">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Enter Mobile Number" ng-model="doctor.mob">
											</div>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<h5>Gender</h5>
												<label class="radio-inline">
													<input type="radio" name="gender" ng-model="doctor.gender" value="male">Male
												</label>
												<label class="radio-inline">
													<input type="radio" name="gender" ng-model="doctor.gender" value="female">Female
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group select">
												<select class="form-control" ng-model="doctor.speciality_id">
													{{-- <option>Select Specialization</option>
													@foreach($specialities as $speciality)
													<option value="{{$speciality->id}}">{{$speciality->name}}</option>
													@endforeach --}}
												</select>
											</div>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Medical Register Number" ng-model="doctor.registrationno">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Enter Your Password" ng-model="doctor.password">
											</div>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Confirm Your Password">
											</div>
										</div>
									</div>
								</div>

								<div class="form-group" style="margin: 2% 0px">
									<input id="ch" class="checkbox-custom" type="checkbox">
									<label for="ch" class="checkbox-custom-label">
										By Logging in you agree to our <a href="javascript:void(0);">T&C</a> and <a href="javascript:void(0);">Privacy Policy. </a>
									</label>
								</div>
								<div class="form-group" style="margin: 2% 0px">
									<input id="cha" class="checkbox-custom" type="checkbox">
									<label for="cha" class="checkbox-custom-label">
										Yes, I'm 18years old.
									</label>
								</div>
								<div class="form-group">
									<button class="btn ind-she-common-btn" type="submit">SIGN UP</button>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- #Register Model Ends-->

<!-- #Footer Starts -->
	<div class="container-fluid footer-background">
		<div class="footer-common">
			<div class="row">
				<div class="col-md-7 col-lg-7">
					<ul class="list-inline">
						<li><a href="javascript:void(0);">About Us</a></li>
						<li><a href="javascript:void(0);">Terms Of Use</a></li>
						<li><a href="javascript:void(0);">Privacy Policy</a></li>
						<li><a href="javascript:void(0)">News & Media</a></li>
						<li><a href="javascript:void(0);"> 2016 &copy; She Doctor All Rights Reserved</a></li>
						<li><a href="javascript:void(0);">FAQ's</a></li>
					</ul>
				</div>
				<div class="col-md-5 col-lg-5">
					<div class="row">
						<div class="col-md-6">
							<p class="text-center">Designed by : <a href="http://www.indglobal.in/" target="_blank">www.indglobal.in</a><p>
						</div>
						<div class="col-md-6">

							<ul class="list-inline social-button text-right">
								<li style="margin-top: 3px;">Follow Us On&#58;</li>
								<li class="facebook">
									<a href="javascript:void(0);" target="_blank">
										<span></span>
									</a>
								</li>
								<li class="twitter">
									<a href="javascript:void(0);" target="_blank">
										<span></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- #Footer Ends -->
	<script>
		var token = '{{ Session::token() }}';
	</script>
	<script type="text/javascript" src="/ui/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/ui/plugins/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script src="/ui/js/amazingcarousel.js"></script>
	<script src="/ui/js/initcarousel-1.js"></script>
	<script src="{{ asset('assets/angular/app.js')}}"></script>
	<script type="text/javascript" src="/ui/js/vipin.js"></script>
</body>
</html>