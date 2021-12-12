<?php include('common/home-header.php') ?>
<!-- #Slider Section Start -->
	<section>
		<div class="container-fluid home_slider">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				  </ol>
				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				    <div class="item active">
				      <img src="/ui/images/Banner1.jpg" width="100%">
				      <div class="carousel-caption wow fadeIn">
				        <h2>Teeth Pain?</h2>
				        <h2>Talk to a Doctor online, Anytime</h2>
				      </div>
				    </div>
				   <div class="item">
				      <img src="/ui/images/Banner1.jpg" width="100%">
				      <div class="carousel-caption">
				        <h2>Are you Pregnent?</h2>
				        <h2>Talk to a Doctor online, Anytime</h2>
				      </div>
				    </div>
				  </div>
				  <div class="slider_form">
						<div class="row">
							<div class="col-sm-6">
						  		<p class="light_font">Have a visit in minutes using your computer, tablet or phone.</p><br/>
						  		<div class="row ">
						  			<div class="col-sm-11">
						  				<div class="col-sm-3">
							  				<center><img src="/ui/images/choose_doctor_icon.png" class="img-responsive"></center>
							  				<p class="light_font">Choose Speciality</p>
							  			</div>
							  			<div class="col-sm-1 right-icon text-center">
							  				<img src="/ui/images/right_icon.png">
							  			</div>
							  			<div class="col-sm-3 text-center">
							  				<center><img src="/ui/images/pay_icon.png" class="img-responsive"></center>
							  				<p class="light_font">Make Payment</p>
							  			</div>
							  			<div class="col-sm-1 right-icon text-center">
							  				<img src="/ui/images/right_icon.png">
							  			</div>
							  			<div class="col-sm-3 text-center">
							  				<center><img src="/ui/images/video_icon.png" class="img-responsive"></center>
							  				<p class="light_font">Talk to Doctor</p>
							  			</div>
						  			</div>
						  		</div><br/><br/>
						  		<form method="post" action="doctor-listing.php">
						  			<div class="row" style="margin:0px">
						  				<div class="col-xs-10" style="padding:0px">
						  					<select class="form-control" placeholder="Search Speciality / Symptoms">
						  						<option disabled selected>Search Speciality / Symptoms</option>
						  						<option>Hair Care</option>
						  						<option>Psychology</option>
						  						<option>Sexual Health</option>
						  					</select>
						  				</div>
						  				<div class="col-xs-2" style="padding:0px">
						  					<input type="submit" name="submit" class="btn btn-warning submit_fo" value="Search">
						  				</div>
						  			</div><br/><br/>
					  				<div class="form-group text-center our-special-center">
					  					<a href="javascript:void(0);" class="special">Our Specialities</a>
					  				</div>
						  		</form>
						  	</div>
						  	<div class="col-sm-6">
						  		<div class="form-main-slider">
								  <ul class="nav nav-tabs" role="tablist">
								    <li role="presentation" class="active">
								    	<a href="#home" aria-controls="home" role="tab" data-toggle="tab">
								    		Our Services
								    	</a>
								    </li>
								    <li role="presentation">
								    	<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
								    		Benefits of SheDoctr
								    	</a>
								    </li>
								  </ul>
								  <div class="tab-content lightFont">
								    <div role="tabpanel" class="tab-pane active" id="home">
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/female-doctr.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Consult a Doctor instantly</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-two-icon.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Order Lab Test At Home</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-three-icon.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Order medicine at doorstep</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row last-row-border">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-four-icon.png">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Access your medical at doorstep</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    </div>
								    <div role="tabpanel" class="tab-pane" id="profile">
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/female-doctr.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Benifits of Doctor</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-two-icon.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Order Lab Test At Home</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-three-icon.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Order medicine at doorstep</h4>
								    			<p class="light_font">
								    				Get immediate care when you need it, consult a GP
								    			</p>
								    		</div>
								    	</div>
								    	<div class="row customed-row last-row-border">
								    		<div class="col-sm-2">
								    			<img src="/ui/images/form-four-icon.png" class="img-responsive">
								    		</div>
								    		<div class="col-sm-9">
								    			<h4>Access your medical at doorstep</h4>
								    			<p class="light_font">Get immediate care when you need it, consult a GP</p>
								    		</div>
								    	</div>
								    </div>
								  </div>
						  		</div>
						  	</div>
						</div>
				  </div>
			</div>
		</div>
	</section>
<!--Slider Section Ends -->

