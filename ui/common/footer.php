<!-- #Footer Starts -->
	<div class="container-fluid footer-background">
		<div class="footer-common">
			<div class="row">
				<div class="col-md-5 col-lg-5">
					<ul class="list-inline">
						<li><a href="javascript:void(0);">About Us</a></li>
						<li><a href="javascript:void(0);">Terms Of Use</a></li>
						<li><a href="javascript:void(0);">Privacy Policy</a></li>
						<li><a href="javascript:void(0)">News &#38; Media</a></li>
						<li><a href="javascript:void(0);">FAQ's</a></li>
					</ul>
				</div>
				<div class="col-md-3 col-lg-3">
					<ul class="list-unstyled">
						<li><a href="javascript:void(0);"> 2016 &copy; She Doctr All Rights Reserved</a></li>
					</ul>
				</div>
				<div class="col-md-4 col-lg-4">
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
						<li class="linked-in">
							<a href="javascript:void(0);" target="_blank">
								<span></span>
							</a>
						</li>
						<li class="instagram">
							<a href="javascript:void(0);" target="_blank">
								<span></span>
							</a>
						</li>
						<li class="youtube">
							<a href="javascript:void(0);" target="_blank">
								<span></span>
							</a>
						</li>
					</ul>	
				</div>
			</div>
		</div>
	</div>
<!-- #Footer Ends -->

<!-- #Register Model -->
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
							<form action="javascript:void(0);">
								<p>Sign In As</p>
								<ul class="list-inline">
									<li>
										<div class="radio">
											<input id="patient" type="radio" name="loginas" checked>
											<label for="patient">Patient</label>
										</div>
									</li>
									<li>
										<div class="radio">
											<input id="doctor" type="radio" name="loginas">
											<label for="doctor">Doctor</label>
										</div>
									</li>
								</ul>
								<div class="form-group on-focus clearfix" style="position: relative;">
									<input type="text" class="form-control myDesign" placeholder="Enter Your Mail/Phone Number">
									<div class="tool-tip bottom  slideIn ">Enter Your Phone Number/Email</div>
								</div>
								<div class="form-group on-focus clearfix" style="position: relative;">
									<input type="password" class="form-control myDesign" placeholder="Enter Password">
									<div class="tool-tip bottom  slideIn ">Enter Password</div>
								</div>
								<div class="form-group">
									<p>Forgot Password?<a href="javascript:void(0);">&nbsp;Click Here</a></p>
								</div>
								<div class="form-group">
									<button class="btn 	ind-she-common-btn">SIGN IN</button>
									<div style="margin-top:5px">
										<input id="ch11" class="checkbox-custom" type="checkbox">
										<label for="ch11" class="checkbox-custom-label">
										I Agree with the <a href="javascript:void(0);">Terms &amp; Conditions</a>	
										</label>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="signup">
						<div class="ind-she-login">
							<form action="javascript:void(0);">
								<p>Sign Up As</p>
								<ul class="list-inline she-logn-signin">
									<li>
										<div class="radio">
											<input id="new_patient" class="signUpAs" type="radio" name="signupas" checked>
											<label for="new_patient">Patient</label>
										</div>
									</li>
									<li>
										<div class="radio">
											<input id="new_doctor" class="signUpAs" type="radio" name="signupas">
											<label for="new_doctor">&nbsp;&nbsp;Doctor</label>
										</div>
									</li>
								</ul>
								<div id="signupPatientFields">
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="text" class="form-control myDesign" placeholder="Enter Your Name">
										<div class="tool-tip bottom  slideIn ">Enter Your Name</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="email" class="form-control myDesign" placeholder="Enter Your Mail ID">
										<div class="tool-tip bottom  slideIn ">Enter Your Mail ID</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="text" class="form-control myDesign" placeholder="Mobile Number">
										<div class="tool-tip bottom  slideIn ">Mobile Number</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="password" class="form-control myDesign" placeholder="Choose Password">
										<div class="tool-tip bottom  slideIn ">Choose Password</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="password" class="form-control myDesign" placeholder="Confirm Password">
										<div class="tool-tip bottom  slideIn ">Confirm Password</div>
									</div>
								</div>
								<div id="signupDoctorFields">
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="text" class="form-control myDesign" placeholder="Enter Your Name">
										<div class="tool-tip bottom  slideIn ">Enter Your Name</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="email" class="form-control myDesign" placeholder="Enter Your Mail ID">
										<div class="tool-tip bottom  slideIn ">Enter Your Mail ID</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="text" class="form-control myDesign" placeholder="Mobile Number">
										<div class="tool-tip bottom  slideIn ">Mobile Number</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="text" class="form-control myDesign" placeholder="Medical Register Number">
										<div class="tool-tip bottom  slideIn ">Medical Register Number</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="password" class="form-control myDesign" placeholder="Choose Password">
										<div class="tool-tip bottom  slideIn ">Choose Password</div>
									</div>
									<div class="form-group on-focus clearfix" style="position: relative;">
										<input type="password" class="form-control myDesign" placeholder="Confirm Password">
										<div class="tool-tip bottom  slideIn ">Confirm  Password</div>
									</div>
									<!-- <div class="row">
										<div class="col-sm-6">
											 <div class="form-group select">
												<select class="form-control myDesign">
													<option>Select Specialization</option>
													<option>Dermatology</option>
													<option>Cosmetologist</option>
													<option>Pediatric Dermatology</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group" style="margin-top:15px;">
												<label class="radio-inline">
													<input type="radio" name="gender">Male
												</label>
												<label class="radio-inline">
													<input type="radio" name="gender">Female
												</label>
											</div>
										</div>
									</div> -->
								</div>
								<div class="form-group" style="margin: 1% 0px">
									<input id="ch" class="checkbox-custom" type="checkbox">
									<label for="ch" class="checkbox-custom-label">
										I Agree with the <a href="javascript:void(0);">Terms &amp; Conditions</a>	
									</label>
								</div>
								<div class="form-group" style="margin: 1% 0px">
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
<!-- #Register Model -->


	<script type="text/javascript" src="/ui/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/ui/plugins/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/ui/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/ui/js/bootstrap-datepicker.min.js"></script>
	<script src="/ui/js/amazingcarousel.js"></script>
	<script src="/ui/js/initcarousel-1.js"></script>
	<script type="text/javascript" src="/ui/js/wow.min.js"></script>
	<script src="/ui/js/state.js"></script>
	<script type="text/javascript" src="/ui/js/custom_js.js"></script>
	<script>
		new WOW().init();
	</script>
</body>
</html>