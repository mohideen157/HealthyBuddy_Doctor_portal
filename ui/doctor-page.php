<?php include('common/doctor-header.php') ?>
	<!-- #Doctor Details Starts Here -->
	<div class="container-fluid doctorPageProfile">
		<div class="container padding-left-remove">
			<div class="row">
				<div class="col-sm-3 col-md-3 col-lg-3"><!--Doctor Right Section -->
					<div class="doctorOnline">
						<center>
							<img src="/ui/images/doctorPage.png" id="doctor-profile-picute-set" class="img-rounded img-responsive">
							<a href="javascript:void(0);" id="change-profile-click">Change Profile Pic</a>
							<input type="file" id="browse-image">
							<h4 data-toggle="modal" data-target="#thankyoumodal">Dr. Sanjivini Rao</h4>
							<p>id:shdctr2308</p>
					    	<label class="switch switch-left-right">
						    	<input class="switch-input" type="checkbox" checked="true" id='doctor_status' />
						    	<span class="switch-label"></span> 
						    	<span class="switch-handle"></span> 
				    		</label>
					    	<small>You are Online</small>
					    	<div class="clearfix"></div>
						</center>
					</div>
					<div class="doctorProfileTab">
						<ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active">
					    	<a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a>
					    </li>
					    <li role="presentation">
					    	<a href="#consultfee" aria-controls="consultfee" role="tab" data-toggle="tab">Consultation Time &#38; Fees</a>
					    </li>
					    <li role="presentation">
					    	<a href="#healthTips" aria-controls="healthTips" role="tab" data-toggle="tab">Health Tips</a>
					    </li>
					    <li role="presentation">
					    	<a href="#doctor-profile" aria-controls="-doctor-profile" role="tab" data-toggle="tab">My Profile</a>
					    </li>
					    <li role="presentation">
					    	<a href="#ledger" aria-controls="ledger" role="tab" data-toggle="tab">Ledger</a>
					    </li>
					    <li role="presentation">
					    	<a href="#payments" aria-controls="payments" role="tab" data-toggle="tab">Payments</a>
					    </li>
					    <li role="presentation">
					    	<a href="#bankDetails" aria-controls="bankDetails" role="tab" data-toggle="tab">Bank Details</a>
					    </li>
					    <li role="presentation">
					    	<a href="#doctorSign" aria-controls="doctorSign" role="tab" data-toggle="tab">Doctor Signature</a>
					    </li>
					    <li role="presentation">
					    	<a href="#feedback" aria-controls="feedback" role="tab" data-toggle="tab">Feedback</a>
					    </li>
					  </ul>
					</div>
				</div><!--Doctor Right Section Ends -->
				<div class="col-sm-9 col-md-9 col-lg-9"><!--Doctor Left Section -->
					<div class="doctorContentDetails">
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="appointments"><!-- Appointment -->
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
								<div class="AppointmentSection">
									 <div class="row">
									 	<div class="col-sm-6">
									 		<ul class="nav nav-tabs" role="tablist">
									 			<li role="presentation" class="active">
										    	<a href="#upcomingApp" aria-controls="upcomingApp" role="tab" data-toggle="tab">Upcoming Appointments</a>
										    	<div class="arrow-up"></div>
										    </li>
										    <li role="presentation">
										    	<a href="#pastApp" aria-controls="pastApp" role="tab" data-toggle="tab">Past Appointments</a>
										    	<div class="arrow-up"></div>
										    </li>
									 		</ul>
									 	</div>
									 	<div class="col-sm-6 text-right">
											<div class="filterByDate text-right">
												<div class="form-group form-inline posRel">
													<label class="control-label">Filter By Date</label>
													<input type="text" id="filterDate" class="form-control" placeholder="All Upcoming Appointments">
													<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
												</div>
											</div>
									 	</div>
									 </div>
								</div>
								<div class="patientAppointmentDetails">
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="upcomingApp"><!-- UpComingApp -->
											<!-- <div class="filterByDate text-right">
												<div class="form-group form-inline posRel">
													<label class="control-label">Filter By Date</label>
													<input type="text" id="filterDate" class="form-control" placeholder="All Upcoming Appointments">
													<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
												</div>
											</div> -->
											<div class="UpcomingAppDetails">
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Hadimani</h4>
						                                <!-- <p class="text-uppercase commonColor">Patient Id:shdct3313</p> -->
						                                <ul class="list-inline">
						                                  <li><a href="javascript:void(0);">Prescription</a></li>
						                                  <li><a href="javascript:void(0);">Lab Reports</a></li>
						                                </ul>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appiontment ID</p>
														<p class="text-uppercase">SHDCT351</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Timing</p>
														<p>2:30 pm</p>
														<p>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Starts In</p>
														<p>10 Hrs</p>
													</li>
													<li class="commonWidth">
														<button class="btn btn-schedule">Cancel</button>
													</li>
												</ul>
												<ul class="list-inline heightWeightComn">
													<li><span>Height:</span>&nbsp;5.7</li>
													<li><span>Weight:</span>&nbsp;65Kg</li>
													<li><span>Blood Group:</span>&nbsp;'O'&nbsp;Positive</li>
													<li class="pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></li>
												</ul>
												<div class="patientSymptoms" hidden="true">
													<h4>Allergies</h4>
													<p>
														Lorem Ipsum is a simply dummy text of the printing and typewriting industry.
														Lorem IPsum has been the industry's standard  dummy text ever since  1500's when  an unknown printer took a gallery of type and  scrambled  it to make a type  speciman book.
													</p>
												</div>
											</div>
											<div class="UpcomingAppDetails">
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Gopal</h4>
								                                <ul class="list-inline">
								                                  <li><a href="javascript:void(0);">Prescription</a></li>
								                                  <li><a href="javascript:void(0);">Lab Reports</a></li>
								                                </ul>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appiontment ID</p>
														<p class="text-uppercase" >SHDCT351</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png" ></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Timing</p>
														<p>2:30 pm</p>
														<p>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Starts In</p>
														<p>10 Hrs</p>
													</li>
													<li class="commonWidth">
														<button class="btn btn-schedule">Cancel</button>
													</li>
												</ul>
												<ul class="list-inline heightWeightComn">
													<li><span>Height:</span>&nbsp;5.7</li>
													<li><span>Weight:</span>&nbsp;65Kg</li>
													<li><span>Blood Group:</span>&nbsp;'O'&nbsp;Positive</li>
													<li class="pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></li>
												</ul>
												<div class="patientSymptoms" hidden="true">
													<h4>Allergies</h4>
													<p>
														Lorem Ipsum is a simply dummy text of the printing and typewriting industry.
														Lorem IPsum has been the industry's standard  dummy text ever since  1500's when  an unknown printer took a gallery of type and  scrambled  it to make a type  speciman book.
													</p>
												</div>
											</div>
										</div><!-- UpComingApp Ends -->

										<div role="tabpanel" class="tab-pane" id="pastApp"><!-- PastApp -->
											<div class="UpcomingAppDetails">
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Gopal</h4>
						                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
						                                <ul class="list-inline">
						                                  <li><a href="javascript:void(0);">Prescription</a></li>
						                                  <li><a href="javascript:void(0);">Lab Reports</a></li>
						                                </ul>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png" style="margin-top:20px"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Timing</p>
														<p>2:30 pm</p>
														<p>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p style="margin-top:30px;">Ended</p>
													</li>
													<li class="commonWidth nothingCancel">
														<!-- <p class="commonColor">Reason<span class="pull-right">Cancelled</span></p>
														<small class="text-justify">
															Lorem Ipsum is a simply dummy text of the printing and typewriting industry.
														</small> -->
														<center><i class="fa fa-check fa-3x" style="color:#8CC540;margin-top:20px;" aria-hidden="true"></i></center>
													</li>
												</ul>
												<ul class="list-inline heightWeightComn">
													<li><span>Height:</span>&nbsp;5.7</li>
													<li><span>Weight:</span>&nbsp;65Kg</li>
													<li><span>Blood Group:</span>&nbsp;'O'&nbsp;Positive</li>
													<li><a class="btn-schedule">Hide Prescription</a></li>
													<li class="pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></li>
												</ul>
												<div class="doctorPrescription" hidden="true">
													<div class="doctorDetails">
														<img src="/ui/images/logo-small.png">
														<ul class="list-inline">
															<li>
																<p class="commonColor">Doctor Name</p>
																<h4>Dr.Venu Kumari</h4>
															</li>
															<li>
																<p class="commonColor">Patient Name</p>
																<h4>Pavitra HAdimani</h4>
															</li>
															<li>
																<p class="commonColor">Doctor Speciality</p>
																<h4>Dentist</h4>
															</li>
															<li>
																<p class="commonColor">Patient ID</p>
																<h4>SHDCT3451</h4>
															</li>
														</ul>
														<p class="commonColor">Date:26/May/2016</p>
													</div>
													<div class="patientPrescriptionDetails">
															<p class="commonColor">Diagnosis Report</p>
															<div class="reportDiagnosis"></div>
															<div class="radio">
																<input id="lab-test" type="radio" name="labtest" checked="true">
																<label for="lab-test"> Lab Tests</label>
															</div>
															<ul class="list-inline medicineAndTest">
																<li>
																	<input id="bld1" class="checkbox-custom" type="checkbox" />
																	<label for="bld1" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray1" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray1" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld2" class="checkbox-custom" type="checkbox" />
																	<label for="bld2" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray2" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray2" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld3" class="checkbox-custom" type="checkbox" />
																	<label for="bld3" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray3" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray3" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld4" class="checkbox-custom" type="checkbox" />
																	<label for="bld4" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld5" class="checkbox-custom" type="checkbox" />
																	<label for="bld5" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray4" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray4" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld6" class="checkbox-custom" type="checkbox" />
																	<label for="bld6" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray5" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray5" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld7" class="checkbox-custom" type="checkbox" />
																	<label for="bld7" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray6" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray6" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld8" class="checkbox-custom" type="checkbox" />
																	<label for="bld8" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld9" class="checkbox-custom" type="checkbox" />
																	<label for="bld9" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray7" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray7" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld10" class="checkbox-custom" type="checkbox" />
																	<label for="bld10" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray8" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray8" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld11" class="checkbox-custom" type="checkbox" />
																	<label for="bld11" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray9" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray9" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld12" class="checkbox-custom" type="checkbox" />
																	<label for="bld12" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld13" class="checkbox-custom" type="checkbox" />
																	<label for="bld13" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray10" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray10" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld14" class="checkbox-custom" type="checkbox" />
																	<label for="bld14" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray11" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray11" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld15" class="checkbox-custom" type="checkbox" />
																	<label for="bld15" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray12" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray12" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld16" class="checkbox-custom" type="checkbox" />
																	<label for="bld16" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld17" class="checkbox-custom" type="checkbox" />
																	<label for="bld17" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray13" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray13" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld18" class="checkbox-custom" type="checkbox" />
																	<label for="bld18" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray14" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray14" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld19" class="checkbox-custom" type="checkbox" />
																	<label for="bld19" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray15" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray15" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld20" class="checkbox-custom" type="checkbox" />
																	<label for="bld20" class="checkbox-custom-label">Blood Test</label>
																</li>
															</ul>
															<div class="radio">
																<input id="other-test" type="radio" name="labtest">
																<label for="other-test"> Others</label>
															</div>
															<p class="commonColor">Medicine Details</p>
															<table class="table medicineTime table-bordered">
																<thead>
																	<tr>
																		<th>Medicine Name</th>
																		<th>Medicine Type</th>
																		<th>Morning</th>
																		<th>Afternoon</th>
																		<th>Evening</th>
																		<th>Night</th>
																		<th>Add Note</th>
																	</tr>
																</thead>
																<tr>
																	<td>Aspirine 500 mg</td>
																	<td>
																		 <select class="form-control">
																		 	<option>Tablet</option>
																		 	<option>Syrup</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td class="text-center">
																		<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
																	</td>
																</tr>
															</table>
															<p class="text-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add More</p>
															<div class="row">
																<div class="col-sm-6">
																	<img src="/ui/images/doctorCertificate.png" class="img-responsive">
																</div>
																<div class="col-sm-offset-1 col-sm-5">
																	<img src="/ui/images/signature.png">
																	<h4>Dr.Venu Kumari</h4>
																	<p class="commonColor">Specialist:&nbsp;Dental</p>
																	<p class="commonColor" style="margin-top:10px;">Doctor regjistration Number</p>
																	<p>111942A Karnataka State Dental Council</p>
																</div>
															</div>
															<div class="text-center">
																<button class="btn btn-preview">Preview</button>
															</div>
													</div>
												</div>
											</div>
											<div class="UpcomingAppDetails">
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Gopal</h4>
						                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
						                                <ul class="list-inline">
						                                  <li><a href="javascript:void(0);">Prescription</a></li>
						                                  <li><a href="javascript:void(0);">Lab Reports</a></li>
						                                </ul>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png" style="margin-top:20px"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Timing</p>
														<p>2:30 pm</p>
														<p>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p style="margin-top:30px;">Ended</p>
													</li>
													<li class="commonWidth nothingCancel">
														<!-- <p class="commonColor">Reason<span class="pull-right">Cancelled</span></p>
														<small class="text-justify">
															Lorem Ipsum is a simply dummy text of the printing and typewriting industry.
														</small> -->
														<center><i class="fa fa-check fa-3x" style="color:#8CC540;margin-top:20px;" aria-hidden="true"></i></center>
													</li>
												</ul>
												<ul class="list-inline heightWeightComn">
													<li><span>Height:</span>&nbsp;5.7</li>
													<li><span>Weight:</span>&nbsp;65Kg</li>
													<li><span>Blood Group:</span>&nbsp;'O'&nbsp;Positive</li>
													<li><a class="btn-schedule">Hide Prescription</a></li>
													<li class="pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></li>
												</ul>
												<div class="doctorPrescription" hidden="true">
													<div class="doctorDetails">
														<img src="/ui/images/logo-small.png">
														<ul class="list-inline">
															<li>
																<p class="commonColor">Doctor Name</p>
																<h4>Dr.Venu Kumari</h4>
															</li>
															<li>
																<p class="commonColor">Patient Name</p>
																<h4>Pavitra HAdimani</h4>
															</li>
															<li>
																<p class="commonColor">Doctor Speciality</p>
																<h4>Dentist</h4>
															</li>
															<li>
																<p class="commonColor">Patient ID</p>
																<h4>SHDCT3451</h4>
															</li>
														</ul>
														<p class="commonColor">Date:26/May/2016</p>
													</div>
													<div class="patientPrescriptionDetails">
															<p class="commonColor">Diagnosis Report</p>
															<div class="reportDiagnosis"></div>
															<div class="radio">
																<input id="lab-test" type="radio" name="labtest" checked="true">
																<label for="lab-test"> Lab Tests</label>
															</div>
															<ul class="list-inline medicineAndTest">
																<li>
																	<input id="bld1" class="checkbox-custom" type="checkbox" />
																	<label for="bld1" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray1" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray1" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld2" class="checkbox-custom" type="checkbox" />
																	<label for="bld2" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray2" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray2" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld3" class="checkbox-custom" type="checkbox" />
																	<label for="bld3" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray3" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray3" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld4" class="checkbox-custom" type="checkbox" />
																	<label for="bld4" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld5" class="checkbox-custom" type="checkbox" />
																	<label for="bld5" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray4" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray4" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld6" class="checkbox-custom" type="checkbox" />
																	<label for="bld6" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray5" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray5" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld7" class="checkbox-custom" type="checkbox" />
																	<label for="bld7" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray6" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray6" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld8" class="checkbox-custom" type="checkbox" />
																	<label for="bld8" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld9" class="checkbox-custom" type="checkbox" />
																	<label for="bld9" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray7" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray7" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld10" class="checkbox-custom" type="checkbox" />
																	<label for="bld10" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray8" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray8" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld11" class="checkbox-custom" type="checkbox" />
																	<label for="bld11" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray9" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray9" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld12" class="checkbox-custom" type="checkbox" />
																	<label for="bld12" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld13" class="checkbox-custom" type="checkbox" />
																	<label for="bld13" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray10" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray10" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld14" class="checkbox-custom" type="checkbox" />
																	<label for="bld14" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray11" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray11" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld15" class="checkbox-custom" type="checkbox" />
																	<label for="bld15" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray12" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray12" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld16" class="checkbox-custom" type="checkbox" />
																	<label for="bld16" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld17" class="checkbox-custom" type="checkbox" />
																	<label for="bld17" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray13" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray13" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld18" class="checkbox-custom" type="checkbox" />
																	<label for="bld18" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray14" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray14" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld19" class="checkbox-custom" type="checkbox" />
																	<label for="bld19" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray15" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray15" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld20" class="checkbox-custom" type="checkbox" />
																	<label for="bld20" class="checkbox-custom-label">Blood Test</label>
																</li>
															</ul>
															<div class="radio">
																<input id="other-test" type="radio" name="labtest">
																<label for="other-test"> Others</label>
															</div>
															<p class="commonColor">Medicine Details</p>
															<table class="table medicineTime table-bordered">
																<thead>
																	<tr>
																		<th>Medicine Name</th>
																		<th>Medicine Type</th>
																		<th>Morning</th>
																		<th>Afternoon</th>
																		<th>Evening</th>
																		<th>Night</th>
																		<th>Add Note</th>
																	</tr>
																</thead>
																<tr>
																	<td>Aspirine 500 mg</td>
																	<td>
																		 <select class="form-control">
																		 	<option>Tablet</option>
																		 	<option>Syrup</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td class="text-center">
																		<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
																	</td>
																</tr>
															</table>
															<p class="text-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add More</p>
															<div class="row">
																<div class="col-sm-6">
																	<img src="/ui/images/doctorCertificate.png" class="img-responsive">
																</div>
																<div class="col-sm-offset-1 col-sm-5">
																	<img src="/ui/images/signature.png">
																	<h4>Dr.Venu Kumari</h4>
																	<p class="commonColor">Specialist:&nbsp;Dental</p>
																	<p class="commonColor" style="margin-top:10px;">Doctor regjistration Number</p>
																	<p>111942A Karnataka State Dental Council</p>
																</div>
															</div>
															<div class="text-center">
																<button class="btn btn-preview">Preview</button>
															</div>
													</div>
												</div>
											</div>
											<div class="UpcomingAppDetails">
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Gopal</h4>
						                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
						                                <ul class="list-inline">
						                                  <li><a href="javascript:void(0);">Prescription</a></li>
						                                  <li><a href="javascript:void(0);">Lab Reports</a></li>
						                                </ul>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png" style="margin-top:20px"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Timing</p>
														<p>2:30 pm</p>
														<p>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p style="margin-top:30px;">Ended</p>
													</li>
													<li class="commonWidth nothingCancel">
														<!-- <p class="commonColor">Reason<span class="pull-right">Cancelled</span></p>
														<small class="text-justify">
															Lorem Ipsum is a simply dummy text of the printing and typewriting industry.
														</small> -->
														<center><i class="fa fa-check fa-3x" style="color:#8CC540;margin-top:20px;" aria-hidden="true"></i></center>
													</li>
												</ul>
												<ul class="list-inline heightWeightComn">
													<li><span>Height:</span>&nbsp;5.7</li>
													<li><span>Weight:</span>&nbsp;65Kg</li>
													<li><span>Blood Group:</span>&nbsp;'O'&nbsp;Positive</li>
													<li><a class="btn-schedule">Hide Prescription</a></li>
													<li class="pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></li>
												</ul>
												<div class="doctorPrescription" hidden="true">
													<div class="doctorDetails">
														<img src="/ui/images/logo-small.png">
														<ul class="list-inline">
															<li>
																<p class="commonColor">Doctor Name</p>
																<h4>Dr.Venu Kumari</h4>
															</li>
															<li>
																<p class="commonColor">Patient Name</p>
																<h4>Pavitra HAdimani</h4>
															</li>
															<li>
																<p class="commonColor">Doctor Speciality</p>
																<h4>Dentist</h4>
															</li>
															<li>
																<p class="commonColor">Patient ID</p>
																<h4>SHDCT3451</h4>
															</li>
														</ul>
														<p class="commonColor">Date:26/May/2016</p>
													</div>
													<div class="patientPrescriptionDetails">
															<p class="commonColor">Diagnosis Report</p>
															<div class="reportDiagnosis"></div>
															<div class="radio">
																<input id="lab-test" type="radio" name="labtest" checked="true">
																<label for="lab-test"> Lab Tests</label>
															</div>
															<ul class="list-inline medicineAndTest">
																<li>
																	<input id="bld1" class="checkbox-custom" type="checkbox" />
																	<label for="bld1" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray1" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray1" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld2" class="checkbox-custom" type="checkbox" />
																	<label for="bld2" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray2" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray2" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld3" class="checkbox-custom" type="checkbox" />
																	<label for="bld3" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray3" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray3" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld4" class="checkbox-custom" type="checkbox" />
																	<label for="bld4" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld5" class="checkbox-custom" type="checkbox" />
																	<label for="bld5" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray4" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray4" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld6" class="checkbox-custom" type="checkbox" />
																	<label for="bld6" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray5" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray5" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld7" class="checkbox-custom" type="checkbox" />
																	<label for="bld7" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray6" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray6" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld8" class="checkbox-custom" type="checkbox" />
																	<label for="bld8" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld9" class="checkbox-custom" type="checkbox" />
																	<label for="bld9" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray7" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray7" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld10" class="checkbox-custom" type="checkbox" />
																	<label for="bld10" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray8" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray8" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld11" class="checkbox-custom" type="checkbox" />
																	<label for="bld11" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray9" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray9" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld12" class="checkbox-custom" type="checkbox" />
																	<label for="bld12" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld13" class="checkbox-custom" type="checkbox" />
																	<label for="bld13" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray10" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray10" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld14" class="checkbox-custom" type="checkbox" />
																	<label for="bld14" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray11" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray11" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld15" class="checkbox-custom" type="checkbox" />
																	<label for="bld15" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray12" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray12" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld16" class="checkbox-custom" type="checkbox" />
																	<label for="bld16" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="bld17" class="checkbox-custom" type="checkbox" />
																	<label for="bld17" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray13" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray13" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld18" class="checkbox-custom" type="checkbox" />
																	<label for="bld18" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray14" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray14" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld19" class="checkbox-custom" type="checkbox" />
																	<label for="bld19" class="checkbox-custom-label">Blood Test</label>
																</li>
																<li>
																	<input id="x-ray15" class="checkbox-custom" type="checkbox" />
																	<label for="x-ray15" class="checkbox-custom-label">X-Ray</label>
																</li>
																<li>
																	<input id="bld20" class="checkbox-custom" type="checkbox" />
																	<label for="bld20" class="checkbox-custom-label">Blood Test</label>
																</li>
															</ul>
															<div class="radio">
																<input id="other-test" type="radio" name="labtest">
																<label for="other-test"> Others</label>
															</div>
															<p class="commonColor">Medicine Details</p>
															<table class="table medicineTime table-bordered">
																<thead>
																	<tr>
																		<th>Medicine Name</th>
																		<th>Medicine Type</th>
																		<th>Morning</th>
																		<th>Afternoon</th>
																		<th>Evening</th>
																		<th>Night</th>
																		<th>Add Note</th>
																	</tr>
																</thead>
																<tr>
																	<td>Aspirine 500 mg</td>
																	<td>
																		 <select class="form-control">
																		 	<option>Tablet</option>
																		 	<option>Syrup</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td>
																		<select class="form-control">
																		 	<option>After Food</option>
																		 	<option>Before Food</option>
																		 </select>
																	</td>
																	<td class="text-center">
																		<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
																	</td>
																</tr>
															</table>
															<p class="text-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add More</p>
															<div class="row">
																<div class="col-sm-6">
																	<img src="/ui/images/doctorCertificate.png" class="img-responsive">
																</div>
																<div class="col-sm-offset-1 col-sm-5">
																	<img src="/ui/images/signature.png">
																	<h4>Dr.Venu Kumari</h4>
																	<p class="commonColor">Specialist:&nbsp;Dental</p>
																	<p class="commonColor" style="margin-top:10px;">Doctor regjistration Number</p>
																	<p>111942A Karnataka State Dental Council</p>
																</div>
															</div>
															<div class="text-center">
																<button class="btn btn-preview">Preview</button>
															</div>
													</div>
												</div>
											</div>
										</div><!-- PastApp Ends -->
									</div>
								</div>
							</div><!-- Appointment Ends -->
							<div role="tabpanel" class="tab-pane" id="consultfee"><!-- Consultation Fees -->
								<div class="tabHeading">
									<h3>Consultation Fees &#38; Time
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
								<div class="white-background">
									<div class="padding5to10">
										<h5>Consultation Fees</h5>
									</div>
									<div class="detailed-fees-structure">
										<div class="row">
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-6">
														<label class="control-label commonColor">
															<img src="/ui/images/webcam.png" class="img-responsive"> Video Call
														</label>
														<div class="input-group">
												  		<span class="input-group-addon" id="basic-addon1">
												  			<i class="fa fa-inr fa-2x" aria-hidden="true"></i>
												  		</span>
												  		<input type="text" class="form-control" placeholder="Enter amount" aria-describedby="basic-addon1">
														</div>
													</div>
													<div class="col-sm-6">
													<label class="control-label commonColor">
														<img src="/ui/images/ring.png" class="img-responsive">Audio Call
													</label>
														<div class="input-group">
												  		<span class="input-group-addon" id="basic-addon1">
												  			<i class="fa fa-inr fa-2x" aria-hidden="true"></i>
												  		</span>
												  		<input type="text" class="form-control" placeholder="Enter amount" aria-describedby="basic-addon1">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<p class="commonColor">Available For</p>
												<ul class="list-inline">
													<li>
														<div>
															<input id="avail-video" class="checkbox-custom" type="checkbox">
															<label for="avail-video" class="checkbox-custom-label commonColor">
																<img src="/ui/images/webcam.png" class="img-responsive">Video Call
															</label>
														</div>	
													</li>
													<li>
														<div>
															<input id="avail-audio" class="checkbox-custom" type="checkbox">
															<label for="avail-audio" class="checkbox-custom-label commonColor">
																<img src="/ui/images/ring.png" class="img-responsive">Audio Call
															</label>
														</div>	
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="padding5to10">
										<h5>Consultation Timings</h5>
									</div>
									<div class="doctor-schedule-select">
										<div class="calander_dates_heading"><!-- Calender Head -->
											<ul class="nav nav-tabs">
												<li class="previousDate">
													<i class="fa fa-chevron-circle-left fa-2x prevapp" aria-hidden="true"></i>
												</li>
												<li class="active">
													<a data-toggle="tab" href=".firstday">
														<p class="today_day">Today</p>
														<p><span class="today_date"></span> <span class="today_month"></span></p>
													</a>
												</li>
												<li>
													<a data-toggle="tab" href=".secondday">
											    <p class="tomorrow_day"></p>
													<p><span class="tomorrow_date"></span> <span class="tomorrow_month"></span></p>
											    </a>
											  </li>
											  <li>
											  	<a data-toggle="tab" href=".thirdday">
											    <p class="thirdDay_day"></p>
													<p><span class="thirdDay_date"></span> <span class="thirdDay_month"></span></p>
											    </a>
											  </li>
											  <li>
											  	<a data-toggle="tab" href=".fourthday">
													<p class="fourthDay_day"></p>
													<p><span class="fourthDay_date"></span> <span class="fourthDay_month"></span></p></a>
											  </li>
											  <li>
											  	<a data-toggle="tab" href=".fifthday">
													<p class="fifthDay_day"></p>
													<p><span class="fifthDay_date"></span> <span class="fifthDay_month"></span></p>
											   	</a>
											  </li>
											  <li>
											  	<a data-toggle="tab" href=".sixthday">
													<p class="sixthDay_day"></p>
													<p><span class="sixthDay_date"></span> <span class="sixthDay_month"></span></p>
											   	</a>
											  </li>
											  <li>
											  	<a data-toggle="tab" href=".seventh">
													<p class="seventhDay_day"></p>
													<p><span class="seventhDay_date"></span> <span class="seventhDay_month"></span></p>
											   	</a>
											  </li>
											  <li class="nextDate">
													<i class="fa fa-chevron-circle-right fa-2x nextapp" aria-hidden="true"></i>
												</li>
											</ul>
										</div><!-- Calender Head Ends -->
										<div class="tab-content"><!-- Calendar Contents -->
										<div class="tab-pane fade in active firstday"><!-- First Day -->
											<div class="meridion_selection">
												<ul class="nav nav-tabs">
											    <li class="active"><a data-toggle="tab" href=".home">MORNING</a></li>
											    <li><a data-toggle="tab" href=".menu1">AFTERNOON</a></li>
											    <li><a data-toggle="tab" href=".menu2">EVENING</a></li>
											    <li><a data-toggle="tab" href=".menu3">NIGHT</a></li>
												</ul>
												<div class="row">
													<div class="col-sm-7 col-sm-offset-2">
														<div class="tab-content">
														    <div class="home tab-pane fade in active">
														      <ul class="list-inline morning-time text-center"></ul>
														    </div>
														    <div class="menu1 tab-pane fade">
														      <ul class="list-inline afternoon-time text-center"></ul>
														    </div>
														    <div class="menu2 tab-pane fade">
														       <ul class="list-inline evening-time text-center"></ul>
														    </div>
														    <div class="menu3 tab-pane fade">
														      <ul class="list-inline night-time text-center"></ul>
														    </div>
														</div>
													</div>
													<div class="col-sm-3">
														<ul class="list-unstyled avail-notavail">
															<li>Available</li>
															<li>Not Available</li>
														</ul>
													</div>
												</div>
											</div>
										</div><!-- First Day -->
										<div class="secondday tab-pane fade"><!-- Second Day -->
											<div class="meridion_selection">
												<ul class="nav nav-tabs">
											    <li class="active"><a data-toggle="tab" href=".menu4">MORNING</a></li>
											    <li><a data-toggle="tab" href=".menu5">AFTERNOON</a></li>
											    <li><a data-toggle="tab" href=".menu6">EVENING</a></li>
											    <li><a data-toggle="tab" href=".menu7">NIGHT</a></li>
												</ul>
												<div class="row">
													<div class="col-sm-7 col-sm-offset-2">
														<div class="tab-content">
														    <div class="home tab-pane fade in active">
														      <ul class="list-inline morning-time text-center"></ul>
														    </div>
														    <div class="menu1 tab-pane fade">
														      <ul class="list-inline afternoon-time text-center"></ul>
														    </div>
														    <div class="menu2 tab-pane fade">
														       <ul class="list-inline evening-time text-center"></ul>
														    </div>
														    <div class="menu3 tab-pane fade">
														      <ul class="list-inline night-time text-center"></ul>
														    </div>
														</div>
													</div>
													<div class="col-sm-3">
														<ul class="list-unstyled avail-notavail">
															<li>Available</li>
															<li>Not Available</li>
														</ul>
													</div>
												</div>
											</div>
										</div><!-- Second Day -->
											<div class="thirdday tab-pane fade"><!-- Third Day -->
												<div class="meridion_selection">
													<ul class="nav nav-tabs">
												    <li class="active"><a data-toggle="tab" href=".menu8">MORNING</a></li>
												    <li><a data-toggle="tab" href=".menu9">AFTERNOON</a></li>
												    <li><a data-toggle="tab" href=".menu10">EVENING</a></li>
												    <li><a data-toggle="tab" href=".menu11">NIGHT</a></li>
													</ul>
													<div class="row">
														<div class="col-sm-7 col-sm-offset-2">
															<div class="tab-content">
															    <div class="home tab-pane fade in active">
															      <ul class="list-inline morning-time text-center"></ul>
															    </div>
															    <div class="menu1 tab-pane fade">
															      <ul class="list-inline afternoon-time text-center"></ul>
															    </div>
															    <div class="menu2 tab-pane fade">
															       <ul class="list-inline evening-time text-center"></ul>
															    </div>
															    <div class="menu3 tab-pane fade">
															      <ul class="list-inline night-time text-center"></ul>
															    </div>
															</div>
														</div>
														<div class="col-sm-3">
															<ul class="list-unstyled avail-notavail">
																<li>Available</li>
																<li>Not Available</li>
															</ul>
														</div>
													</div>
												</div>
											</div><!-- Third Day -->
											<div class="fourthday tab-pane fade"><!-- Fourth Day -->
												<div class="meridion_selection">
													<ul class="nav nav-tabs">
												    <li class="active"><a data-toggle="tab" href=".menu12">MORNING</a></li>
												    <li><a data-toggle="tab" href=".menu13">AFTERNOON</a></li>
												    <li><a data-toggle="tab" href=".menu14">EVENING</a></li>
												    <li><a data-toggle="tab" href=".menu15">NIGHT</a></li>
													</ul>
													<div class="row">
															<div class="col-sm-7 col-sm-offset-2">
																<div class="tab-content">
																    <div class="home tab-pane fade in active">
																      <ul class="list-inline morning-time text-center"></ul>
																    </div>
																    <div class="menu1 tab-pane fade">
																      <ul class="list-inline afternoon-time text-center"></ul>
																    </div>
																    <div class="menu2 tab-pane fade">
																       <ul class="list-inline evening-time text-center"></ul>
																    </div>
																    <div class="menu3 tab-pane fade">
																      <ul class="list-inline night-time text-center"></ul>
																    </div>
																</div>
															</div>
															<div class="col-sm-3">
																<ul class="list-unstyled avail-notavail">
																	<li>Available</li>
																	<li>Not Available</li>
																</ul>
															</div>
														</div>
												</div>
											</div><!-- Fourth Day -->
											<div class="fifthday tab-pane fade"><!-- Fifth Day -->
												<div class="meridion_selection">
													<ul class="nav nav-tabs">
												    <li class="active"><a data-toggle="tab" href=".menu16">MORNING</a></li>
												    <li><a data-toggle="tab" href=".menu17">AFTERNOON</a></li>
												    <li><a data-toggle="tab" href=".menu18">EVENING</a></li>
												    <li><a data-toggle="tab" href=".menu19">NIGHT</a></li>
													</ul>
													<div class="row">
															<div class="col-sm-7 col-sm-offset-2">
																<div class="tab-content">
																    <div class="home tab-pane fade in active">
																      <ul class="list-inline morning-time text-center"></ul>
																    </div>
																    <div class="menu1 tab-pane fade">
																      <ul class="list-inline afternoon-time text-center"></ul>
																    </div>
																    <div class="menu2 tab-pane fade">
																       <ul class="list-inline evening-time text-center"></ul>
																    </div>
																    <div class="menu3 tab-pane fade">
																      <ul class="list-inline night-time text-center"></ul>
																    </div>
																</div>
															</div>
															<div class="col-sm-3">
																<ul class="list-unstyled avail-notavail">
																	<li>Available</li>
																	<li>Not Available</li>
																</ul>
															</div>
														</div>
												</div>
											</div><!-- Fifth Day -->
											<div class="sixthday tab-pane fade"><!-- Sixth Day -->
												<div class="meridion_selection">
													<ul class="nav nav-tabs">
												    <li class="active"><a data-toggle="tab" href=".menu20">MORNING</a></li>
												    <li><a data-toggle="tab" href=".menu21">AFTERNOON</a></li>
												    <li><a data-toggle="tab" href=".menu22">EVENING</a></li>
												    <li><a data-toggle="tab" href=".menu23">NIGHT</a></li>
													</ul>
													<div class="row">
															<div class="col-sm-7 col-sm-offset-2">
																<div class="tab-content">
																    <div class="home tab-pane fade in active">
																      <ul class="list-inline morning-time text-center"></ul>
																    </div>
																    <div class="menu1 tab-pane fade">
																      <ul class="list-inline afternoon-time text-center"></ul>
																    </div>
																    <div class="menu2 tab-pane fade">
																       <ul class="list-inline evening-time text-center"></ul>
																    </div>
																    <div class="menu3 tab-pane fade">
																      <ul class="list-inline night-time text-center"></ul>
																    </div>
																</div>
															</div>
															<div class="col-sm-3">
																<ul class="list-unstyled avail-notavail">
																	<li>Available</li>
																	<li>Not Available</li>
																</ul>
															</div>
														</div>
												</div>
											</div><!-- Sixth Day -->
											<div class="seventh tab-pane fade"><!-- Seventh Day -->
												<div class="meridion_selection">
													<ul class="nav nav-tabs">
												    <li class="active"><a data-toggle="tab" href=".menu24">MORNING</a></li>
												    <li><a data-toggle="tab" href=".menu25">AFTERNOON</a></li>
												    <li><a data-toggle="tab" href=".menu26">EVENING</a></li>
												    <li><a data-toggle="tab" href=".menu27">NIGHT</a></li>
													</ul>
													<div class="row">
															<div class="col-sm-7 col-sm-offset-2">
																<div class="tab-content">
																    <div class="home tab-pane fade in active">
																      <ul class="list-inline morning-time text-center"></ul>
																    </div>
																    <div class="menu1 tab-pane fade">
																      <ul class="list-inline afternoon-time text-center"></ul>
																    </div>
																    <div class="menu2 tab-pane fade">
																       <ul class="list-inline evening-time text-center"></ul>
																    </div>
																    <div class="menu3 tab-pane fade">
																      <ul class="list-inline night-time text-center"></ul>
																    </div>
																</div>
															</div>
															<div class="col-sm-3">
																<ul class="list-unstyled avail-notavail">
																	<li>Available</li>
																	<li>Not Available</li>
																</ul>
															</div>
														</div>
												</div>
											</div><!-- Seventh Day -->
											<div class="commonScheduleButton">
												<ul class="list-inline">
													<li>
														<input id="select-all" class="checkbox-custom" type="checkbox">
														<label for="select-all" class="checkbox-custom-label">
															Select All
														</label>
													</li>
													<li>
														<input id="repeat-all" class="checkbox-custom" type="checkbox">
														<label for="repeat-all" class="checkbox-custom-label">
															Repeat For all days
														</label>
													</li>
												</ul>
						  				</div>
										</div><!-- Calendar Contents Ends -->	
									</div>
									<div class="padding5to10 margin-doctor">
										<ul class="list-inline">
											<li>
												<button class="btn btn-schedule btn-schedule-no-radius">Update</button>
											</li>
											<li>
												<button class="btn btn-preview btn-schedule-no-radius">Cancel</button>
											</li>
										</ul>
									</div>
								</div>
							</div><!-- Consultation Fees Ends -->
							<div role="tabpanel" class="tab-pane" id="healthTips"><!-- Health Tips -->
								<div class="tabHeading">
									<h3>Health Tips
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
								<div class="health-tips-content">
									<div class="text-right navy-green">
										<button class="btn btn-schedule" id="write-health-tip">Write New Tip</button>
									</div>
									<div class="dispaly-health-tips">
										<div class="row">
											<div class="col-sm-10">
												<h4>4 Home remedies to keep your theeth stronger and sparkling</h4>
												<p>Posted On Mar  12, 2016</p>
											</div>
											<div class="col-sm-2 text-right">
												<ul class="list-inline">
													<li><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></li>
													<li><i class="fa fa-trash fa-2x" aria-hidden="true"></i></li>
												</ul>
											</div>
										</div>
										<img src="/ui/images/health-tips.png" class="img-responsive img-rounded">
										<p>
											As Singen starts his ophthalmology rotation, he is learning what it takes to start thinking and information like a real doctor. His first assignment during this new rotation is dealing with a frequent patient who is battling to save her eyesight. Rosie, a 6-year old Westie, suffers from dry eyes and she is not able to produce any tears. Chronically dry eyes can cause other severe diseases, such as ulcers, which can be extremely painful. Rosie is not responding to basic treatment for dry eyes, so Singen and the other clinicians must turn to surgery or Rosie will go blind.
										</p>
										<p>
											As Singen starts his ophthalmology rotation, he is learning what it takes to start thinking and information like a real doctor. His first assignment during this new rotation is dealing with a frequent patient who is battling to save her eyesight. Rosie, a 6-year old Westie, suffers from dry eyes and she is not able to produce any tears. Chronically dry eyes can cause other severe diseases, such as ulcers, which can be extremely painful. Rosie is not responding to basic treatment for dry eyes, so Singen and the other clinicians must turn to surgery or Rosie will go blind.
										</p>
									</div>
									<div class="dispaly-health-tips">
										<div class="row">
											<div class="col-sm-10">
												<h4>4 Home remedies to keep your theeth stronger and sparkling</h4>
												<p>Posted On Mar  12, 2016</p>
											</div>
											<div class="col-sm-2 text-right">
												<ul class="list-inline">
													<li><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></li>
													<li><i class="fa fa-trash fa-2x" aria-hidden="true"></i></li>
												</ul>
											</div>
										</div>
										<img src="/ui/images/health-tips.png" class="img-responsive img-rounded">
										<p>
											As Singen starts his ophthalmology rotation, he is learning what it takes to start thinking and information like a real doctor. His first assignment during this new rotation is dealing with a frequent patient who is battling to save her eyesight. Rosie, a 6-year old Westie, suffers from dry eyes and she is not able to produce any tears. Chronically dry eyes can cause other severe diseases, such as ulcers, which can be extremely painful. Rosie is not responding to basic treatment for dry eyes, so Singen and the other clinicians must turn to surgery or Rosie will go blind.
										</p>
										<p>
											As Singen starts his ophthalmology rotation, he is learning what it takes to start thinking and information like a real doctor. His first assignment during this new rotation is dealing with a frequent patient who is battling to save her eyesight. Rosie, a 6-year old Westie, suffers from dry eyes and she is not able to produce any tears. Chronically dry eyes can cause other severe diseases, such as ulcers, which can be extremely painful. Rosie is not responding to basic treatment for dry eyes, so Singen and the other clinicians must turn to surgery or Rosie will go blind.
										</p>
									</div>
								</div>
								<div class="write-health-tip-content" hidden="true">
									<div class="text-right navy-green">
										<button class="btn btn-schedule" id="show-health-tip">Go To Health Tips</button>
									</div>
									<div class="write-health-tips">
										<p>Health Tip Title</p>
										<div class="form-group">
											<input type="text" class="form-control" placeholder="for ex. 4 Home remedies to keep your teeth stronger and sparkling">
										</div>
										<div class="upload-signature-area margin-top-20 text-center">
											<img id="health-tip_upload_preview" src="" />
											<input type="file" id="health-tip-upload">
											<label for="health-tip-upload" class="custom-file-upload">
												<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Upload Image
											</label>
										</div>
										<div class="form-group margin-top-20">
											<textarea class="form-control" rows="10" placeholder="Write Your Health Tip Here"></textarea>
										</div>
										<div class="form-group">
											<ul class="list-inline">
												<li><button class="btn btn-schedule btn-schedule-no-radius">Publish</button></li>
												<li><button class="btn btn-preview btn-schedule-no-radius">Cancel</button></li>
											</ul>
										</div>
									</div>
								</div>
							</div><!-- Health Tips Ends -->
							<div role="tabpanel" class="tab-pane" id="doctor-profile"><!-- Doctor Profile -->
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
													<div class="col-sm-2">
														<div class="form-group">
															<label class="control-label">Prefix</label>
															<div class="select">
																<select class="form-control">
																	<option>Mr.</option>
																	<option>Ms.</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-sm-10">
														<div class="form-group on-focus clearfix" style="position: relative;">
															<label for="" class="control-label">Name</label>
															<input type="text" class="form-control myDesign" placeholder="Sanjivini Ro">
															<div class="tool-tip bottom  slideIn ">Name</div>
														</div>
													</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group on-focus clearfix" style="position: relative;">
														<label for="" class="control-label">Email-ID</label>
														<input type="email" class="form-control myDesign" placeholder="sanjivinirao@gmail.com">
														<div class="tool-tip bottom  slideIn ">Email-ID</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group on-focus clearfix" style="position: relative;">
														<label for="" class="control-label">Mobile Number</label>
														<input type="email" class="form-control myDesign" placeholder="+91 9754333777">
														<div class="tool-tip bottom  slideIn ">Mobile Number</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label">Gender</label>
														<div class="select">
															<select class="form-control">
																<option>Male</option>
																<option>Female</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label">Speciality</label>
															<div class="select">
															<select class="form-control">
																<option>Dentist</option>
																<option>Physiotheraphy</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group on-focus clearfix" style="position: relative;">
														<label for="" class="control-label">Doctor Registration Number</label>
														<input type="email" class="form-control myDesign" placeholder="RGCH1235454">
														<div class="tool-tip bottom  slideIn ">Doctor Registration Number</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label">Experience</label>
														<div class="select">
															<select class="form-control">
																<option>1 Year</option>
																<option>2 Year</option>
																<option>3 Year</option>
																<option>4 Year</option>
																<option>5 Year</option>
																<option>6 Year</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="languageKnown">
												<p class="commonColor">Languges You Know</p>
												<ul class="list-inline">
													<li>
														<input id="kannada" class="checkbox-custom" type="checkbox" />
														<label for="kannada" class="checkbox-custom-label">Kannada</label>
													</li>
													<li>
														<input id="hindi" class="checkbox-custom" type="checkbox" />
														<label for="hindi" class="checkbox-custom-label">Hindi</label>
													</li>
													<li>
														<input id="english" class="checkbox-custom" type="checkbox" />
														<label for="english" class="checkbox-custom-label">English</label>
													</li>
													<li>
														<input id="tamil" class="checkbox-custom" type="checkbox" />
														<label for="tamil" class="checkbox-custom-label">Tamil</label>
													</li>
													<li>
														<input id="telugu" class="checkbox-custom" type="checkbox" />
														<label for="telugu" class="checkbox-custom-label">Telugu</label>
													</li>
													<li>
														<input id="malayalam" class="checkbox-custom" type="checkbox" />
														<label for="malayalam" class="checkbox-custom-label">Malayalam</label>
													</li>
												</ul>
											</div>
											<div class="motherTongue">
												<p class="commonColor">Mother Tongue Languges</p>
												<ul class="list-inline">
													<li>
														<div class="radio">
															<input id="kannada1" type="radio" name="mother-tongue">
															<label for="kannada1">Kannada</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="hindi1" type="radio" name="mother-tongue">
															<label for="hindi1">Hindi</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="english1" type="radio" name="mother-tongue">
															<label for="english1">English</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="tamil1" type="radio" name="mother-tongue">
															<label for="tamil1">Tamil</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="telugu1" type="radio" name="mother-tongue">
															<label for="telugu1">Telugu</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="malayalam1" type="radio" name="mother-tongue">
															<label for="malayalam1">Malayalam</label>
														</div>
													</li>
												</ul>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label">Select Your State</label>
															<div class="select">
																<select class="form-control" id="listBox" onchange='selct_district(this.value)'>
																</select>
															</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label class="control-label">Select Your City</label>
																<div class="select">	
																	<select class="form-control" id='secondlist'>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label class="control-label">Pincode</label>
																<div class="select">
																	<select class="form-control">
																		<option>573113</option>
																		<option>560056</option>
																		<option>560001</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-5">
													<div class="form-group">
														<label class="control-label">Select Your Medicine Type</label>
														<div class="select">
															<select class="form-control">
																<option>Allopathy</option>
																<option>Ayurveda</option>
																<option>Chinese Medicine</option>
																<option>Homeopathy</option>
																<option>Naturopathy</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="common-content-doctor-details">
										<div class="basic-info-head">
											<h4>Write About Yourself</h4>
										</div>
										<div class="doctor-info-detail">
											<div class="form-group">
												<textarea class="form-control" placeholder="Write  About You" rows="5"></textarea>
												<p class="text-right">250 Characters</p>
											</div>
										</div>
									</div>
									<div class="common-content-doctor-details">
										<div class="basic-info-head">
											<h4>Education <span class="pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add More</span></h4>
										</div>
										<div class="common-padding-doctor">
											<div class="row">
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-9">
															<div class="form-group on-focus clearfix" style="position: relative;">
																<label class="control-label">Degree</label>
																<input type="text" class="form-control myDesign" placeholder="Degree">
																<div class="tool-tip bottom  slideIn ">Degree</div>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label class="control-label">Year</label>
																	<div class="select">
																		<select class="form-control">
																			<option>2000</option>
																			<option>2001</option>
																			<option>2002</option>
																			<option>2003</option>
																			<option>2004</option>
																			<option>2005</option>
																			<option>2006</option>
																			<option>2007</option>
																			<option>2008</option>
																			<option>2009</option>
																		</select>
																	</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-8">
													<div class="form-group on-focus clearfix" style="position: relative;">
														<label class="control-label">College Name</label>
														<input type="text" class="form-control myDesign" placeholder="College Name">
														<div class="tool-tip bottom  slideIn ">College Name</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="common-content-doctor-details">
										<div class="basic-info-head">
											<h4>Specialization <span class="pull-right" id="add-specialization"><i class="fa fa-plus" aria-hidden="true"></i> Add More</span></h4>
										</div>
										<div class="common-padding-doctor">
											<ul class="list-inline common-style-list doctor-specialization">
												<li>Prostodontist&nbsp;<i class="fa fa-times remove-specialization" aria-hidden="true"></i></li>
												<li>Dentist&nbsp;<i class="fa fa-times remove-specialization" aria-hidden="true"></i></li>
												<li>Dental Surgeon&nbsp;<i class="fa fa-times remove-specialization" aria-hidden="true"></i></li>
											</ul>
										</div>
									</div>
									<div class="common-content-doctor-details">
										<div class="basic-info-head">
											<h4>Services <span class="pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add More</span></h4>
										</div>
										<div class="common-padding-doctor">
											<ul class="list-inline common-style-list">
												<li>Acrylic Partial Denture &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Bleaching &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Ceramic Crowns &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Fillings &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Braces &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Endosurgery &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Gum Surgery &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Acrylic Partial Denture &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
												<li>Cleaning &nbsp;<i class="fa fa-times" aria-hidden="true"></i></li>
											</ul>
										</div>
									</div>
									<div class="common-content-doctor-details">
										<div class="basic-info-head">
											<h4>Awards &#38; Certification<span class="pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add More</span></h4>
										</div>
										<div class="common-padding-doctor">
											<div class="row">
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-9">
															<div class="form-group on-focus clearfix" style="position: relative;">
																<label class="control-label">Award Name</label>
																<input type="text" class="form-control myDesign" placeholder="Award Name">
																<div class="tool-tip bottom  slideIn ">Award Name</div>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label class="control-label">Year</label>
																<div class="select">
																	<select class="form-control">
																		<option>2000</option>
																		<option>2001</option>
																		<option>2002</option>
																		<option>2003</option>
																		<option>2004</option>
																		<option>2005</option>
																		<option>2006</option>
																		<option>2007</option>
																		<option>2008</option>
																		<option>2009</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-8">
													<div class="form-group on-focus clearfix" style="position: relative;">
														<label class="control-label">Award Details</label>
														<input type="text" class="form-control myDesign" placeholder="Award Details">
														<div class="tool-tip bottom  slideIn ">Award Details</div>
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
							</div><!-- Doctor Profile Ends -->
							<div role="tabpanel" class="tab-pane" id="ledger"><!-- Ledger -->
								<div class="tabHeading">
									<h3>Ledger
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
								<div class="ledger-details">
									<div class="row">
										<div class="col-sm-8">
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Select</label>
														<div class="select">
															<select class="form-control">
																<option>All</option>
																<option>None</option>
																<option>Last</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group posRel">
														<label class="control-label">From</label>
														<input type="text"  class="form-control ledger-from">
														<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group posRel">
														<label class="control-label">To</label>
														<input type="text" class="form-control ledger-from">
														<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered ledger-table">
											<thead>
												<tr>
													<th>Date</th>
													<th>Call Type</th>
													<th>Patient <br/>ID</th>
													<th>Transaction<br/> ID</th>
													<th>Amount<br/>(Rupee)</th>
													<th>SheDoctr<br/>(Rupee)</th>
													<th>Patient<br/>(Rupee)</th>
													<th>Other Details</th>
												</tr>
											</thead>
											<tr>
												<td>Mar 13,2016</td>
												<td><center><img src="/ui/images/webcam.png"></center></td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;150</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;200</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;350</td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
											<tr>
												<td>Mar 15,2016</td>
												<td><center><img src="/ui/images/ring.png"></center></td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;150</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;200</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;350</td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
											<tr>
												<td>Mar 18,2016</td>
												<td><center><img src="/ui/images/ring.png"></center></td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;150</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;200</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;350</td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div><!-- Ledger Ends -->
							<div role="tabpanel" class="tab-pane" id="payments"><!-- Payments -->
								<div class="tabHeading">
									<h3>Payments
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
								<div class="ledger-details">
									<div class="row">
										<div class="col-sm-8">
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Select</label>
														<div class="select">
															<select class="form-control">
																<option>All</option>
																<option>None</option>
																<option>Last</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group posRel">
														<label class="control-label">From</label>
														<input type="text"  class="form-control ledger-from">
														<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group posRel">
														<label class="control-label">To</label>
														<input type="text"  class="form-control ledger-from">
														<i class="fa fa-calendar posAbs" aria-hidden="true"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered ledger-table">
											<thead>
												<tr>
													<th>Payment Date</th>
													<th>Amount(Rupee)</th>
													<th>Patient ID</th>
													<th>Transaction ID</th>
													<th>Status</th>
													<th>Remarks</th>
												</tr>
											</thead>
											<tr>
												<td>Mar 13 2016</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;2000</td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td class="pending-status">Pending &nbsp;&nbsp;<i class="fa fa-hourglass-half" aria-hidden="true"></i></td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
											<tr>
												<td>Mar 15 2016</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;2000</td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td class="pending-status">Done &nbsp;&nbsp;<i class="fa fa-check fa-2x" aria-hidden="true"></i></td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
											<tr>
												<td>Mar 17 2016</td>
												<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;2000</td>
												<td>SBDF436EFR</td>
												<td>SBDF436EFR</td>
												<td class="pending-status">Done &nbsp;&nbsp;<i class="fa fa-check fa-2x" aria-hidden="true"></i></td>
												<td>
													<small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</small>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div><!-- Payments Ends -->
							<div role="tabpanel" class="tab-pane" id="bankDetails"><!-- Bank Deatils -->
								<div class="tabHeading">
									<h3>Bank Deatils
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
								<div class="ledger-details">
									<div class="add-account-details">
										<div class="row">
											<div class="col-sm-6">
												<label class="control-labrl">Select Bank Name</label>
												<div class="select">
													<select class="form-control">
														<option>Vijaya Bank</option>
														<option>State Bank Of India</option>
														<option>Corporation Bank</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-labrl">IFSC CODE</label>
													<input type="text" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group">
											<p class="commonColor">Account Type</p>
											<ul class="list-inline account-type">
												<li>
													<div class="radio">
														<input type="radio" id="saving-acc" name="account-type" checked="true">
														<label for="saving-acc" >Savings</label>
													</div>
												</li>
												<li>
													<div class="radio">
														<input type="radio" id="current-acc" name="account-type">
														<label for="current-acc">Current</label>
													</div>
												</li>
											</ul>
										</div>
										<div class="form-group">
											<label class="control-lable">Account Number</label>
											<ul class="list-inline account-number-form">
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
											</ul>
										</div>
										<div class="form-group">
											<label class="control-lable">Confirm Account Number</label>
											<ul class="list-inline account-number-form">
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
												<li><input type="text" maxlength="1" onkeypress="return isNumber(event,$(this))"></li>
											</ul>
										</div>
										<div class="form-group add-acc-btn">
											<ul class="list-inline" style="margin-top:10%;">
												<li>
													<button class="btn btn-schedule" id='add_now'>Add Now</button>
												</li>
												<li>
													<button class="btn btn-preview">Cancel</button>
												</li>
											</ul>
										</div>
									</div>
									<div class="added-account-details" hidden> 
										<table class="table account-summary">
											<tr>
												<td><p class="commonColor">Bank Name</p></td>
												<td>Vijaya Bank</td>
											</tr>
											<tr>
												<td><p class="commonColor">IFSC CODE</p></td>
												<td>VIJB10222</td>
											</tr>
											<tr>
												<td><p class="commonColor">Account Type</p></td>
												<td>Savings</td>
											</tr>
											<tr>
												<td><p class="commonColor">Account Number</p></td>
												<td>102201011001585</td>
											</tr>
											<tr>
												<td><p class="commonColor">Account Status</p></td>
												<td>Active</td>
											</tr>
										</table>
										<button class="btn btn-schedule deactivate">Deactivate</button>
									</div>
								</div>
							</div><!-- Bank Deatils Ends -->
							<div role="tabpanel" class="tab-pane" id="doctorSign"><!--Doctor Signature -->
								<div class="tabHeading">
									<h3>Doctor Signatue
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
								<div class="ledger-details upload-signature">
									<div class="upload-signature-area text-center">
										<center>
											<div>
												<img id="image_upload_preview" src="" />
												<input type="file" id="signature-upload">
												<label for="signature-upload" class="custom-file-upload">
													<ul class="list-inline">
														<li><i class="fa fa-arrow-circle-o-up fa-2x" aria-hidden="true"></i></li>
														<li>Upload Your<br/> Signature</li>
													</ul>
												</label>
											</div>
										</center>
										<p class="commonColor">Jpeg or PNG Format</p>
									</div>
									<p class="text-center commonColor danger">Image Size maximum 70kb in size</p>
									<ul class="text-center list-inline margin-top-20">
										<li>
											<button class="btn btn-schedule btn-schedule-no-radius">Update Signature</button>
										</li>
										<li>
											<button class="btn btn-preview cancel-sign btn-schedule-no-radius">Cancel</button>
										</li>
									</ul>
								</div>
							</div><!--Doctor Signature Ends -->
							<div role="tabpanel" class="tab-pane" id="add-reception"><!--Add Receptionist -->
								<div class="tabHeading">
									<h3>Receptionist
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
								<div class="ledger-details">
									<div class="reception-first text-center">
										<center><img src="/ui/images/reception-img.png" class="img-responsive"></center>
										<h2>No Receptionist Added</h2>
									</div>
									<div class="reception-second">
										<center><img src="/ui/images/small-reception.png" class="img-responsive"></center>
										<form action="javascript:void(0);" class="receptionist-form">
											<div class="form-group">
												<label class="control-label">Receptionsist Name</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Mobile Number</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Password</label>
												<input type="password" placeholder="**********" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Confirm Password</label>
												<input type="password" placeholder="**********" class="form-control">
											</div>
										</form>
									</div>
									<div class="btn-add-disable">
										<div class="margin-top-20 text-center">
											<button class="btn btn-schedule btn-schedule-no-radius add-receptionist">Add Receptionist</button>
										</div>
										<p class="commonColor text-center">Note&#58;Receptionist can manage Doctor Appointment. They can enable&#47;disable appointment list</p>
									</div>
									<div class="reception-third">
										<div class="row">
											<div class="col-md-6">
												<div class="media">
													<a class="media-left" href="#">
														<img class="media-object" src="/ui/images/reception-profile.png">
													</a>
													<div class="media-body">
														<h4 class="media-heading">Uma Trivedi</h4>
														<p class="commonColor">Receptionist</p>
													</div>
												</div>
											</div>
											<div class="col-md-6 text-right">
												<ul class="list-unstyled">
													<li><a href="javascript:void(0);" id="edit-reception-details">Edit</a></li>
													<li><a href="javascript:void(0);">Remove</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="edit-receptionist">
										<div class="row">
											<div class="col-sm-2">
												<img src="/ui/images/edit-reception.png">
											</div>
											<div class="col-sm-6">
												<h4>Edit Info</h4>
												<div class="form-group">
													<label class="control-label">Receptionist Name</label>
													<input type="text" class="form-control" value="Uma Trivedi">
												</div>
												<div class="form-group">
													<label class="control-label">Mobile Number</label>
													<input type="text" class="form-control" value="+91 9880288888">
												</div>
												<div class="form-group">
													<label class="control-label">Change Password</label>
													<input type="password" class="form-control" placeholder="**********">
												</div>
												<div class="form-group">
													<label class="control-label">Re-Enter Password</label>
													<input type="password" class="form-control" placeholder="**********">
												</div>
												<div class="form-group margin4top">
													<ul class="list-inline">
														<li><button class="btn btn-schedule btn-schedule-no-radius">Save Changes</button></li>
														<li><button class="btn btn-preview btn-schedule-no-radius cancel-edit-reception">Cancel</button></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!--Add Receptionist Ends -->
							<div role="tabpanel" class="tab-pane" id="feedback"><!-- Write Feedback -->
								<div class="tabHeading">
									<h3>Doctor Feedback Form
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
								<div class="white-doctor-feedback">
									<div class="row">
										<div class="col-sm-6 common-padding-doctor">
											<div class="form-group">
												<label class="control-label">Select Topic</label>
												<div class="select">
													<select class="form-control">
														<option>Reason1</option>
														<option>Reason2</option>
														<option>Reason3</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="rating-buttons form-group">
										<p class="commonColor">Your Rating</p>
										<label for="poor">
											<input type="radio" name="ratings" id="poor" class="poor">
											<img src="images/poor.png" alt="">
											<p class="commonColor">Poor</p>
										</label>
										<label for="liked">
											<input type="radio" name="ratings" id="liked" class="poor">
											<img src="images/poor.png" alt="">
											<p class="commonColor">Liked</p>
										</label>
										<label for="average">
											<input type="radio" name="ratings" id="average" class="poor">
											<img src="images/poor.png" alt="">
											<p class="commonColor">Average</p>
										</label>
										<label for="good">
											<input type="radio" name="ratings" id="good" class="good">
											<img src="images/good.png" alt="">
											<p class="commonColor">Good</p>
										</label>
										<label for="excellent">
											<input type="radio" name="ratings" id="excellent" class="good">
											<img src="images/good.png" alt="">
											<p class="commonColor">Excellent</p>
										</label>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group one">
												<label class="control-label commonColor">Your Feedback</label>
												<textarea class="form-control" placeholder="Write Description" rows="6"></textarea>
											</div>
										</div>
									</div>
									<div class="form-group margin10top">
										<button class="btn btn-schedule btn-schedule-no-radius">Submit</button>
									</div>
								</div>
							</div><!-- Write Feedback Ends -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- #Doctor Details Ends Here -->
	<!-- Thank You Model -->
		<div class="modal fade" id="thankyoumodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body text-center thankyoumodal-body">
						<h4>Thank You&#33;</h4>
						<ul class="list-inline">
							<li>
								<div class="radio">
									<input id="success" class="reasonAs" checked="true" type="radio" name="afterCall">
									<label for="success">Successful</label>
								</div>
							</li>
							<li>
								<div class="radio">
									<input id="disconnect" class="reasonAs" type="radio" name="afterCall">
									<label for="disconnect">Disconnected</label>
								</div>
							</li>
						</ul>
						<div id="successful">
							<p>Your video call had successfully completed</p>
							<p class="completed-call"><i class="fa fa-check" aria-hidden="true"></i></p>
							<button class="btn btn-schedule" data-toggle="modal" data-dismiss="modal" data-target="#writedescription">Write Description</button>
						</div>
						<div id="disconnect-reason">
							<p>Select Reason for your unsuccesssull call,will help us to improve our service</p>
							<div class="form-group">
								<select class="form-control">
									<option value="" disabled selected>Select Reason</option>
									<option>Network Issue</option>
									<<option>Internet Slow</option>
								</select>
							</div>
							<div class="form-group">
								<textarea class="form-control" rows="4" placeholder="Write Exact Reason"></textarea>
							</div>
							<button class="btn btn-schedule" data-toggle="modal" data-dismiss="modal" data-target="#writedescription">Submit Issue</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- Thank You Model Ends -->
	<!-- Write Description Model Starts -->
	<div class="modal fade" id="writedescription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header desc-header">
						<h3>
							<span class="go-back"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Go Back</span><span class="text-center">Write Description</span>
						</h3>
					</div>
					<div class="modal-body writedescription-body">
						<div class="doctorPrescription">
							<img src="/ui/images/logo-small.png">
							<ul class="list-inline">
								<li>
									<p class="commonColor">Doctor Name</p>
									<h4>Dr.Venu Kumari</h4>
								</li>
								<li>
									<p class="commonColor">Patient Name</p>
									<h4>Pavitra HAdimani</h4>
								</li>
								<li>
									<p class="commonColor">Doctor Speciality</p>
									<h4>Dentist</h4>
								</li>
								<li>
									<p class="commonColor">Patient ID</p>
									<h4>SHDCT3451</h4>
								</li>
							</ul>
							<p class="commonColor">Date&#58;21/Mar/2016</p>
						</div>
						<div class="write-report">
							<div class="patientPrescriptionDetails">
								<p class="commonColor">Diagnosis Report</p>
								<div class="reportDiagnosis"></div>
								<div class="radio">
									<input type="radio" checked="true" name="labtest1" id="lab-test1">
									<label for="lab-test1">Lab Tests</label>
								</div>
								<ul class="list-inline medicineAndTest">
									<li>
										<input id="b1" class="checkbox-custom" type="checkbox">
										<label for="b1" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b2" class="checkbox-custom" type="checkbox">
										<label for="b2" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b3" class="checkbox-custom" type="checkbox">
										<label for="b3" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="4" class="checkbox-custom" type="checkbox">
										<label for="4" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="5" class="checkbox-custom" type="checkbox">
										<label for="5" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="6" class="checkbox-custom" type="checkbox">
										<label for="6" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="7" class="checkbox-custom" type="checkbox">
										<label for="7" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="8" class="checkbox-custom" type="checkbox">
										<label for="8" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="9" class="checkbox-custom" type="checkbox">
										<label for="9" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="10" class="checkbox-custom" type="checkbox">
										<label for="10" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="11" class="checkbox-custom" type="checkbox">
										<label for="11" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="12" class="checkbox-custom" type="checkbox">
										<label for="12" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="13" class="checkbox-custom" type="checkbox">
										<label for="13" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="14" class="checkbox-custom" type="checkbox">
										<label for="14" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="15" class="checkbox-custom" type="checkbox">
										<label for="15" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="16" class="checkbox-custom" type="checkbox">
										<label for="16" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="17" class="checkbox-custom" type="checkbox">
										<label for="17" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="18" class="checkbox-custom" type="checkbox">
										<label for="18" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="19" class="checkbox-custom" type="checkbox">
										<label for="19" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b20" class="checkbox-custom" type="checkbox">
										<label for="b20" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b21" class="checkbox-custom" type="checkbox">
										<label for="b21" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b22" class="checkbox-custom" type="checkbox">
										<label for="b22" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b23" class="checkbox-custom" type="checkbox">
										<label for="b23" class="checkbox-custom-label">Blood Test</label>
									</li>
									<li>
										<input id="b24" class="checkbox-custom" type="checkbox">
										<label for="b24" class="checkbox-custom-label">Blood Test</label>
									</li>
								</ul>
								<div class="radio">
									<input type="radio" name="labtest1" id="lab-test12">
									<label for="lab-test12">Other</label>
								</div>
								<p class="commonColor">Medicine Details</p>
								<table class="table table-bordered medicineTime">
									<thead>
										<tr>
											<th>Medicine Name</th>
											<th>Medicine Type</th>
											<th>Morning</th>
											<th>Afternoon</th>
											<th>Evening</th>
											<th>Night</th>
											<th>Add Note</th>
										</tr>
									</thead>
									<tr>
										<td>Aspirine 500 mg</td>
										<td>
											 <select class="form-control">
											 	<option value="Tablet">Tablet</option>
											 	<option value="Tanique">Tanique</option>
											 </select>
										</td>
										<td>
											<select class="form-control">
											 	<option value="After Food">After Food</option>
											 	<option value="Before Food">Before Food</option>
											 </select>
										</td>
										<td>
											<select class="form-control">
											 	<option value="After Food">After Food</option>
											 	<option value="Before Food">Before Food</option>
											 </select>
										</td>
										<td>
											<select class="form-control">
											 	<option value="After Food">After Food</option>
											 	<option value="Before Food">Before Food</option>
											 </select>
										</td>
										<td>
											<select class="form-control">
											 	<option value="After Food">After Food</option>
											 	<option value="Before Food">Before Food</option>
											 </select>
										</td>
										<td class="text-center">
											<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
										</td>
									</tr>
								</table>
								<p class="text-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add More</p>
								<div class="row makeAlignProper">
									<div class="col-sm-6">
										<img src="/ui/images/doctorCertificate.png" class="img-responsive">
									</div>
									<div class="col-sm-offset-1 col-sm-5">
										<img src="/ui/images/signature.png">
										<h4>Dr.Venu Kumari</h4>
										<p class="commonColor">Specialist:&nbsp;Dental</p>
										<p class="commonColor" style="margin-top:10px;">Doctor regjistration Number</p>
										<p>111942A Karnataka State Dental Council</p>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	<!-- Write Description Model Ends -->
<?php include('common/footer.php') ?>