<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>She Doctor</title>
	<link rel="stylesheet" type="text/css" href="/ui/plugins/bootstrap-3.3.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/ui/plugins/font-awesome-4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/ui/plugins/jquery-ui-1.11.4/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/ui/css/style.css">
	<link rel="stylesheet" type="text/css" href="/ui/css/vipin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.js"></script>
	<script src="/ui/js/app.js"></script>
</head>
<body ng-app="myApp" ng-controller="PatientPeofileCtrl">
<!-- #Header Section Starts -->
	<header >
		<div class="container-fluid">
			<div class="container-she row">
				<div class="col-sm-7 header_logo">
					<a href="index.php"><img src="/ui/images/logo-small.png"></a>
				</div>

				<div class="col-sm-5">
					<div class="col-xs-5"><a class="btn btn-large consult-doctor" href="#doctor-profile" role="tab" data-toggle="tab" aria-controls="doctor-profile">Consult Doctor</a></div>
					<div class="col-xs-2">
						<div class="dropdown notification-dropdown">
							<img src="images/patient_notification.png" class="img-responsive dropdown-toggle" data-toggle="dropdown">
							<ul class="dropdown-menu">
								<li>
									<div class="row">
										<div class="col-sm-2">
											<img src="images/doctor-header.png">
										</div>
										<div class="col-sm-10">
											<p>Triveni has appointment</p>
											<p class="commonColor">You have Appointmnet on 13/Apr/2016</p>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-sm-2">
											<img src="images/doctor-header.png">
										</div>
										<div class="col-sm-10">
											<p>Triveni has appointment</p>
											<p class="commonColor">You have Appointmnet on 13/Apr/2016</p>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-sm-2">
											<img src="images/doctor-header.png">
										</div>
										<div class="col-sm-10">
											<p>Triveni has appointment</p>
											<p class="commonColor">You have Appointmnet on 13/Apr/2016</p>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-sm-2">
											<img src="images/doctor-header.png">
										</div>
										<div class="col-sm-10">
											<p>Triveni has appointment</p>
											<p class="commonColor">You have Appointmnet on 13/Apr/2016</p>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-sm-2">
											<img src="images/doctor-header.png">
										</div>
										<div class="col-sm-10">
											<p>Triveni has appointment</p>
											<p class="commonColor">You have Appointmnet on 13/Apr/2016</p>
										</div>
									</div>
								</li>
								<li class="text-center">See All</li>
							</ul>
						</div>
					</div>
					<div class="col-xs-5  dropdown doctor-dropdown">
						<span class="doctor-name">Chandrakanth</span><img class="img-circle patient-profile dropdown-toggle" src="images/patient-profile.png" data-toggle="dropdown">
						<ul class="dropdown-menu doctor-menu-list">
					    <li>
					    	<a href="javascript:void(0);">
					    		<h4>Chandrakanth</h4>
					    	</a>
					    </li>
					    <li role="presentation">
					    	<a ng-click="tab(4)" ng-class="{active : tabIndex === 4 }"><p class="commonColor">MyProfile</p></a>
					    </li>
					    <li>
					    	<a href="javascript:void(0);"><p class="commonColor">Logout</p></a>
					    </li>
					  </ul>
					</div>
				</div>
			</div>
		</div>
	</header>
<!-- #Header Section Ends -->