<?php include('common/patient-header.php'); ?>

<div class="container-fluid patient-profile-container" >
	<div class="sticky-items">
		<img src="images/my_uploads.png" alt="" title="My Uploads" ng-click="tabIndex = 6">
		<img src="images/lab-test.png" alt=""  title="Lab Tests" ng-click="tabIndex = 3">
		<img src="images/medicine.png" alt="" title="Medicines" ng-click="tabIndex = 2">
	</div>
	<div class="profile-container">
		<div class="patient-profile-rows">
			<div class="col-xs-3 text-center">
				<div class="">
					<!-- <div class="background-white patient-info">
						<div class="profile-pic">
							<img src="images/doctorPage.png" alt="" class="img-circle">
						</div>
						<a href="#" class="change-profile-pic">Change profile pic</a>
						<h4>Rajeev Kukarni</h4>
						<span class="patirnt-id">ID:SHDCTRDEF3484</span>
					</div> -->
					<div class="doctorOnline">
						<center>
							<img src="/ui/images/doctorPage.png" id="doctor-profile-picute-set" class="img-rounded img-responsive">
							<a href="javascript:void(0);" id="change-profile-click">Change Profile Pic</a>
							<input type="file" id="browse-image">
							<h4 data-toggle="modal" data-target="#thankyoumodal">Rajeev Kukarni</h4>
							<p>id:shdctr2308</p>
						</center>
					</div>
					<div class="patient-sidebar background-white">
						<ul>
							<li ng-click="tab(1)" ng-class="{active : tabIndex === 1 }">Appointments</li>
							<li ng-click="tab(2)" ng-class="{active : tabIndex === 2 }">Medicines</li>
							<li ng-click="tab(3)" ng-class="{active : tabIndex === 3 }">Lab Tests</li>
							<li ng-click="tab(4)" ng-class="{active : tabIndex === 4 }">My Profile</li>
							<li ng-click="tab(5)" ng-class="{active : tabIndex === 5 }">Doctor Prescription</li>
							<li ng-click="tab(6)" ng-class="{active : tabIndex === 6 }">My Uploads</li>
							<li ng-click="tab(7)" ng-class="{active : tabIndex === 7 }">Refer and earn</li>
							<li ng-click="tab(8)" ng-class="{active : tabIndex === 8 }">Customer Support</li>
							<li ng-click="tab(9)" ng-class="{active : tabIndex === 9 }">Feedback</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-xs-9">
				<div class="appointments-section background-white clearfix" ng-show="tabIndex == 1">
					<div class="tabHeading">
						<h3>Appointments
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="padding10px20px">
					  <div class="AppointmentSection">
					 		<ul class="nav nav-tabs" role="tablist">
					 			<li role="presentation" class="active">
						    	<a href="#upcoming-appointments" aria-controls="upcoming-appointments" role="tab" data-toggle="tab">Upcoming Appointments</a>
						    	<div class="arrow-up"></div>
						    </li>
						    <li role="presentation">
						    	<a href="#past-appointments" aria-controls="past-appointments" role="tab" data-toggle="tab">Past Appointments</a>
						    	<div class="arrow-up"></div>
						    </li>
					 		</ul>
						</div>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="upcoming-appointments">
					    	<table class="appointment-table table table-bordered">
					    		<thead>
					    			<tr>
					    				<th>Appointment type</th>
					    				<th>Doctor Name</th>
					    				<th>Patient Name</th>
					    				<th>Appointment ID</th>
					    				<th>Time &amp; Date</th>
					    				<th>Call starts in</th>
					    				<th>Action</th>
					    			</tr>
					    		</thead>
					    		<tbody>
					    			<tr>
						    			<td><img src="images/ring.png" alt=""></td>
						    			<td>Dr. Rohini Dermotalogist</td>
						    			<td>
						    				Rajeev Kuklkarni
						    				SHDCTOR0056
						    			</td>
						    			<td>SHDCTOR0056</td>
						    			<td>
						    				2:30 pm
						    				April 02, 2016
						    			</td>
						    			<td>10 hrs</td>
						    			<td class="appointment-action">
						    				<a href="" class="start-apt btn btn-small">Start</a>	<a href="" class="btn btn-small cancel-apt">Cancel</a>
						    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
						    			</td>
					    		</tr>

					    		<tr>
						    			<td><img src="images/webcam.png" alt=""></td>
						    			<td><b>Dr. Rohini</b> Dermotalogist</td>
						    			<td><b>Rajeev Kuklkarni</b>
						    				SHDCTOR0056
						    			</td>
						    			<td>SHDCTOR0056</td>
						    			<td>
						    				2:30 pm
						    				April 02, 2016
						    			</td>
						    			<td>10 hrs</td>
						    			<td class="appointment-action">
						    				<a href="" class="start-apt btn btn-small">Start</a>	<a href="" class="btn btn-small cancel-apt">Cancel</a>
						    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
						    			</td>
					    		</tr>

					    		<tr>
						    			<td><img src="images/ring.png" alt=""></td>
						    			<td>Dr. Rohini Dermotalogist</td>
						    			<td>
						    				Rajeev Kuklkarni
						    				SHDCTOR0056
						    			</td>
						    			<td>SHDCTOR0056</td>
						    			<td>
						    				2:30 pm
						    				April 02, 2016
						    			</td>
						    			<td>10 hrs</td>
						    			<td class="appointment-action">
						    				<a href="" class="start-apt btn btn-small">Start</a>	<a href="" class="btn btn-small cancel-apt">Cancel</a>
						    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
						    			</td>
					    		</tr>
					    		</tbody>
								</table>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="past-appointments">
					    	<table class="appointment-table table table-bordered">
					    		<thead>
					    			<tr>
					    				<th>Appointment type</th>
					    				<th>Doctor Name</th>
					    				<th>Patient Name</th>
					    				<th>Appointment ID</th>
					    				<th>Time &amp; Date</th>
					    				<th>Doctor Prescription</th>
					    				<th>Call Status</th>
					    				<th>Reason</th>
					    				<th>Action</th>
					    			</tr>
					    		</thead>
					    		<tbody>
							    			<tr>
								    			<td><img src="images/webcam.png" alt=""></td>
								    			<td>Dr. Rohini Dermotalogist</td>
								    			<td>
								    				Rajeev Kuklkarni
								    				SHDCTOR0056
								    			</td>
								    			<td>SHDCTOR0056</td>
								    			<td>
								    				2:30 pm
								    				April 02, 2016
								    			</td>
								    			<td>Not Available</td>
								    			<td><p class="danger">Failed</p></td>
								    			<td>
								    				Something Went wrong
								    			</td>
								    			<td class="appointment-action">
								    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
								    				<a href="" class="btn btn-small cancel-apt">Cancel</a>
								    			</td>
							    		</tr>
							    		<tr>
								    			<td><img src="images/ring.png" alt=""></td>
								    			<td>Dr. Rohini Dermotalogist</td>
								    			<td>
								    				Rajeev Kuklkarni
								    				SHDCTOR0056
								    			</td>
								    			<td>SHDCTOR0056</td>
								    			<td>
								    				2:30 pm
								    				April 02, 2016
								    			</td>
								    			<td>
								    				<i class="fa fa-file-text fa-2x" aria-hidden="true"></i><br/>Download
								    			</td>
								    			<td><p class="success">Completed</p></td>
								    			<td>
								    				N/A
								    			</td>
								    			<td class="appointment-action">
								    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
								    				<a href="" class="btn btn-small cancel-apt">Failed</a>
								    			</td>
							    		</tr>
							    		<tr>
							    			<td><img src="images/webcam.png" alt=""></td>
							    			<td>Dr. Rohini Dermotalogist</td>
							    			<td>
							    				Rajeev Kuklkarni
							    				SHDCTOR0056
							    			</td>
							    			<td>SHDCTOR0056</td>
							    			<td>
							    				2:30 pm
							    				April 02, 2016
							    			</td>
							    			<td>Not Available</td>
							    			<td><p class="danger">Cancel</p></td>
							    			<td>
							    				Something Went wrong
							    			</td>
							    			<td class="appointment-action">
							    				<a href="" class="btn btn-large reschedule-apt">Reschedule</a>
								    			<a href="" class="btn btn-small cancel-apt">Cancel</a>
							    			</td>
							    		</tr>
					    			</tbody>
								</table>
					    </div>
					  </div>
					</div>
				</div>

				<div class="medicine-section background-white clearfix" ng-show="tabIndex == 2">
					<div class="tabHeading">
						<h3>Medicine
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="padding10px20px">
						<div class="AppointmentSection">
					 		<ul class="nav nav-tabs" role="tablist">
					 			<li role="presentation" class="active">
						    	<a href="#place-medicine-order" aria-controls="place-medicine-order" role="tab" data-toggle="tab">Place Medicine Order</a>
						    	<div class="arrow-up"></div>
						    </li>
						    <li role="presentation">
						    	<a href="#view-ordered-medicine" aria-controls="view-ordered-medicine" role="tab" data-toggle="tab">View ordered medicine</a>
						    	<div class="arrow-up"></div>
						    </li>
					 		</ul>
						</div>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="place-medicine-order">
								<div class="row order-drug" ng-repeat="drug in drugs">
									<div class="col-sm-2">
										<h4>Drug type</h4>
										<select name="drug-type" id="">
											<option value="">Tab</option>
											<option value="">Syrup</option>
										</select>
									</div>
									<div class="col-sm-3">
										<h4>Drug Name</h4>
										<input type="text" name="drug-name" id="" placeholder="Enter Drug name">
									</div>
									<div class="col-sm-2">
										<h4>Unit</h4>
										<input type="text" name="" id="" placeholder="Mg">
									</div>
									<div class="col-sm-2">
										<h4>Qty</h4>
										<select name="" id="">
											<option value="">01</option>
											<option value="">02</option>
											<option value="">03</option>
										</select>
									</div>
									<div class="col-sm-2">
										add Note
									</div>
									<div class="col-sm-1">
										<a href="" class="close" ng-click="removeDrug(drug)">X</a>
									</div>
								</div>
								<div class="add-more-drug text-right"><a href="" ng-click="addDrug()">+ Add more</a></div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="view-ordered-medicine">

					    </div>
					  </div>
					</div>

					<div class="padding10px20px">
						<div class="row">
							<div class="col-xs-6">
								<input type="radio" name="prescription" id="" value="existing">
								<label for="">Use existing prescription or upload new</label>
							</div>
							<div class="col-xs-6">
								<input type="radio" name="prescription" id="" value="existing">
								<label for="">Use existing prescription or upload new</label>
							</div>
						</div>

						<div class="percription row">
							<div class="col-xs-3">
								<div class="img-prescription">
									<img src="images/prescription.png" class="img-responsive" alt="">
								</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this prescription</label>
							</div>

							<div class="col-xs-3">
								<div class="img-prescription">
									<img src="images/prescription.png" class="img-responsive" alt="">
								</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this prescription</label>
							</div>

							<div class="col-xs-6">
								upload new
							</div>
						</div>
					</div>
					<div class="padding10px20px">
						<h4>Add Delivery Address</h4>
						<div class="">
							<div class="col-xs-5">
								<div class="user-address">
									<span class="remove-address">X</span>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua.
								</div>
								<div class="edit-address">Edit Address</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this address for medicine delivery</label>
							</div>
							<div class="col-xs-5">
								<div class="user-address">
									<span class="remove-address">X</span>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua.
								</div>
								<div class="edit-address">Edit Address</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this address for medicine delivery</label>
							</div>
							<div class="col-xs-2 text-center add-new-address">
								<div>+</div>
								<div>Add New</div>
								<div>Delivery Address</div>
							</div>
						</div>
					</div>

					<div class="place-order">
						<input type="submit" value="Place order" class="place-order-button btn btn-lg btn-schedule"> 
					</div>
				</div>

				<div class="lab-test-section background-white clearfix" ng-show="tabIndex == 3">
					<div class="tabHeading">
						<h3>Lab Tests
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="padding10px20px">
					  <div class="AppointmentSection">
					 		<ul class="nav nav-tabs" role="tablist">
					 			<li role="presentation" class="active">
						    	<a href="#lab-test-order" aria-controls="lab-test-order" role="tab" data-toggle="tab">Lab Test Order</a>
						    	<div class="arrow-up"></div>
						    </li>
						    <li role="presentation">
						    	<a href="#past-lab-order" aria-controls="past-lab-order" role="tab" data-toggle="tab">Past Lab Test Order</a>
						    	<div class="arrow-up"></div>
						    </li>
					 		</ul>
						</div>


					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="lab-test-order">
								<div class="row order-drug" ng-repeat="test in tests">
									<div class="col-sm-3">
										<h4>Test Name</h4>
										<input type="text" name="" id="" placeholder="enter test name">
									</div>
									<div class="col-sm-3">
										<h4>Test Date</h4>
										<input type="date" name="" id="" placeholder="">
									</div>
									<div class="col-sm-3">
										<h4>Test Time</h4>
										<input type="time" name="" id="" placeholder="">
									</div>
									<div class="col-sm-2">
										add Note
									</div>
									<div class="col-sm-1">
										<a href="" class="close" ng-click="removeTest(test)">X</a>
									</div>
								</div>
								<div class="add-more-drug text-right"><a href="" ng-click="addTest()">+ Add more</a></div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="past-lab-order">

					    </div>
					  </div>
					</div>

					<div class="padding10px20px">
						<div class="row">
							<div class="col-xs-6">
								<input type="radio" name="prescription" id="" value="existing">
								<label for="">Use existing prescription or upload new</label>
							</div>
							<div class="col-xs-6">
								<input type="radio" name="prescription" id="" value="existing">
								<label for="">Use existing prescription or upload new</label>
							</div>
						</div>

						<div class="percription row">
							<div class="col-xs-3">
								<div class="img-prescription">
									<img src="images/prescription.png" class="img-responsive" alt="">
								</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this prescription</label>
							</div>

							<div class="col-xs-3">
								<div class="img-prescription">
									<img src="images/prescription.png" class="img-responsive" alt="">
								</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this prescription</label>
							</div>

							<div class="col-xs-6">
								upload new
							</div>
						</div>
					</div>

					<div class="padding10px20px">
						<h4>Add Delivery Address</h4>
						<div class="row">
							<div class="col-xs-5">
								<div class="user-address">
									<span class="remove-address">X</span>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua.
								</div>
								<div class="edit-address">Edit Address</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this address for medicine delivery</label>
							</div>
							<div class="col-xs-5">
								<div class="user-address">
									<span class="remove-address">X</span>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua.
								</div>
								<div class="edit-address">Edit Address</div>
								<input type="checkbox" name="" id="">
								<label for="">Use this address for medicine delivery</label>
							</div>
							<div class="col-xs-2 text-center add-new-address">
								<div>+</div>
								<div>Add New</div>
								<div>Delivery Address</div>
							</div>
						</div>
					</div>

					<div class="place-order">
						<input type="submit" value="Place order" class="place-order-button btn btn-lg btn-lg"> 
					</div>
				</div>

				<div class="my-profile-section background-white clearfix" ng-show="tabIndex == 4"> 
					<div class="tabHeading">
						<h3>My Profile
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="doctor-profile-details">
						<div class="common-content-doctor-details">
							<div class="basic-info-head">
								<h4>Basic Info</h4>
							</div>
							<div class="common-padding-doctor">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">First Name</label>
											<input type="text" class="form-control myDesign" placeholder="First Name">
											<div class="tool-tip bottom  slideIn ">First Name</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Last Name</label>
											<input type="text" class="form-control myDesign" placeholder="Last Name">
											<div class="tool-tip bottom  slideIn ">Last Name</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Email ID</label>
											<input type="text" class="form-control myDesign" placeholder="testing@shedoctr.com">
											<div class="tool-tip bottom  slideIn ">Email ID</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Mobile Number</label>
											<input type="text" class="form-control myDesign" placeholder="9000090000">
											<div class="tool-tip bottom  slideIn ">Mobile Number</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<label for="" class="control-label">Date Of Birth</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY">
									</div>
									<div class="col-sm-6">
										<label for="" class="control-label">Gender</label>
										<div class="select">
											<select class="form-control">
												<option value="">Male</option>
												<option value="">Female</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<label for="" class="control-label">Height</label>
										<div class="row">
											<div class="col-sm-6">
												<div class="select">
													<select class="form-control">
														<option value="">1 Feet</option>
														<option value="">2 Feet</option>
														<option value="">3 Feet</option>
														<option value="">4 Feet</option>
														<option value="">5 Feet</option>
														<option value="">6 Feet</option>
														<option value="">7 Feet</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="select">
													<select class="form-control">
														<option value="">1 Inch</option>
														<option value="">2 Inch</option>
														<option value="">3 Inch</option>
														<option value="">4 Inch</option>
														<option value="">5 Inch</option>
														<option value="">6 Inch</option>
														<option value="">7 Inch</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<label for="" class="control-label">Blood Group</label>
										<div class="select">
											<select class="form-control">
												<option value="">A +Ve</option>
												<option value="">A -Ve</option>
												<option value="">B +Ve</option>
												<option value="">B -Ve</option>
												<option value="">AB +Ve</option>
												<option value="">AB -Ve</option>
												<option value="">O +Ve</option>
												<option value="">O -Ve</option>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<label for="" class="control-label">Weight</label>
										<div class="select">
											<select class="form-control">
												<option value="">80Kg</option>
												<option value="">85Kg</option>
												<option value="">90Kg</option>
												<option value="">35Kg</option>
												<option value="">40Kg</option>
												<option value="">100Kg</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="basic-info-head">
								<h4>Address</h4>
							</div>
							<div class="common-padding-doctor">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">House Number</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">House Number</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Street</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">Street</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Address1</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">Address1</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">Address2</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">Address2</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">State</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">State</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group on-focus clearfix" style="position: relative;">
											<label for="" class="control-label">City</label>
											<input type="text" class="form-control myDesign">
											<div class="tool-tip bottom  slideIn ">City</div>
										</div>
									</div>
								</div>
								<div class="btn-profile-update">
									<ul class="list-inline">
										<li>
											<button class="btn btn-schedule">Update Profile</button>
										</li>
										<li>
											<button class="btn btn-preview">Cancel</button>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="doctor-prescription background-white clearfix" ng-show="tabIndex == 5">
					<div class="tabHeading">
						<h3>Doctor Prescription
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle fa-2x" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="clearfix prescriprion-container">
						<div class="col-xs-6 col-sm-3">
							<div class="prescription">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
								<h4>Dr. Deepa Kulkarni</h4>
								<span>Speciality: Dentist</span> <br>
								<span>Patient Name</span><br>
								<h4>Rajeev Kulkarni</h4>
								<span>March 10, 2016</span>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="prescription">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
								<h4>Dr. Deepa Kulkarni</h4>
								<span>Speciality: Dentist</span> <br>
								<span>Patient Name</span><br>
								<h4>Rajeev Kulkarni</h4>
								<span>March 10, 2016</span>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="prescription">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
								<h4>Dr. Deepa Kulkarni</h4>
								<span>Speciality: Dentist</span> <br>
								<span>Patient Name</span><br>
								<h4>Rajeev Kulkarni</h4>
								<span>March 10, 2016</span>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="prescription">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
								<h4>Dr. Deepa Kulkarni</h4>
								<span>Speciality: Dentist</span> <br>
								<span>Patient Name</span><br>
								<h4>Rajeev Kulkarni</h4>
								<span>March 10, 2016</span>
						</div>

					</div>
				</div>

				<div class="my-uploads background-white clearfix" ng-show="tabIndex == 6">
					<div class="section-title clearfix">
						<div class="col-xs-9"><h4>My Uploads
							<span class="pull-right">
							<div class="dropdown">
								<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
									<ul class="dropdown-menu edit-change-password">
								    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
								    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
									</ul>
							</div>
						</span>
						</h4></div>
						<div class="col-xs-3">
								<img src="images/upload-file.png" alt="" ng-click="uploadNew = true"><i class="fa fa-2x fa-cog pull-right" aria-hidden="true"></i>
						</div>
					</div>
					<div class="" ng-hide="uploadNew">
						<div class="col-xs-6 col-sm-3">
							<div class="my-upload">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="my-upload">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="my-upload">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<div class="my-upload">
								<img src="images/prescription.png" alt="" class="img-responsive">
								<i class="fa fa-trash" aria-hidden="true">&nbsp;Delete</i>
							</div>
						</div>
					</div>

					<div class="upload-new-report" ng-show="uploadNew">
							<div class="my-upload-form">
									<form>
									  <div class="form-group">
									    <select name="" id="" class="form-control">
									    	<option value="">hello world</option>
									    	<option value="">hello world</option>
									    	<option value="">hello world</option>
									    	<option value="">hello world</option>
									    </select>
									  </div>
									  <div class="form-group">
									    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Give title for your upload">
									  </div>
									  <div class="form-group">
									  	<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Give title for your upload">
									  </div>
									  <div class="form-group">
									    <label for="exampleInputFile">File input</label>
									    <input type="file" id="exampleInputFile">
									    <p class="help-block">note</p>
									  </div>
									  <button type="submit" class="btn btn-default">Submit</button>
									  <button type="reset" class="btn btn-default">Cancel</button>
									</form>
							</div>
					</div>
				</div>

				<div class="refer-n-earn background-white clearfix" ng-show="tabIndex == 7">
					<div class="tabHeading">
						<h3>Refer &amp; Earn
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
						<div class="padding10px20px">
							<div class="AppointmentSection">
						 		<ul class="nav nav-tabs" role="tablist">
						 			<li role="presentation" class="active">
							    	<a href="#refer-a-friend" aria-controls="refer-a-friend" role="tab" data-toggle="tab">Refer A friend</a>
							    	<div class="arrow-up"></div>
							    </li>
							    <li role="presentation">
							    	<a href="#credit-point-history" aria-controls="credit-point-history" role="tab" data-toggle="tab">Credit Point History</a>
							    	<div class="arrow-up"></div>
							    </li>
						 		</ul>
							</div>

						  <div class="tab-content">
						    <div role="tabpanel" class="tab-pane active" id="refer-a-friend">
							    	<div class="padding10px20px">
							    		<img src="images/refer-n-earn.png" alt="" class="refer-friend-img img-responsive">
							    		<div class="text-center">She Doctr Refer and Earn Program lets you invite your friends to join shedoctr.com</div>
							    		<div class="text-center">For every friend you successfully refer to shedoctr, you will receive a credit worth of Rs 100, redeemable on the site towards consultation.</div>

							    	<div class="row">
							    		<div class="col-xs-12 col-sm-6">
							    			<form action="">
									    		<div class="refer-friend-inputs">
									    			<input type="email" name="" id="" placeholder="Your friend mail id">
									    		</div>
									    		<div class="refer-friend-inputs">
														<input type="text" name="" id="" placeholder="Your friend mobile number">
													</div>
													<button type="submit" class="btn btn-lg btn-submit">Add friend</button>
									    	</form>
							    		</div>
							    		<div class="col-xs-12 col-sm-6">
							    		</div>
							    	</div>

							    	<span>Or Add Contact from</span>

							    	<div><button class="btn btn-lg btn-fb">Facebook</button> or <button class="btn btn-lg btn-google">Google</button></div>
							    </div>
						    </div>
						    <div role="tabpanel" class="tab-pane" id="credit-point-history">
										<!-- <div class="padding10px20px clearfix refer-desc"> -->

											<table class="table table-bordered">
												<tr>
													<td align="left" width="80%">
														Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo onsequat.
														<p>Transactiondate : <span>April 19,2016</span></p>
													</td>
													<td class="vert-align">
														<p class="text-center">Credit Points</p>
														<p class="text-center">100.00</p>
													</td>
												</tr>

												<tr>
													<td>
														Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo onsequat.
														<p>Transactiondate : <span>April 19,2016</span></p>
													</td>
													<td class="vert-align">
														<p class="text-center">Credit Points</p>
														<p class="text-center">100.00</p>
													</td>
												</tr>
											</table>
										<!-- </div> -->
						    </div>
						  </div>
						</div>
				</div>

				<div class="customer-support background-white clearfix" ng-show="tabIndex == 8">
					<div class="tabHeading">
						<h3>Customer Support
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="">

						<div class="col-sm-6 col-xs-12 contact-email-ids">
							<h4>Contact Mail Id</h4>
							<br>
							<p class="contact-email-id">info@shedoctr.com</p>
							<p class="contact-email-id">info@shedoctr.com</p>
							<br>
							<p class="contact-email-id">info@shedoctr.com</p>
							<p class="contact-email-id">info@shedoctr.com</p>
							<p><img src="images/toll-free.png" alt=""> <span class="toll-free">1-800-100-123</span></p>
						</div>
						
						<div class="col-sm-6 col-xs-12 border-left">
						<h4 class="text-center">Enquiry with us</h4>
							<div class="query-form-container">
								<p class="text-center">Have any queries regarding <span class="site-name">SheDoctr?</span> Reach out to us filling this form</p>
								<form action="#">
									<input type="text" name="" id="" placeholder="something">
									<input type="text" name="" id="" placeholder="something">
									<input type="text" name="" id="" placeholder="something">
									<input type="text" name="" id="" placeholder="something">
									<textarea name="" id="" rows="5">Your query</textarea>

									<button type="submit" class="btn btn-lg btn-schedule">Submit</button>
								</form>
							</div>
						</div>
						
					</div>
				</div>

				<div class="feedback background-white clearfix" ng-show="tabIndex == 9">
					<div class="tabHeading">
						<h3>Customer Feedback Form
							<span class="pull-right">
								<div class="dropdown">
									<i class="fa fa-cog dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i>
										<ul class="dropdown-menu edit-change-password">
									    <li><a href="javascript:void(0);"><p class="commonColor">Edit Profile</p></a></li>
									    <li><a href="javascript:void(0);"><p class="commonColor">Change Password</p></a></li>
										</ul>
								</div>
							</span>
						</h3>
					</div>
					<div class="feedback-form col-xs-6">
					<form action="">
						<div class="">
							<label for="">Select Topic</label> <br>
							<select name="" id="">
								<option value="">Service Offered</option>
								<option value=""></option>
								<option value=""></option>
							</select>
						</div>

						<div class="rating-buttons">
								<div>Your Rating</div>
								<label for="poor">
									<input type="radio" name="ratings" id="poor" class="poor">
									<img src="images/poor.png" alt="">
									<p>Poor</p>
								</label>
								
								<label for="liked">
									<input type="radio" name="ratings" id="liked" class="poor">
									<img src="images/poor.png" alt="">
									<p>Liked</p>
								</label>
								<label for="average">
									<input type="radio" name="ratings" id="average" class="poor">
									<img src="images/poor.png" alt="">
									<p>Average</p>
								</label>

								<label for="good">
									<input type="radio" name="ratings" id="good" class="good">
									<img src="images/good.png" alt="">
									<p>Good</p>
								</label>

								<label for="excellent">
									<input type="radio" name="ratings" id="excellent" class="good">
									<img src="images/good.png" alt="">
									<p>Excellent</p>
								</label>
						</div>

						<label for="feedback">Your Feedback</label>
						<textarea name="" id="" cols="30" rows="10">Type your Feedback</textarea>

						<button type="submit" class="btn btn-schedule">Submit</button>
					<form>
					</div>

					<div class="col-xs-6"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('common/footer.php'); ?>