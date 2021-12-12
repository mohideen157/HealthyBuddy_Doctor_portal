<?php include('common/reception-header.php') ?>
<!-- #Receptionist Page Starts -->
	<div class="container-fluid doctorPageProfile">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3 col-lg-3"><!--Receptionist Right Section -->
					<div class="doctorOnline">
						<div class="media">
							<a class="media-left" href="javascript:void(0);">
								<img src="/ui/images/recp-profile.png" class="media-object">
							</a>
							<div class="media-body">
								 <h4 class="media-heading">Uma Trivedi</h4>
								 <p class="commonColor">Receptionist</p>
							</div>
						</div>
						<div class="online-offline">
							<label class="switch switch-left-right">
						    	<input class="switch-input" type="checkbox" checked="true" id='doctor_status' />
						    	<span class="switch-label"></span> 
						    	<span class="switch-handle"></span> 
					    	</label>
					    	<small class="commonColor">You are Online</small>
					    	<div class="clearfix"></div>
						</div>
					</div>
					<div class="doctorProfileTab">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
					    		<a href="#appointments-shows" aria-controls="appointments-shows" role="tab" data-toggle="tab">Appointments</a>
					    	</li>
					    	<li role="presentation">
					    		<a href="#conusting-time-fee" aria-controls="conusting-time-fee" role="tab" data-toggle="tab">Consultation Time &#38; Fees</a>
					    	</li>
						</ul>
					</div>
				</div><!--Receptionist Right Section Ends -->
				<div class="col-sm-9 col-md-9 col-lg-9"><!--Receptionist Left Section -->
					<div class="doctorContentDetails">
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="appointments-shows"><!-- Appointment Section -->
								<div class="tabHeading">
									<h3>Appointments</h3>
								</div>
								<div class="AppointmentSection">
									<div class="row">
										<div class="col-sm-6">
											<ul class="nav nav-tabs" role="tablist">
												<li role="presentation" class="active">
													<a href="#upcomingAppointments" aria-controls="upcomingAppointments" role="tab" data-toggle="tab">Upcoming Appointments</a>
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
								<div class="patientAppointmentDetails reception-tab">
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="upcomingApp"><!-- UpComingApp -->
											<div class="UpcomingAppDetails"><!-- Appointment Details -->
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline vertical-align-top">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Hadimani</h4>
								                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appiontment ID</p>
														<p class="text-uppercase">SHDCT351</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Date &#38; Timing</p>
														<p>2:30 pm<br/>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p>10 Hrs</p>
													</li>
													<li class="commonWidth">
														<button class="btn btn-preview">Cancel</button>
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
											</div><!-- Appointment Details Ends -->
											<div class="UpcomingAppDetails"><!-- Appointment Details -->
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline vertical-align-top">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Hadimani</h4>
								                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appiontment ID</p>
														<p class="text-uppercase">SHDCT351</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Date &#38; Timing</p>
														<p>2:30 pm<br/>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p>10 Hrs</p>
													</li>
													<li class="commonWidth">
														<button class="btn btn-preview">Cancel</button>
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
											</div><!-- Appointment Details Ends -->
											<div class="UpcomingAppDetails"><!-- Appointment Details -->
												<ul class="list-inline patientContactDetails">
													<li>
														<ul class="list-inline vertical-align-top">
															<li><img class="img-responsive patientImage" src="/ui/images/doctorPage.png"></li>
															<li>
																<h4>Pavitra Hadimani</h4>
								                                <p class="text-uppercase commonColor">Patient Id:shdct3313</p>
															</li>
														</ul>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appointment Type</p>
														<center><img class="img-responsive" src="/ui/images/webcam.png"></center>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Appiontment ID</p>
														<p class="text-uppercase">SHDCT351</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Date &#38; Timing</p>
														<p>2:30 pm<br/>May 30, 2016</p>
													</li>
													<li class="commonWidth">
														<p class="commonColor">Call Status</p>
														<p>10 Hrs</p>
													</li>
													<li class="commonWidth">
														<button class="btn btn-preview">Cancel</button>
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
											</div><!-- Appointment Details Ends -->
										</div>
									</div>
								</div>
							</div><!-- Appointment Section Ends -->
							<div role="tabpanel" class="tab-pane" id="conusting-time-fee"><!-- Consultation Fees -->
								<div class="tabHeading">
									<h3>Consultation Fees &#38; Time</h3>
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
															<input id="avail-video" class="checkbox-custom" type="checkbox" checked="true">
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
														<input id="select-all" class="checkbox-custom" type="checkbox" checked="true">
														<label for="select-all" class="checkbox-custom-label">
															Select All
														</label>
													</li>
													<li>
														<input id="repeat-all" class="checkbox-custom" type="checkbox" checked="true">
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
							</div><!-- Consultation Section Ends -->
						</div>
					</div>
				</div><!--Receptionist Left Section Ends -->
			</div>
		</div>
	</div>
<!-- #Receptionist Page Ends -->
<?php include('common/footer.php') ?>