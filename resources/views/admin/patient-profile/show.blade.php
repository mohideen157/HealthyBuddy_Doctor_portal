@extends('layouts.master')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/patient-profile.css') }}">
<style type="text/css">
textarea {
	width: 100%;
	border: 1px solid #b1b1b1;
}
</style>
@endsection

@section('content')
<div class="content-info">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 left-side-info">
				<span class="d-block mb-5">
					<img src="{{ asset($user->profile_image) }}" class="img-responsive w-100">
				</span>
				<div class="skills-block">
					<p class="d-flex">(my)aiBUD<span class="line"></span></p>
					<ul class="nav flex-coumn">
						<li class="w-100"><a href="">Health Heart Index: 5</a></li>
						<li class="w-100"><a href="">Steps : 5</a></li>
						<li class="w-100"><a href="">BPM : 324</a></li>
						<li class="w-100"><a href="">Oxygenation : {{ $user->patientHraData->hra['spo2'] }}</a></li>
						<li class="w-100"><a href="">Systolic : {{ $user->patientHraData->hra['systolic'] }}</a></li>
						<li class="w-100"><a href="">Dystolic : {{ $user->patientHraData->hra['diastolic'] }}</a></li>
						<li class="w-100"><a href="">Healthy Count : 27</a></li>
						<li class="w-100"><a href="">Blood Ref : 27</a></li>
					</ul>
					<p>&nbsp;</p>
				</div>

				<div class="skills-block">
					<p class="d-flex">ForMe<span class="line"></span></p>
					<ul class="nav flex-coumn">
						<li class="w-100"><a data-toggle="modal" id="open_diet_modal">Diet plan for You</a></li>
						<li class="w-100"><a data-toggle="modal" id="open_excercise_modal">Excercise plan</a></li>
					</ul>	<p>&nbsp;</p>
				</div>
				{{-- <div class="skills-block">
					<p class="d-flex">Upcoming<span class="line"></span></p>
					<ul class="nav flex-coumn">
						<li class="w-100"><a href="">UpComing Appoinment : 8:20:45</a></li>
						<li class="w-100"><a href="">UpComing Lab Test : 8:20:45</a></li>
						<li class="w-100"><a href="">UpComing Medication : 8:20:45</a></li>
					</ul><p>&nbsp;</p>
				</div> --}}
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 mb-4 pl-lg-5">
				<div class="information">
					<div class="content-header">
						<div class="row heading-content" style="display:flex;align-items:center;">
							<div class="col-md-9 col-xs-9">
								<h2>{{ ucfirst($user->patientProfile->first_name) }} {{ $user->patientProfile->last_name }}<span class="ml-4"><i class="fa fa-map-marker"></i>New York,NY</span>
								</h2>
							</div>
						</div>
					</div>
					<h5>{{ $user->patientProfile->occupation }}</h5>

					<p class="mb-4">BASIC INFORMATION</p>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Age:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->age }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Gender:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->gender }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>National ID:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->national_id }}</p>
						</div>
					</div>
					<br>
					<p class="mb-4">OTHER INFORMATION</p>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Height:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->height_feet }}.{{ $user->patientProfile->height_inch }} (in) | {{ $user->patientProfile->height_cm }} (cm)</p>

						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Weight:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->weight_kg }} (Kg) | {{ $user->patientProfile->weight_pounds }} (ibs)</p>

						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>BMI:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->bmi }}</p>

						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Blood Group:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->blood_group }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Occupation:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							<p class="mt-10">{{ $user->patientProfile->occupation }}</p>

						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-3 col-xs-6">
							<h6>Travel Frequent:</h6>
						</div>
						<div class="col-lg-10 col-md-9 col-xs-6">
							@php
								$national_travel =  Helper::patient_profile($user, 'travel-national', 'travel-interval');
								$international_travel = Helper::patient_profile($user, 'travel-international', 'travel-interval');
							@endphp
							<p class="mt-10">National - {{ $national_travel->unit }} ({{ $national_travel->value }}) | Inernational - {{ $international_travel->unit }} ({{ $international_travel->value }})</p>
						</div>
					</div>
					<br>
					<p class="mb-4">PWG & ECG</p>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-xs-6">
							<h6>PWG</h6>
							<img src="https://www.advfn.com/p.php?pid=staticchart&amp;s=EU:PWG&amp;p=5&amp;t=52"  style="width: 100%;">
						</div>
						<div class="col-lg-6 col-md-6 col-xs-6">
							<h6>ECG</h6>
							<img src="https://www.advfn.com/p.php?pid=staticchart&amp;s=EU:PWG&amp;p=5&amp;t=52"  style="width: 100%;">
						</div>
					</div>
					<br/>

					<p class="mb-4">DIET</p>

					<div class="row">
						<div class="col-md-6">
							<p>Diet Type?</p>
						</div>
						<div class="col-md-6">
							<p>{{ Helper::patient_profile($user, 'diet-type')->value }}</p>
						</div>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<!-----------------1--------->
						<div class="about-info tab-pane fade in active " id="pills-1" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-5 col-md-6 col-xs-8">
									<h6>1. Quantity of vegetables consuming everyday:</h6>
								</div>
								<div class="col-lg-7 col-md-6 col-xs-4">
									<p class="mt-10">{{ Helper::patient_profile($user, 'cup-of-vegetables')->value }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-6 col-xs-8">
									<h6>2. Cups of fruits having each day:</h6>
								</div>
								<div class="col-lg-7 col-md-6 col-xs-4">
									<p class="mt-10">{{ Helper::patient_profile($user, 'fruits')->value }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-6 col-xs-8">
									<h6>3. Quantity of cereals having each day:</h6>
								</div>
								<div class="col-lg-7 col-md-6 col-xs-4">
									<p class="mt-10">{{ Helper::patient_profile($user, 'cereals-qty')->value }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-6 col-xs-8">
									<h6>4. Quantity of fast-food having each day:</h6>
								</div>
								<div class="col-lg-7 col-md-6 col-xs-4">
									<p class="mt-10">{{ Helper::patient_profile($user, 'fast-food')->value }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-6 col-xs-8">
									<h6>5. Drinks taken in past week:</h6>
								</div>
								<div class="col-lg-7 col-md-6 col-xs-4">
									<p class="mt-10">{{ Helper::patient_profile($user, 'drinks')->value }}</p>
								</div>
							</div>
						</div>
					</div>
					<br>
					<p class="mb-4">OTHERS</p>


					<ul class="nav navbar-nav w-100 mb-4 about-container border-bottom" style="margin:0;">
						<li class="nav-item active">
							<a class="nav-link"  data-toggle="pill" href="#pills-11" role="tab" aria-controls="pills-11" aria-selected="false">Alcohol</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-22" role="tab" aria-controls="pills-22" aria-selected="false">Smoking</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-33" role="tab" aria-controls="pills-33" aria-selected="false">Diabetic</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-44" role="tab" aria-controls="pills-44" aria-selected="false">Heart Related aliment</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-55" role="tab" aria-controls="pills-55" aria-selected="false">TIA</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-66" role="tab" aria-controls="pills-66" aria-selected="false">Pre-Exsisting Diseases</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-77" role="tab" aria-controls="pills-77" aria-selected="false">Allergy</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#pills-88" role="tab" aria-controls="pills-88" aria-selected="false">Medication</a>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<!-----------------1--------->
						<div class="about-info tab-pane fade in active" id="pills-11" role="tabpanel" aria-labelledby="pills-home-tab">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Dosage</th>
										<th>Time</th>
										<th>Quantity</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Small</td>
										<td>Daily</td>
										<td>{{ Helper::patient_profile($user, 'alcohol', 'alcohol-small-dosage')->value }}</td>
									</tr>
									<tr>
										<td>Medium</td>
										<td>Weekly</td>
										<td>{{ Helper::patient_profile($user, 'alcohol', 'alcohol-medium-dosage')->value }}</td>
									</tr>
									<tr>
										<td>Large</td>
										<td>Monthly</td>
										<td>{{ Helper::patient_profile($user, 'alcohol', 'alcohol-large-dosage')->value }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-22" role="tabpanel" aria-labelledby="pills-home-tab">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>type</th>
										<th>Start Age</th>
										<th>End Age</th>
										<th>Quantity</th>
										<th>Time</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Smoke</td>
										<td>{{ Helper::patient_profile($user, 'smoking', 'start-age')->value }}</td>
										<td>{{ Helper::patient_profile($user, 'smoking', 'end-age')->value }}</td>
										<td>{{ Helper::patient_profile($user, 'smoking', 'dosage')->value }}</td>
										<td>{{ Helper::patient_profile($user, 'smoking', 'smoking-interval')->value }}</td>
									</tr>
									<tr>
										<td>Tobacco</td>
										<td></td>
										<td></td>
										<td>{{ Helper::patient_profile($user, 'smoking', 'tobacco')->value }}</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-33" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									<h6>Q. Diabetic Response:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'diebetic', 'medicine')->value }}</h6>
								</div>
							</div>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade " id="pills-44" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									<h6>Q. Coronary artery disease/ischemic heart disease:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'coronary-heart-ischemic-heart')->value }}</h6>
									<h6>Q. Suffered from Angina Pain:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'angina-pain')->value }}</h6>
									<h6>Q. Suffered From Heart Attack:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'heart-attack')->value }}</h6>
									<h6>Q. Treatment for abnormal ECG</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'ecg')->value }}</h6>
									<h6>Q. Undergone coronary Angiography:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'coronary-angiography')->value }}</h6>
									<h6>Q. Undergone bypass surgery:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'bypass-surgery')->value }}</h6>
									<h6>Q. Undergone stent placement:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'stent-placement')->value }}</h6>
									<h6>Q. Undergone any valve surgery/procedure:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'valve-surgery')->value }}</h6>
								</div>
							</div>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-55" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									<h6>Q. Under TIA treatment:</h6>
									<h6>Ans. {{ Helper::patient_profile($user, 'tia', 'regular-treatment')->value }}</h6>
								</div>
							</div>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-66" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									@php $diseases = Helper::patient_profile_collection($user, 'disease', 'disease-details') @endphp
									<ul>
										@foreach($diseases as $disease)
											<li class="w-100">{{ $disease->value }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-77" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									@php $allergies = Helper::patient_profile_collection($user, 'allergy', 'allergy-details') @endphp
									<ul>
										@foreach($allergies as $allergy)
											<li class="w-100">{{ $allergy->value }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>

						<!-----------------1--------->
						<div class="about-info tab-pane fade" id="pills-88" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-lg-12">
									@php $medications = Helper::patient_profile_collection($user, 'medication', 'medication-details') @endphp
									<ul>
										@foreach($medications as $medication)
											<li class="w-100">{{ $medication->value }}
												@php $extra_info = json_decode($medication->extra_info ) @endphp
												<ul>
													<li>{{ $extra_info->type }}</li>
													<li>{{ $extra_info->dosage }}</li>
													<li>{{ $extra_info->per_day }}</li>
												</ul>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>

					<br>
					<p class="mb-4">OTHER QUESTIONS</p>
					<div class="row">
						<div class="col-lg-5 col-md-6 col-xs-8">
							<h6>1. Time Spent doing vigorous intensity physical activities:</h6>
						</div>
						<div class="col-lg-7 col-md-6 col-xs-4">
							<p class="mt-10">{{ Helper::patient_profile($user, 'vigorus-physical-activity')->value }} </p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-6 col-xs-8">
							<h6>1. Time Spent doing moderate intensity physical activities:</h6>
						</div>
						<div class="col-lg-7 col-md-6 col-xs-4">
							<p class="mt-10">{{ Helper::patient_profile($user, 'moderate-physical-activity')->value }} </p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-6 col-xs-8">
							<h6>1. Time Spent doing light intensity physical activities:</h6>
						</div>
						<div class="col-lg-7 col-md-6 col-xs-4">
							<p class="mt-10">{{ Helper::patient_profile($user, 'light-physical-activity')->value }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-6 col-xs-8">
							<h6>1. Total Blood cholesterol:</h6>
						</div>
						<div class="col-lg-7 col-md-6 col-xs-4">
							<p class="mt-10">{{ Helper::patient_profile($user, 'blood-cholestrol')->value }}</p>
						</div>
					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="dietModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form name="dietForm" action="#" id="dietForm">
					<input type="hidden" name="user_id" value="{{ $user->id }}" id="user_id">
					<div class="form-group">
						<label for="diet_plan">Diet Plan:</label>
						<textarea name="diet_plan" id="diet_plan" rows="5"></textarea>
					</div>
					<div class="text-right">
						<button class="btn btn-primary" id="diet_plan_add" type="button">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- Modal For Excersise --}}
<div class="modal fade" id="excerciseModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="excerciseForm" name="excerciseForm">
					<div class="form-group">
						<label for="excercise_plan">Excercise Plan:</label>
						<textarea name="excercise_plan" id="excercise_plan" rows="5"></textarea>
					</div>
					<div class="text-right">
						<button class="btn btn-primary" id="excercise_plan_add" type="button">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript">
	// $('.navbar-nav .nav-item.disabled').find('a').removeAttr('data-toggle');

	$(document).ready(function(){

		//open Diet Modal
		$('#open_diet_modal').click(function(){
			$('#dietForm').trigger('reset');
			$('#dietModal').modal('show');
		});

		// Diet plan add for the user
		$('#diet_plan_add').click(function(){

			var diet_plan = $('#diet_plan').val();
			var user_id = $('#user_id').val();
			$.ajax({
				type: "POST",
				data:{'diet_plan': diet_plan, 'user_id': user_id},
				url: "{{ route('patient.diet.plan.store') }}",
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				success:function(res){
					if(res['status'])
					{
						toastr["success"]("Diet Plan", "Diet Plan Successfully Added");
					}
					else{
						toastr['error'](res['errors'])
					}
					$('#dietModal').modal('hide');
				}
			});

		});

		//open Excercise Modal
		$('#open_excercise_modal').click(function(){
			$('#excerciseForm').trigger('reset');
			$('#excerciseModal').modal('show');
		});

		// Excercise plan add for the user
		$('#excercise_plan_add').click(function(){

			var excercise_plan = $('#excercise_plan').val();
			var user_id = $('#user_id').val();

			$.ajax({
				type: "POST",
				data:{'excercise_plan': excercise_plan, 'user_id': user_id},
				url: "{{ route('patient.excercise.plan.store') }}",
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				success:function(res){
					if(res['status'])
					{
						toastr["success"]("Excercise Plan", "Excercise Plan Successfully Added");
					}
					else{
						console.log(res)
						toastr['error'](res['errors'])
					}
					$('#excerciseModal').modal('hide');
				}
			});
		});
	});

</script>
@endsection