<!-- Our Speciality Section Starts -->
<section class="section-speciality">
	<div class="Our_speacilit6ies">
		<div class="container-fluid">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="commonTitle">
						<h2 class="text-center">Our <span class="commonPink">Specialities</span></h2>
					</div> <!--section header end-->
					<div class="text-center">
						<ul class="nav nav-tabs img_tabs text-center wow fadeIn" data-wow-duration="2s">
							<li class="active">
						    	<a data-toggle="tab" href="#img17">
						    		<img src="/ui/images/diabetis.jpg" width="96px" height="96px" class="img-circle"><br>Endocrinology
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img18">
						    		<img src="/ui/images/GeneralMedicine.jpg" width="96px" height="96px" class="img-circle"><br>General Medicine
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img9" class="arrow">
						    		<img src="/ui/images/Ganeocology.jpg" width="96px" height="96px" class="img-circle" /><br/>Gynaecology
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img12">
						    		<img src="/ui/images/HairCare.jpg" width="96px" height="96px" class="img-circle"><br>Hair Care
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img10">
						    		<img src="/ui/images/Inferlity.jpg" width="96px" height="96px" class="img-circle" /><br />Infertility
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img13">
						    		<img src="/ui/images/Obesity.jpg" width="96px" height="96px" class="img-circle"><br>Obesity
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img16">
						    		<img src="/ui/images/MentalHealth.jpg" style="width: 96px; height: 96px;" class="img-circle"><br>Psychiatry
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img14">
						    		<img src="/ui/images/Psychology.jpg" width="96px" height="96px" class="img-circle"><br>Psychology
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img15">
						    		<img src="/ui/images/SexualHelath.jpg" width="96px" height="96px" class="img-circle"><br>Sexual Health
						    	</a>
						    </li>
						    <li>
						    	<a data-toggle="tab" href="#img11">
						    		<img src="/ui/images/SkinCare.jpg" width="96px" height="96px" class="img-circle"><br>Skin Care
						    	</a>
						    </li>
						</ul>
						<div class="tab-content img_margin">
						    <div id="img9" class="tab-pane fade">
						      	<h3>Gynaecology</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet. consectetur adipisicing elit.
						      	</p>
						    </div>
							<div id="img10" class="tab-pane fade">
						        <h3>Infertility</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img11" class="tab-pane fade">
						    	<h3>Skin Care</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img12" class="tab-pane fade">
						       <h3>Hair Care</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
							<div id="img13" class="tab-pane fade">
						    	<h3>Obesity</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img14" class="tab-pane fade">
						    	<h3>Psychology</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img15" class="tab-pane fade">
						        <h3>Sexual Health</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img16" class="tab-pane fade">
						        <h3>Psychiatry</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img17" class="tab-pane fade in active">
						        <h3>Endocrinology</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						      	</p>
						    </div>
						    <div id="img18" class="tab-pane fade">
						       <h3>General Medicine</h3>
						      	<p>
						      		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						    	</p>
						    </div>
						</div>
					</div>
				</div>
		</div>
	</div>
</section>
<!-- #Our Speciality Section Ends -->

<!-- Experience our services starts here -->
<section class="experience-section">
	<div class="container-fluid bottom_shadow">
			<div class="container sheDoctor wow slideUpDown">
				<div class="commonTitle">
					<h2 class="text-center">Our <span class="commonPink">Services</span></h2>
				</div>
				<div class="sheCarousel">
					<div class="sheCarContent">
								<div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
								    <li data-target="#testimonialCarousel" data-slide-to="0" class="active"></li>
								    <li data-target="#testimonialCarousel" data-slide-to="1"></li>
								    <li data-target="#testimonialCarousel" data-slide-to="2"></li>
								    <li data-target="#testimonialCarousel" data-slide-to="3"></li>
	    						</ol>
									<div class="carousel-inner center-block">
										<div class="item active">
											<center>
												<img src="/ui/images/female-doctr.png" class="img-responsive">
												<h2>Consult a Doctor Instantly</h2>
												<p>
													No more hassle of locating and travelling to a diagnostic lab.Get doctor prescribed lab tests done in a convenience of yur home of office. Order then on your App or website and get additional discounts from our partners.
												</p>
												<a href="doctor-listing.php" class="consult-now-service">Consult Now</a>
											</center>
										</div>
										<div class="item">
											<center>
												<img src="/ui/images/lab-test-service.png" class="img-responsive">
												<h2>Order Lab Tests At Home</h2>
												<p>
													No more hassle of locating and travelling to a diagnostic lab.Get doctor prescribed lab tests done in a convenience of yur home of office. Order then on your App or website and get additional discounts from our partners.
												</p>
												<a href="javascript:void(0);" class="consult-now-service">Order Now</a>
											</center>
										</div>
										<div class="item">
											<center>
												<img src="/ui/images/medicine-delivery-service.png" class="img-responsive">
												<h2>Order Medicine At Doorstep</h2>
												<p>
													No more hassle of locating and travelling to a diagnostic lab.Get doctor prescribed lab tests done in a convenience of yur home of office. Order then on your App or website and get additional discounts from our partners.
												</p>
												<a href="javascript:void(0);" class="consult-now-service">Order Now</a>
											</center>
										</div>
										<div class="item">
											<center>
												<img src="/ui/images/Health-Record.png" class="img-responsive">
												<h2>Access Your Medical Records At Doorstep</h2>
												<p>
													No more hassle of locating and travelling to a diagnostic lab.Get doctor prescribed lab tests done in a convenience of yur home of office. Order then on your App or website and get additional discounts from our partners.
												</p>
												<a href="javascript:void(0);" class="consult-now-service">Access Now</a>
											</center>
										</div>
									</div>
									<a class="left carousel-control sheControllArrow" href="#testimonialCarousel" data-slide="prev">
										<i class="fa fa-angle-left fa-4x"></i>
									</a>
									<a class="right carousel-control sheControllArrow" href="#testimonialCarousel" data-slide="next">
										<i class="fa fa-angle-right fa-4x"></i>
									</a>
								</div>
						</div>
				</div>
			</div>
	</div>
