<?php include('common/inner-header.php') ?>
<!-- #Doctor Details Starts -->
<div class="container-fluid doctor-list-bg">
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li><a href="javascript:void(0);">Consult Privately</a></li>
			<li><a href="javascript:void(0);">Dermatologist</a></li>
			<li class="active">Dr. Venu Kumari</li>
		</ol>
		<!--Actual Doctor Details Starts-->
		<div class="ind-she-doctor-details">
			<div class="row">

				<div class="col-md-9 col-lg-9 col-sm-9"><!-- #Right Section -->
					<div class="doctor-details"><!-- #Doctor Info -->

						<div class="row doctor-profession-detail"><!-- Always Show -->
							<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="row">
									<div class="col-md-4 col-sm-4">
										<img src="/ui/images/doctor_small_img.png" class="img-responsive">
									</div>
									<div class="col-md-8">
										<div class="doctor-info">
											<h4 style="margin-top: 0px;">Dr. Venu Kumari</h4>
											<p>M.Phil, Diploma in Dermatology, MBBS</p>
											<p><span>Experience :</span>14 Yrs</p>
											<p><span>Mother Tongue:</span> Kannada</p>
											<p><span>Languages Known:</span>Kannada, English, Spanish</p>
											<p><span>Medicine Type :</span> Allopathy</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="row">
									<div class="col-md-6">
										<p style="color: #AEAEB0">Fees</p>
										<ul class="list-unstyled doctor-cost">
											<li>
												<div class="media">
													<div class="media-left">
														<a href="javascript:void(0);">
															<img class="media-object" src="/ui/images/big-webcam.png">
														</a>
													</div>
													<div class="media-body">
														<h4><i class="fa fa-inr" aria-hidden="true"></i>450 </h4>
														<small>15 Min's Duration</small>
													</div>
												</div>
											</li>
											<li>
												<div class="media">
													<div class="media-left">
														<a href="javascript:void(0);">
															<img class="media-object" src="/ui/images/big-ring.png">
														</a>
													</div>
													<div class="media-body">
														<h4><i class="fa fa-inr" aria-hidden="true"></i>300 </h4>
														<small>15 Min's Duration</small>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-md-6 common-btn-all">
										<ul class="list-unstyled">
											<li>
												<button class="btn btn-common-green">Call Now</button>
											</li>
											<li>
												<button class="btn btn-common-pink">Book Appointment</button>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div><!-- Always Show Ends -->
						<div class="hideAndShow" id="oneid">
							<form action="payment.php">
								<div class="doctor-consult-type">
									<ul class="text-center list-inline consulting">
										<li>
											<div class="radio">
												<input id="consult-video" type="radio" name="dctr-consulting">
												<label for="consult-video">
													<img src="/ui/images/webcam.png">Video Call
			    									<h4><i class="fa fa-inr"></i> 450.00</h4>
												</label>
											</div>
										</li>
										<li>
											<div class="radio">
												<input id="consult-voice" type="radio" name="dctr-consulting">
												<label for="consult-voice">
													<img src="/ui/images/webcam.png"> Voice Call
			    									<h4><i class="fa fa-inr"></i> 300.00</h4>
												</label>
											</div>
										</li>
									</ul>
								</div>
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
									</div><!-- First Day -->
									<div class="secondday tab-pane fade"><!-- Second Day -->
										<div class="meridion_selection">
											<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu4">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu5">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu6">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu7">NIGHT</a></li>
											</ul>
											<div class="tab-content">
										    <div class="menu4 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu5 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu6 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu7 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
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
											<div class="tab-content">
										    <div class="menu8 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu9 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu10 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu11 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
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
											<div class="tab-content">
										    <div class="menu12 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu13 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu14 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu15 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
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
											<div class="tab-content">
										    <div class="menu16 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu17 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu18 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu19 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
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
											<div class="tab-content">
										    <div class="menu20 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu21 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu22 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu23 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
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
											<div class="tab-content">
										    <div class="menu24 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu25 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu26 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu27 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
											</div>
										</div>
									</div><!-- Seventh Day -->
									<div class="commonScheduleButton">
										<center>
											<a href="javascript:void(0);" class="btn-schedule" data-toggle="modal" data-target="#whoIsPatient">Schedule Now</a>
									  </center>
								  </div>
								</div><!-- Calendar Contents Ends -->
								<!-- #Who Is Patient Model  -->
									<div class="modal fade appointment" id="whoIsPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body patientDetailBody">
													<h4>Who Is The Patient</h4>
														<ul class="list-inline">
															<li>
																<div class="radio">
																	<input id="me" class="appointAs" type="radio" name="appointas" >
																	<label for="me">Me</label>
																</div>
															</li>
															<li>
																<div class="radio">
																	<input id="other" class="appointAs" type="radio" name="appointas" checked="true">
																	<label for="other">Another Person</label>
																</div>
															</li>
														</ul>
														<div class="form-group width70">
															<label class="control-label">Patient Name</label>
															<input class="form-control">
														</div>
														<div class="row">
															<div class="col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="control-label">Gender</label>
																	<div class="select">
																		<select class="form-control">
																			<option>Female</option>
																			<option>Male</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="control-label">Height</label>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="select">
																				<select class="form-control" placeholder="Feet">
																					<option disabled selected>Feet</option>
																					<option>1 Feet</option>
																					<option>2 Feet</option>
																					<option>3 Feet</option>
																					<option>4 Feet</option>
																					<option>5 Feet</option>
																					<option>6 Feet</option>
																					<option>7 Feet</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="select">
																				<select class="form-control">
																					<option disabled selected>Inches</option>
																					<option>0</option>
																					<option>1 Inches</option>
																					<option>2 Inches</option>
																					<option>3 Inches</option>
																					<option>4 Inches</option>
																					<option>5 Inches</option>
																					<option>6 Inches</option>
																					<option>7 Inches</option>
																					<option>8 Inches</option>
																					<option>9 Inches</option>
																					<option>10 Inches</option>
																					<option>11 Inches</option>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="control-label">Blood Group</label>
																	<div class="select">
																		<select class="form-control">
																			<option>O+</option>
																			<option>O-</option>
																			<option>A+</option>
																			<option>A-</option>
																			<option>B+</option>
																			<option>B-</option>
																			<option>AB+</option>
																			<option>AB-</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="control-label">Weight</label>
																	<div class="select">
																		<select class="form-control">
																			<option>20Kg</option>
																			<option>25Kg</option>
																			<option>30Kg</option>
																			<option>35Kg</option>
																			<option>40Kg</option>
																			<option>45Kg</option>
																			<option>50Kg</option>
																			<option>55Kg</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group text-center" style="margin-top: 5%">
															<button class="btn btn-schedule" id="fixappoint">Continue</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									<!-- #Who Is Patient Model  -->
							</div>
							<div class="appointmentSummary" hidden><!-- Appointment Summary -->
								<div class="summaryHead">
									<h4>Appointment Summary<span class="pull-right"><i class="fa fa-times" aria-hidden="true"></i></span></h4>
								</div>
								<div class="summaryContent">
									<div class="col-xs-3">
										<p><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;09-Apr-2016</p>
										<p><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;11:30am</p>
									</div>
									<div class="col-xs-3">
										<img src="/ui/images/big-webcam.png" class="img-responsive summaryContent-video">
										<div class="video-text">Video Call</div>
										<div class="clearfix amount"><h2><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;450 </h2></div>
									</div>
								</div>
								<div class="additionInformation">
									<h4>Additional Information About You</h4>
									<div class="additionInformationContent">
										<div class="row">
												<div class="col-md-6 col-lg-6 col-sm-6">
												<p>Do you have any previously diagnosed reports?</p>
											<div class="uploadedReports">
												<div id="uploadedImages"></div>
												<div class="uploadMore">
													<a href="javascript:void(0);" class="btn-schedule" data-toggle="modal" data-target="#uploadModel">Upload Reports</a>
													<div class="modal fade reportUpload" id="uploadModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><!-- Upload File Modal -->
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-body uploadBody text-center">
																	<ul class="list-inline">
																		<li>
																			<img src="/ui/images/page.png" class="img-resposive">
																		</li>
																		<li><h3>Attach Reports</h3></li>
																	</ul>
																	<div class="form-group">
																		<select class="form-control">
																			<option disabled selected>Select Report Type</option>
																			<option>CT Scan</option>
																			<option>X-ray</option>
																			<option>Prescription</option>
																			<option>Reports</option>
																		</select>
																	</div>
																	<div class="form-group uploadReport">
																		<label for="file-upload" class="custom-file-upload">
    																	Upload Files
																		</label>
																		<input id="file-upload" type="file"/>
																	</div>
																	<div class="form-group">
																		<a href="javascript:void(0);" class="btn-schedule">Attach</a>
																	</div>
																</div>
															</div>
														</div>
													</div><!-- Upload File Modal Ends -->
												</div>
											</div>
												</div>
												<div class="col-md-6 col-lg-6 col-sm-6">
													<ul class="list-inline reportYesNo">
														<li>
															<div class="radio">
																<input id="noReport" type="radio" class="sheReportYN" name="reports" checked='true'>
																<label for="noReport">No</label>
															</div>
														</li>
														<li>
															<div class="radio">
																<input id="yesReport" type="radio" class="sheReportYN" name="reports">
																<label for="yesReport">Yes</label>
															</div>
														</li>
													</ul>
												</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-lg-6 col-sm-6">
												<p>Do you take any medications?</p>
												<div class="describeMedication">
													<div class="form-group">
														<label class="control-label">Describe about Your Medication</label>
														<textarea class="form-control" rows="5"></textarea>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-lg-6 col-sm-6">
												<ul class="list-inline reportYesNo">
													<li>
														<div class="radio">
															<input id="noMedication" type="radio" class="descMedication" name="medications" checked='true'>
															<label for="noMedication">No</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="yesMedication" type="radio" class="descMedication" name="medications">
															<label for="yesMedication">Yes</label>
														</div>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-lg-6 col-sm-6">
												<p>Do you have any allergies?</p>
												<div class="describeAllergy">
													<div class="form-group">
														<label class="control-label">Describe about Your Allergy</label>
														<textarea class="form-control" rows="5"></textarea>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-lg-6 col-sm-6">
												<ul class="list-inline reportYesNo">
													<li>
														<div class="radio">
															<input id="noAllergy" class="allergyType" type="radio" name="allery" checked="true">
															<label for="noAllergy">No</label>
														</div>
													</li>
													<li>
														<div class="radio">
															<input id="yesAllergy" class="allergyType" type="radio" name="allery">
															<label for="yesAllergy">Yes</label>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="proceedNext">
									<ul class="list-inline">
										<li>
											<button class="btn btn-schedule" type="submit">Proceed To Payment</button>
										</li>
										<li>
											<button class="btn btn-cancel">Cancel</button>
										</li>
									</ul>
								</div>
							</div>
						</form>
					</div><!-- #Doctor Info Ends -->
					<div class="doctor-more-info">
						<div class="doctor-more-info-head">
							<h4>About Doctor</h4>
						</div>
						<div class="doctor-more-content">
							<p>
								Dr.Venu Kumari is very well qualified and experienced in Dermatologist. Apart from general dermatology,her special expertise in cosmetic dermatology, <a href="javascript:void(0);">Read More</a>
							</p>
						</div>
						<div class="doctor-more-info-head">
							<h4>Specializations</h4>
						</div>
						<div class="doctor-more-content">
							<ul>
								<li>Dermatologist</li>
								<li>Cosmetologist</li>
								<li>Pediatric Dermatologist</li>
							</ul>
						</div>
							<div class="doctor-more-info-head">
								<h4>Education</h4>
							</div>
							<div class="doctor-more-content">
								<ul>
									<li>MBBS- St Jhon's Medical College, Bengaluru,2004</li>
									<li>MD-Dermatology-Physical Theraphy Teaching &#38; Treatment Center, LMTG Hospital,Sion,Mumbai,2009</li>
								</ul>
							</div>
							<div class="doctor-more-info-head">
								<h4>Award &#38; Certifications</h4>
							</div>
							<div class="doctor-more-content">
								<ul>
									<li>
										Gold Medalist, MD Dermatology of Maharastra University Of Health Sciences-2009
									</li>
								</ul>
							</div>
							<div class="doctor-more-info-head">
								<h4>Registration</h4>
							</div>
							<div class="doctor-more-content">
								<ul>
									<li>
										71232 Karnataka Medical Council, 2004.
									</li>
								</ul>
							</div>
						</div>
				</div><!-- #Right Section -->

				<div class="col-md-3 col-lg-3 col-sm-3 she-doctor-right"><!-- #Left Section -->
					<div class="doctor-name">
						<h6>Articles By Dr.Venu Kumari</h6>
					</div>
					<div class="doctor-article">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<p class="doctor-article-name">
							4 Surgical Alternatives for Burns and wounds
						</p>
					</div>
					<div class="doctor-article">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<p class="doctor-article-name">
							4 Surgical Alternatives for Burns and wounds
						</p>
					</div>
				</div><!-- #Left Section -->

			</div>
		</div>
		<!--Actual Doctor Details Ends-->
	</div>
</div>
<!-- #Doctor Details Ends -->
<?php include('common/footer.php') ?>
