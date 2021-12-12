<?php include('common/inner-header.php') ?>

<!-- Body section starts here -->
	<div class="container-fluid doctor-list-bg">
		<div class="container">
			<ol class="breadcrumb" style="margin-bottom: 5px;">
			  <li><a href="index.php">Home</a></li>
			  <li><a href="javascript:void(0);">Consult Privately</a></li>
			  <li class="active">Dermatologist</li>
			</ol>
			<div class="row">
				<div class="col-sm-6">
					<h4 class="doctor_heading">Showing results for <span>Dermatologist</span></h4>
				</div>
				<div class="col-sm-6">
					<div class="form-inline sort_list">
						<label>Sort By :</label>
						<select class="form-control">
						  <option>Default</option>
						  <!-- <option>Ratings</option> -->
						  <option>Experience</option>
						  <option>Fees</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row main_doctor_sec">
			<!-- left section starts here -->
				<div class="col-sm-3">
					<div class="sort_left">
						<div class="top_header_left_sort">
							<h4>Our Specialities <span class="pull-right"><span class="compress_btn"><i class="fa fa-minus"></i></span></span></h4>
						</div>
						<div class="specialitis_list">
							<ul class="list-unstyled">
								<li><a href="javascript:void(0)">Obesity</a></li>
								<li><a href="javascript:void(0)">Hair Care</a></li>
								<li><a href="javascript:void(0)">Skin Care</a></li>
								<li><a href="javascript:void(0)">Infertility</a></li>
								<li><a href="javascript:void(0)">Psychiatry</a></li>
								<li><a href="javascript:void(0)">Psychology</a></li>
								<li><a href="javascript:void(0)">Gynaecology</a></li>
								<li><a href="javascript:void(0)">Endocrinology</a></li>
								<li><a href="javascript:void(0)">Sexual Health</a></li>
								<li><a href="javascript:void(0)">General Medicine</a></li>	
							</ul>
						</div>
					</div>
					<h4><strong>Articles by Doctor</strong></h4>
					<div class="sort_left custom_box_shadow">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<h5 class="custom_sort_h4">4 Surgical alternatives for burns and wounds</h5>
					</div>
					<div class="sort_left custom_box_shadow">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<h5 class="custom_sort_h4">4 Surgical alternatives for burns and wounds</h5>
					</div>
					<div class="sort_left custom_box_shadow">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<h5 class="custom_sort_h4">4 Surgical alternatives for burns and wounds</h5>
					</div>
					<div class="sort_left custom_box_shadow">
						<img src="/ui/images/doctor_big_image.jpg" class="img-responsive">
						<h5 class="custom_sort_h4">4 Surgical alternatives for burns and wounds</h5>
					</div>	
				</div>
			<!-- left section ends here -->
			<!-- Center section starts here -->
				<div class="col-sm-6">
					<div class="doctor_main_details">
						<div class="row">
							<div class="col-sm-3">
								<div class="spacing_doctor">
									<img src="/ui/images/doctor_small_img.png" class="img-responsive">
									<!-- <h4 class="doctor_total_served"><b>200+</b></h4>
									<p class="text-center">Patients Consulted</p> -->
								</div>
							</div>
							<div class="col-sm-5">
								<div class="spacing_doctor she-consult-detail">
									<h4><b><a href="doctor-details.php">Dr. Venu Kumari</a></b></h4>
									<p>M.Phil, Diploma in Dermitology, MBBS</p>
									<p><span>Experience :</span>14 Yrs</p>
									<p><span>Mother Tongue:</span> Kannada</p>
									<p><span>Languages Known:</span>Kannada, English, Spanish</p>
									<p><span>Medicine Type :</span> Allopathy</p>
								</div>
							</div>
							<div class="col-sm-4" style="border-left:1px solid #F0F0F0">
								<div class="spacing_doctor">
									<p>Fees </p>
									<ul class="list-inline">
										<li>
											<center><img src="/ui/images/webcam.png"></center>
											<h4><i class="fa fa-inr"></i> 450.00</h4>
										</li>
										<li>
											<center><img src="/ui/images/ring.png"></center>
											<h4><i class="fa fa-inr"></i> 650.00</h4>
										</li>
									</ul>
									<button class="btn btn-success">Call Now</button>
									<button class="btn btn-warning book_appt_btn">Book Appointment</button>
								</div>
							</div>
						</div>
						<div class="doctor_calander">
							<div class="consult-type" style="border-top: 1px solid #F0F0F0;padding: 1% 0px">
							<ul class="text-center list-inline consulting">
								<li>
									<div class="radio">
										<input id="video-cl1" type="radio" name="consult1" value="video-call">
										<label for="video-cl1">
											<img src="/ui/images/webcam.png"> Video Call
	    									<h4><i class="fa fa-inr"></i> 650.00</h4>
										</label>
									</div>
								</li>
								<li>
									<div class="radio">
										<input id="voice-cl1" type="radio" name="consult1" value="voice-call">
										<label for="voice-cl1">
											<img src="/ui/images/webcam.png"> Voice Call
	    									<h4><i class="fa fa-inr"></i> 450.00</h4>
										</label>
									</div>
								</li>
							</ul>
						</div>
							<div class="calander_dates_heading">
								<ul class="nav nav-tabs">
									<li class="previousDate">
										<i class="fa fa-chevron-circle-left fa-2x prevapp" aria-hidden="true"></i>
									</li>
								    <li class="active"><a data-toggle="tab" href=".firstday">
								    	<p class="today_day">Today</p>
										<p><span class="today_date"></span> <span class="today_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".secondday">
								    	<p class="tomorrow_day"></p>
										<p><span class="tomorrow_date"></span> <span class="tomorrow_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".thirdday">
								    	<p class="thirdDay_day"></p>
										<p><span class="thirdDay_date"></span> <span class="thirdDay_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".fourthday">
										<p class="fourthDay_day"></p>
										<p><span class="fourthDay_date"></span> <span class="fourthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".fifthday">
										<p class="fifthDay_day"></p>
										<p><span class="fifthDay_date"></span> <span class="fifthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".sixthday">
										<p class="sixthDay_day"></p>
										<p><span class="sixthDay_date"></span> <span class="sixthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".seventh">
										<p class="seventhDay_day"></p>
										<p><span class="seventhDay_date"></span> <span class="seventhDay_month"></span></p>
								   	</a></li>
								   	<li class="nextDate">
										<i class="fa fa-chevron-circle-right fa-2x nextapp" aria-hidden="true"></i>
									</li>
								</ul>
							</div>
							<div class="tab-content">
								<div class="tab-pane fade in active firstday">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="secondday tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="thirdday tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="fourthday tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="fifthday tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="sixthday tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="seventh tab-pane fade">
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
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="doctor_main_details">
						<div class="row">
							<div class="col-sm-3">
								<div class="spacing_doctor">
									<img src="/ui/images/doctor_small_img.png" class="img-responsive">
									<!-- <h4 class="doctor_total_served"><b>200+</b></h4>
									<p class="text-center">Patients Consulted</p> -->
								</div>
							</div>
							<div class="col-sm-5">
								<div class="spacing_doctor she-consult-detail">
									<h4><b><a href="doctor-details.php">Dr. Venu Kumari</a></b></h4>
									<p>M.Phil, Diploma in Dermitology, MBBS</p>
									<p><span>Experience :</span>14 Yrs</p>
									<p><span>Mother Tongue:</span> Kannada</p>
									<p><span>Languages Known:</span>Kannada, English, Spanish</p>
									<p><span>Medicine Type :</span> Allopathy</p>
								</div>
							</div>
							<div class="col-sm-4" style="border-left:1px solid #F0F0F0">
								<div class="spacing_doctor">
									<p>Fees </p>
									<ul class="list-inline">
										<li>
											<center><img src="/ui/images/webcam.png"></center>
											<h4><i class="fa fa-inr"></i> 450.00</h4>
										</li>
										<li>
											<center><img src="/ui/images/ring.png"></center>
											<h4><i class="fa fa-inr"></i> 650.00</h4>
										</li>
									</ul>
									<button class="btn btn-success">Call Now</button>
									<button class="btn btn-warning book_appt_btn">Book Appointment</button>
								</div>
							</div>
						</div>
						<div class="doctor_calander">
							<div class="consult-type" style="border-top: 1px solid #F0F0F0;padding: 1% 0px">
								<ul class="text-center list-inline consulting">
									<li>
										<div class="radio">
											<input id="video-cl" type="radio" name="consult" value="video-call">
											<label for="video-cl">
												<img src="/ui/images/webcam.png"> Video Call
		    									<h4><i class="fa fa-inr"></i> 650.00</h4>
											</label>
										</div>
									</li>
									<li>
										<div class="radio">
											<input id="voice-cl" type="radio" name="consult" value="voice-call">
											<label for="voice-cl">
												<img src="/ui/images/webcam.png"> Voice Call
		    									<h4><i class="fa fa-inr"></i> 450.00</h4>
											</label>
										</div>
									</li>
								</ul>
							</div>
							<div class="calander_dates_heading">
								<ul class="nav nav-tabs">
									<li class="previousDate">
										<i class="fa fa-chevron-circle-left fa-2x prevapp" aria-hidden="true"></i>
									</li>
								    <li class="active"><a data-toggle="tab" href=".firstday">
								    	<p class="today_day">Today</p>
										<p><span class="today_date"></span> <span class="today_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".secondday">
								    	<p class="tomorrow_day"></p>
										<p><span class="tomorrow_date"></span> <span class="tomorrow_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".thirdday">
								    	<p class="thirdDay_day"></p>
										<p><span class="thirdDay_date"></span> <span class="thirdDay_month"></span></p>
								    </a></li>
								    <li><a data-toggle="tab" href=".fourthday">
										<p class="fourthDay_day"></p>
										<p><span class="fourthDay_date"></span> <span class="fourthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".fifthday">
										<p class="fifthDay_day"></p>
										<p><span class="fifthDay_date"></span> <span class="fifthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".sixthday">
										<p class="sixthDay_day"></p>
										<p><span class="sixthDay_date"></span> <span class="sixthDay_month"></span></p>
								   	</a></li>
								   	<li><a data-toggle="tab" href=".seventh">
										<p class="seventhDay_day"></p>
										<p><span class="seventhDay_date"></span> <span class="seventhDay_month"></span></p>
								   	</a></li>
								   	<li class="nextDate">
										<i class="fa fa-chevron-circle-right fa-2x nextapp" aria-hidden="true"></i>
									</li>
								</ul>
							</div>
							<div class="tab-content">
								<div class="tab-pane fade in active firstday">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu30">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu31">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu32">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu33">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu30 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu31 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu32 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu33 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="secondday tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu34">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu35">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu36">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu37">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu34 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu35 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu36 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu37 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="thirdday tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu38">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu39">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu40">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu41">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu38 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu39 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu40 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu41 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="fourthday tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu42">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu43">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu44">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu45">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu42 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu43 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu44 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu45 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="fifthday tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu46">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu47">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu48">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu49">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu46 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu47 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu48 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu49 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="sixthday tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu50">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu51">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu52">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu53">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu50 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu51 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu52 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu53 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
								<div class="seventh tab-pane fade">
									<div class="meridion_selection">
										<ul class="nav nav-tabs">
										    <li class="active"><a data-toggle="tab" href=".menu54">MORNING</a></li>
										    <li><a data-toggle="tab" href=".menu55">AFTERNOON</a></li>
										    <li><a data-toggle="tab" href=".menu56">EVENING</a></li>
										    <li><a data-toggle="tab" href=".menu57">NIGHT</a></li>
										</ul>
										<div class="tab-content">
										    <div class="menu54 tab-pane fade in active">
										      <ul class="list-inline morning-time text-center"></ul>
										    </div>
										    <div class="menu55 tab-pane fade">
										      <ul class="list-inline afternoon-time text-center"></ul>
										    </div>
										    <div class="menu56 tab-pane fade">
										       <ul class="list-inline evening-time text-center"></ul>
										    </div>
										    <div class="menu57 tab-pane fade">
										      <ul class="list-inline night-time text-center"></ul>
										    </div>
										    <center><button class="btn btn-schedule">Schedule Now</button></center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- center section ends here -->
			<!-- Right section starts here -->
				<div class="col-sm-3">
				<form action="#" method="post" id="filters_form">
					<div class="sort_left">
						<div class="top_header_left_sort1">
							<h4>Filters <span class="pull-right clearall" onclick="reset_filters()"> <small>Clear All</small></h4>
						</div>
						<div>
							<div class="top_header_left_sort2">
								<h4>Medicine Type <span class="pull-right"><span class="compress_btn"><i class="fa fa-minus"></i></span></span></h4>
							</div>
							<div class="right_section_filters">
								<div>
									<input id="chk-1" class="checkbox-custom" type="checkbox" />
									<label for="chk-1" class="checkbox-custom-label">Allopathy</label>
								</div>
								<div>
									<input id="chk-2" class="checkbox-custom" type="checkbox">
									<label for="chk-2" class="checkbox-custom-label">Ayurveda</label>
								</div>
								<div>
									<input id="chk-5" class="checkbox-custom" type="checkbox">
									<label for="chk-5" class="checkbox-custom-label">Chinese Medicine</label>
								</div>
								<div>
									<input id="chk-3" class="checkbox-custom" type="checkbox">
									<label for="chk-3" class="checkbox-custom-label">Homeopathy</label>
								</div>
								<div>
									<input id="chk-4" class="checkbox-custom" type="checkbox">
									<label for="chk-4" class="checkbox-custom-label">Naturopathy</label>
								</div>	
							</div>
						</div>
						<div>
							<div class="top_header_left_sort2">
								<h4>Select Language <span class="pull-right"><span class="compress_btn"><i class="fa fa-minus"></i></span></span></h4>
							</div>
							<div class="right_section_filters">
								<div>
									<input id="chk-6" class="checkbox-custom" type="checkbox">
									<label for="chk-6" class="checkbox-custom-label">English</label>
								</div>
								<div>
									<input id="chk-7" class="checkbox-custom" type="checkbox">
									<label for="chk-7" class="checkbox-custom-label">Hindi</label>
								</div>
								<div>
									<input id="chk-8" class="checkbox-custom" type="checkbox">
									<label for="chk-8" class="checkbox-custom-label">Kannada</label>
								</div>
								<div>
									<input id="chk-9" class="checkbox-custom" type="checkbox">
									<label for="chk-9" class="checkbox-custom-label">Tamil</label>
								</div>
								<div>
									<input id="chk-10" class="checkbox-custom" type="checkbox">
									<label for="chk-10" class="checkbox-custom-label">Telugu</label>
								</div>
							</div>
						</div>
						<div>
							<div class="top_header_left_sort2">
								<h4>Consultation Fees <span class="pull-right"><span class="compress_btn"><i class="fa fa-minus fa fa-minus"></i></span></span></h4>
							</div>
							<div class="right_section_filters"><br/>
								<div class="accordion-content rangee">
									<div id="slider-range"></div><br/>
									<div class="row" style="margin-right: 0px;">
										<div class="col-xs-6">
				                          <input type="text" id="amount" readonly>
				                        </div>
				                        <div class="col-xs-6 text-right">
				                          <input type="text" id="amount2" readonly >
				                        </div>
				                    </div>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			<!-- Right section ends here -->
			</div>
		</div>
	</div>
<!-- Body section ends here -->
<?php include('common/footer.php') ?>