</section>
<!-- #Experience Our Service Ends -->

<!-- #Instant Video Section Starts -->
<div class="fuullwidthn bottom_shadow_one">
	<div class="row">
		<div class="col-lg-12">
			<div class="row videoo">
				<div class="col-lg-6 col-md-12">
					<div class="Vmater">
						<div class="wematter">
							<h1> How She Doctr Works?</h1>
							<br>
							<h4 class="matr"> We are the fastest-growing family in the online real estate space. Fed up with endless on-site visits and fake listings, we created a property search system several notches above others. Led by passionate problem-solvers and backed by top investors, we have been hailed as trendsetters in just 0ne year. </h4>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="vedioU" align="center" style="border-radius: 50%;overflow: hidden;z-index: -1111111;">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="img-circle  udio"src="https://www.youtube.com/embed/EyRPmrnNLHU?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- #Instant Video Section Ends -->

<!--Benifits Of She Doctor Section Starts -->
<section class="she-benifits">
	<div class="container-fluid ind-she-main-benifit">
		<div class="container">
			<div class="commonTitle">
				<h2 class="text-center">Benefits Of&nbsp;<span class="commonPink">'SheDoctr'</span></h2>
			</div>
			<div class="ind-she-benefit-details ind-she-benefit-details-first-child">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-9">
								<h4 class="text-right">Immediate Access to Specialists</h4>
								<p class="text-justify">
									SheDoctr provides a unique platform to instantly connect with leading doctors from around the world. No more endless waiting and tiresome journeys to hospitals/clinics. This also allows for a valuable second opinion.
								</p>
							</div>
							<div class="col-md-3 wow fadeIn">
								<img src="/ui/images/specialist.png" class="img-responsive">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3 text-right wow fadeIn">
								<img src="/ui/images/privacy1.png" class="img-responsive">
							</div>
							<div class="col-md-9">
								<h4>Privacy</h4>
								<p class="text-justify">
									SheDoctr ensures users privacy by allowing to consult a doctor anonymously right from your home or your place of comfort while maintaining your identity confidential. No more worries about social pressures.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ind-she-benefit-details">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-9">
								<h4 class="text-right"> Video &#38; Audio Consultation</h4>
								<p class="text-justify">
									SheDoctr provides a platform to connect with doctors using cutting edge video and audio technology, giving an almost real life consultation experience.
								</p>
							</div>
							<div class="col-md-3 wow fadeIn">
								<img src="/ui/images/video1.png" class="img-responsive">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3 text-right wow fadeIn">
								<img src="/ui/images/delivery.png" class="img-responsive">
							</div>
							<div class="col-md-9">
								<h4>Medicine delivery at Home</h4>
								<p class="text-justify">
									SheDoctr has an integrated facility for users to order medicines at home at competitive pricing. No need to go in search of medicines or bargain for discounts.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ind-she-benefit-details">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-9">
								<h4 class="text-right"> Lab Tests at Home</h4>
								<p class="text-justify">
									SheDoctr also provides the option to order lab tests at home. No more need to remember appointments, time consuming travelling and waiting in queues. The health assistants come home to collect samples and send the test results both in online or in physical copy formats.
								</p>
							</div>
							<div class="col-md-3 wow fadeIn">
								<img src="/ui/images/lab-test1.png" class="img-responsive">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3 text-right wow fadeIn">
								<img src="/ui/images/online-records.png" class="img-responsive">
							</div>
							<div class="col-md-9">
								<h4>Maintain Online records</h4>
								<p class="text-justify">
									SheDoctr allows for maintaining your prescriptions or test reports online.  This allows you to access your records anytime, anywhere without the need to worry about carrying physical copies.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- #Benifits Of She Doctor Section Ends -->

<!-- #Multiple Corousal Section Starts -->
<section class="she-doctrs">
	<div class="container-fluid multiple_corousal">
		<div class="container">
			<div class="commonTitle">
				<h2 class="text-center">Our<span class="commonPink"> Doctors</span></h2>
			</div>
			<div id="amazingcarousel-container-1">
			    <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:960px;margin:0px auto 0px;">
			        <div class="amazingcarousel-list-container">
			            <ul class="amazingcarousel-list">
			                <li class="amazingcarousel-item ourDoctorStyle">
			                    <div class="amazingcarousel-item-container">
			                        <div class="amazingcarousel-image">
			                            <img src="/ui/images/doctor-1.jpg"  alt="Ramesh Deshpande" />
			                        </div>
			                        <div class="amazingcarousel-title doctorProfile">
			                            <span class="doctorName">Ramesh Deshpande</span>
			                            <p>USC(UK),DMG(Dermalogist)</p>
			                        </div>
			                        <div class="amazingcarousel-description">
			                            Exp : 5 Years<br/>
			                            Speciality : Sychartist<br/>
			                        </div>
			                                  
			                    </div>
			                </li>
			                <li class="amazingcarousel-item">
			                    <div class="amazingcarousel-item-container">
			                        <div class="amazingcarousel-image">
			                            <img src="/ui/images/doctor-2.jpg"  alt="Ramesh Deshpande" />
			                        </div>
			                        <div class="amazingcarousel-title doctorProfile">
			                            <span class="doctorName">Ramesh Deshpande</span>
			                            <p>USC(UK),DMG(Dermalogist)</p>
			                        </div>
			                        <div class="amazingcarousel-description">
			                            Exp : 5 Years<br/>
			                            Speciality : Sychartist<br/>
			                        </div>                    
			                    </div>
			                </li>
			                <li class="amazingcarousel-item">
			                    <div class="amazingcarousel-item-container">
			                        <div class="amazingcarousel-image">
			                            <img src="/ui/images/doctor-3.jpg"  alt="Ramesh Deshpande" />
			                        </div>
			                        <div class="amazingcarousel-title doctorProfile">
			                            <span class="doctorName">Ramesh Deshpande</span>
			                            <p>USC(UK),DMG(Dermalogist)</p>
			                        </div>
			                        <div class="amazingcarousel-description">
			                            Exp : 5 Years<br/>
			                            Speciality : Sychartist<br/>
			                        </div>                    
			                    </div>
			                </li>
			                <li class="amazingcarousel-item">
			                    <div class="amazingcarousel-item-container">
			                        <div class="amazingcarousel-image">
			                            <img src="/ui/images/doctor-4.jpg"  alt="Ramesh Deshpande" />
			                        </div>
			                        <div class="amazingcarousel-title doctorProfile">
			                            <span class="doctorName">Ramesh Deshpande</span>
			                            <p>USC(UK),DMG(Dermalogist)</p>
			                        </div>
			                        <div class="amazingcarousel-description">
			                            Exp : 5 Years<br/>
			                            Speciality : Sychartist<br/>
			                        </div>                    
			                    </div>
			                </li>
			                 <li class="amazingcarousel-item">
			                    <div class="amazingcarousel-item-container">
			                        <div class="amazingcarousel-image">
			                            <img src="/ui/images/doctor-4.jpg"  alt="Ramesh Deshpande" />
			                        </div>
			                        <div class="amazingcarousel-title doctorProfile">
			                            <span class="doctorName">Ramesh Deshpande</span>
			                            <p>USC(UK),DMG(Dermalogist)</p>
			                        </div>
			                        <div class="amazingcarousel-description">
			                            Exp : 5 Years<br/>
			                            Speciality : Sychartist<br/>
			                        </div>                    
			                    </div>
			                </li>

			            </ul>
			            <div class="amazingcarousel-prev"></div>
			            <div class="amazingcarousel-next"></div>
			        </div>
			        <div class="amazingcarousel-nav"></div>
			    </div>
			</div>
		</div>
	</div>
</section>
<!-- #Multiple Corousal Section Ends -->

<!--Get The She Doctor App Starts here -->
	<div class="container-fluid get_she_doctor_app">
			<div class="row">
				<div class="col-sm-6 text-center">
					<div class="phone_div wow fadeIn">
						<img src="/ui/images/logo.png"><!-- <br/><br/> -->
						<form action="javascript:void(0);">
							<input type="text" class="form-control" placeholder="Enter your mobile number"><br/>
							<button class="btn btn-warning" type="submit">Send App Link</button>
						</form>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="app_content_middle">
						<div class="app_content_style wow fadeIn">
							<h2>Get the She Doctr App</h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p><br/>
							<a href="javascript:void(0)"><img src="/ui/images/app_store.png"></a>
							<a href="javascript:void(0)"><img src="/ui/images/play_store.png"></a>
						</div>
					</div>
				</div>
			</div>
	</div>
<!-- #Get The She Doctor App Ends -->
<?php include('common/footer.php') ?>