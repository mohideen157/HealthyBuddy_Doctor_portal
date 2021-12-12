@extends(App\User::isTenant() ? 'tenant.component._master' : (App\User::isOrganisation() ? 'organisation.component._master' : (App\User::isDoctor() ? 'doctor.component._master' : 'layouts.master')))

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/patient-profile.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/hello.week.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/hello.week.theme.min.css') }}">
	<style type="text/css">
		textarea {
		width: 100%;
		border: 1px solid #b1b1b1;
		}
		.modal-wrapper{

    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 100;
    background-color: rgba(0, 0, 0, 0.2);
    display: none;

		}
.modal-wrapper .content {
    background-color: white;
    max-width: 500px;
    position: relative;
    margin: 10vh auto;
}
.remove{
	padding:15px 15px 0 0;
	font-size: 20px;
	cursor: pointer;
}
.modal-wrapper .modal-wrap {
    padding: 20px 40px 30px 40px;
    max-height: 80vh;
    overflow-y: auto;
    overflow-x: hidden;
}
.loader{
    visibility: hidden;
    display: flex;
    margin: auto;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
@endsection

@php
	if(App\User::isTenant()){
		$additional_info_route = 'tenant.patient.profile.additional-info.history';
		$nutrition_history_route = 'tenant.patient.profile.nutrition.history';
		$ecg_ppg_history_route = 'tenant.patient.profile.ecg.ppg.history';
		$bp_history_route = 'tenant.patient.profile.bp.history';
		$hr_history_route = 'tenant.patient.profile.hr.history';
		$arrhythmia_history_route = 'tenant.patient.profile.arrhythmia.history';
		$arterial_age_history_route = 'tenant.patient.profile.arterial.history';
		$afib_history_route = 'tenant.patient.profile.afib.history';
		$rpwv_history_route = 'tenant.patient.profile.rpwv.history';
		$calories_history_route = 'tenant.patient.profile.calories.history';

	}
	else{
		$additional_info_route = 'common.patient.profile.additional-info.history';
		$nutrition_history_route = 'common.patient.profile.nutrition.history';
		$ecg_ppg_history_route = 'common.patient.profile.ecg.ppg.history';
		$bp_history_route = 'common.patient.profile.bp.history';
		$hr_history_route = 'common.patient.profile.hr.history';
		$arrhythmia_history_route = 'common.patient.profile.arrhythmia.history';
		$arterial_age_history_route = 'common.patient.profile.arterial.history';
		$afib_history_route = 'common.patient.profile.afib.history';
		$rpwv_history_route = 'common.patient.profile.rpwv.history';
		$calories_history_route = 'common.patient.profile.calories.history';
	}
@endphp

@section('content')
<div  id="information-modal">
	<ul class="nav nav-pills list-navigation">
		<li class="active">
			<a data-toggle="tab" href="#profile" aria-expanded="true">Profile</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#addition-info" aria-expanded="false">Additional Info</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#bp" aria-expanded="false">BP</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#hr" aria-expanded="false">HR</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#calories" aria-expanded="false">Calories</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#rpwv" aria-expanded="false">rPWV</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#ecg" aria-expanded="false">ECG & PPG</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#arrhythmia" aria-expanded="false">Arrhythmia</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#arterial" aria-expanded="false">Arterial Age</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#afib" aria-expanded="false">AFIB</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#nutrition" aria-expanded="false">Nutrition</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#hhi" aria-expanded="false">HHI</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#sleep" aria-expanded="false">SLEEP</a>
		</li>
		<li class="">
		
			<a data-toggle="tab" href="#padometer" aria-expanded="false">PEDOMETER</a>
		</li>
		@if(App\User::isDoctor())
			<li class="">
				<a data-toggle="tab" href="#advice" aria-expanded="false">Advice</a>
			</li>
		@endif
	</ul>
	<div class="tab-content">
		<div id="profile" class="tab-pane fade in active">
			<div class="text-right">
				<span class="hra-percent">{{ Helper::patient_profile_percentage($user->id) }}%</span>
			</div>
			<div class="row">
				<div class="col-md-2 logo-profile">
					<a href="#" data-toggle="modal" data-target="#information-modal"><img src="{{ asset($user->profile_image) }}"></a>
				</div>
				<div class="col-md-10 table-responsive">
					<table class="table-bordered profile" width="100%">
						<tbody>
							<tr>
								<th colspan="5" class="title-head">Basic Info</th>
								<th class="title-head"></th>
							</tr>
							<tr>
								<th>Name</th>
								<td id="name">{{ ucfirst($user->name) }}</td>
								<th>Age</th>
								<td id="age">@if($user->patientProfile) {{ Helper::age($user->patientProfile->dob) ?? '-'}} @endif</td>
								<th>Gender</th>
								<td id="gender">@if($user->patientProfile){{ $user->patientProfile->gender ?? '-' }}@endif</td>
							</tr>
							<tr>
								<th>Height(cm)</th>
								<td id="height">@if($user->patientProfile) {{ ($user->patientProfile->height_cm) ?? '-'}} @endif</td>
								<th>Weight(Kg)</th>
								<td id="weight">@if($user->patientProfile) {{ ($user->patientProfile->weight_kg) ?? '-' }} @endif</td>
								<th>BMI</th>
								<td id="bmi">@if($user->patientProfile) {{ $user->patientProfile->bmi ?? '-' }} @endif</td>
							</tr>
							<tr>
								<th>Blood Group</th>
								<td id="blood-group">@if($user->patientProfile) {{ $user->patientProfile->blood_group ?? '' }} @endif</td>
								<th >Registration date</th>
								<td id="registration_date">{{ Helper::date_format($user->created_at) }}</td>
								<th>Aadhar No or National Id</th>
								<td id="aadhar">@if($user->patientProfile) {{ $user->patientProfile->national_id ?? '' }} @endif</td>
							</tr>
							<tr>
								<th >Email</th>
								<td id="email">{{ $user->email ?? '-' }}</td>
								<th>Phone</th>
								<td id="phone">+{{ $user->mobile_no ?? '-' }}</td>
								<th>Occupation</th>
								<td id="occupation">@if($user->patientProfile) {{ $user->patientProfile->occupation ?? '' }} @endif</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div id="addition-info" class="tab-pane fade">

			<div class="text-right">
				<span class="hra-percent">{{ Helper::patientHealthProfile($user->id) }}%</span>
			</div>
			<div class="row">
				@include('common.patient-profile.additional-info', ['user' => $user])
			</div>
			<a class="history-link" id="view-additional-history">View History</a>
		    <div class="modal-wrapper" id="additional-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="additional-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="bp" class="tab-pane fade">
			<div id="bp-row">
				<canvas id="bp-chart" width="800" height="260"></canvas>
			</div>
			<a class="history-link" id="view-bp-history">View History</a>
		    <div class="modal-wrapper" id="bp-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="bp-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="hr" class="tab-pane fade">
			<div id="hr-row">
				<canvas id="hr-chart" width="800" height="260"></canvas>
			</div>
			<a class="history-link" id="view-hr-history">View History</a>
		    <div class="modal-wrapper" id="hr-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="hr-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>

		<div id="calories" class="tab-pane fade">
			<div id="calories-row">
				<canvas id="calories-chart" width="800" height="260"></canvas>
			</div>
			<a class="history-link" id="view-calories-history">View History</a>
		    <div class="modal-wrapper" id="calories-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="calories-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>

		<div id="rpwv" class="tab-pane fade">
			<div id="rpwv-row">
				<canvas id="rpwv-chart" width="800" height="260"></canvas>
			</div>	
			<a class="history-link" id="view-rpwv-history">View History</a>
		    <div class="modal-wrapper" id="rpwv-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="rpwv-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="ecg" class="tab-pane fade">
			<div class="row">
				@include('common.patient-profile.ecg-ppg',['synched_ids' => $synched_ids])
			</div>

			<a class="history-link" id="view-ecg-history">View History</a>
		    <div class="modal-wrapper" id="ecg-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="ecg-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="arrhythmia" class="tab-pane fade">
			<div id="arrhythmia-row">
				<canvas id="arrhythmia-chart" width="800" height="260"></canvas>
			</div>
			<a class="history-link" id="view-arrhythmia-history">View History</a>
		    <div class="modal-wrapper" id="arrhythmia-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="arrhythmia-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="hhi" class="tab-pane fade">
			<div id="hhi-row">
				<canvas id="hhi-chart" width="800" height="260"></canvas>
			</div>
			 
		    <div class="modal-wrapper" id="hhi-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="hhi-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>

		<div id="padometer" class="tab-pane fade">
		 
						<div class="row">
				@include('common.patient-profile.padometer-info', ['user' => $user])
			</div>
		</div>

		<div id="sleep" class="tab-pane fade">
		<table class="table-bordered profile" width="100%">
						<tbody>
							<tr>
								<th colspan="2" class="title-head">Sleep Info</th>
								 
							</tr>
							<tr>
								<th>Sleep hours</th>
								<td id="name">{{$Sleep->sleep_houre ?? ''}}</td>
								 
							</tr>
							<tr>
								<th>Light Sleep</th>
								<td id="height"> {{$Sleep->light_sleep ?? ''}} </td>
								 
							</tr>
							<tr>
								<th>Deep Sleep</th>
								<td id="blood-group"> {{$Sleep->deep_slip ?? ''}} </td>
								 
							<tr>
								<th>Awake</th>
								<td id="email">{{$Sleep->awake ?? ''}} </td>
								 
							</tr>
							<tr>
								<th>Date</th>
								<td id="email">{{$Sleep->date ?? ''}} </td>
								 
							</tr>
						</tbody>
					</table>
		</div>
		<div id="arterial" class="tab-pane fade">
			<div id="arterial-row">
				<canvas id="arterial-chart" width="800" height="260"></canvas>
			</div>	
			<a class="history-link" id="view-arterial-history">View History</a>
		    <div class="modal-wrapper" id="arterial-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="arterial-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="afib" class="tab-pane fade">
			<div id="afib-row">
				<canvas id="afib-chart" width="800" height="260"></canvas>
			</div>
			<a class="history-link" id="view-afib-history">View History</a>
		    <div class="modal-wrapper" id="afib-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="afib-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="nutrition" class="tab-pane fade">
			<div id="nutrition-row">
				@include('common.patient-profile.nutrition',['nutritions' => $nutritions])
			</div>
			<a class="history-link" id="view-nutrition-history">View History</a>
		    <div class="modal-wrapper" id="nutrition-history">
				<div class="content">
					<span class="d-block text-right remove"><i class="fa fa-times"></i></span>
					<div class="modal-wrap">
						<div id="nutrition-calendar" class="hello-week"></div>
					</div>
				</div>
			</div>
		</div>

		@if(App\User::isDoctor())
			<div id="advice" class="tab-pane fade">
				<form id="advice-form">
					<div class="row">
						<div class="col-md-4 select-style" >
							<select id="select-option" name="type">
								<option value="1" selected>Diet Advice</option>
								<option value="2">Excercise Advice</option>
							</select>
						</div>
						<input type="hidden" name="patient_id" value="{{ $user->id }}">
						<div class="col-md-6 form-group">
							<textarea rows="4" name="description" id="description"></textarea>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn" id="advice-form-submit" style="background: #4b5d6e;color: white;">Submit</button>
						</div>
					</div>
				</form>
			</div>
		@endif

		<div class="loader">
			<img src="{{ asset('images/loader.gif') }}" class="img-responsive">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/hello.week.min.js') }}"></script>

<script type="text/javascript">
	// Graph for Bp
	get_bp_graph({!! json_encode($bp) !!})

	function get_bp_graph(bp){

		$("#bp-chart").remove()
		$("#bp-row").html('<canvas id="bp-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("bp-chart"), {
		  	type: 'line',
		  	data: {
		        labels: bp[0][2],
		        datasets: [{
		            data: bp[0][0],
		            label: "SYS",
		            backgroundColor: "#3e95cd",
		            fill: false
		        }, {
		            data: bp[0][1],
		            label: "DIA",
		            backgroundColor: "#8e5ea2",
		            fill: false
		        }, {
		            data: bp[0][3],
		            label: "SYS AVG",
					backgroundColor: "red",
					pointBorderWidth: 1,
					pointRadius: 4,
					borderColor: "lightblue",
					borderWidth: 5,
		            fill: false
		        },
				{
					data: bp[0][4],
		            label: "DIA AVG",
					backgroundColor: "red",
					pointBorderWidth: 1,
					pointRadius: 4,
					borderColor: "lightblue",
					borderWidth: 5,
		            fill: false
				}
		        ]
		    }
		});
	}

	// Graph for Bp
	get_calories_graph({!! json_encode($calories) !!})

	function get_calories_graph(calories){

		$("#calories-chart").remove()
		$("#calories-row").html('<canvas id="calories-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("calories-chart"), {
		  	type: 'bar',
		  	data: {
		        labels: calories[0][0],
		        datasets: [{
		            data: calories[0][3],
		            label: "Target Calories",
		            backgroundColor: "#54ab53",
		            fill: false
		        },
		        {
		            data: calories[0][1],
		            label: "Calories Gained",
		            backgroundColor: "#3e95cd",
		            fill: false
		        }, {
		            data: calories[0][2],
		            label: "Calories Burned",
		            backgroundColor: "#8e5ea2",
		            fill: false
		        }]
		    }
		});
	}

	// Arrhythmia Chart
	get_arrhythmia_graph({!! json_encode($arrhythmia) !!})

	function get_arrhythmia_graph(arrhythmia){

		$("#arrhythmia-chart").remove()
		$("#arrhythmia-row").html('<canvas id="arrhythmia-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("arrhythmia-chart"), {
		    type: 'bar',
		    data: {
		     	labels: arrhythmia[0][1],
		      	datasets: [
		      	{
		          	label: "Arrhythmia",
		          	backgroundColor: "#2a3f54",
		          	data: arrhythmia[0][0],
		          	fill: false
		      	},
				  {
		          	label: "Arrhythmia Average",
		          	backgroundColor: "lightblue",
		          	data: arrhythmia[0][2],
		          	fill: false
		      	}
		    ]
			},
			options: {
			    scales: {
				    xAxes: [{
				        barPercentage: 0.3
				    }],
				    yAxes:[{
				        ticks: {
				           beginAtZero: true,
				           steps: 1,
				           stepValue: 1,
				           max: 4
				       }
				   }]
				}
			}
		});
	}
   // hii Chart
   
	get_hhi_graph();

  function get_hhi_graph(){

	 
	 

	new Chart(document.getElementById("hhi-chart"), {
		type: 'line',
		data: {
			 labels: <?php echo json_encode(@$HHI['date']); ?>,
			  datasets: [
			  {
				  label: "HHI",
				  backgroundColor: "#2a3f54",
				  data: <?php echo json_encode(@$HHI['hhi']); ?>,
				  fill: false
			  },
			  {
				  label: "HHI Average",
				  backgroundColor: "lightblue",
				  data: <?php echo json_encode(@$HHI['avg']); ?>,
				  fill: false
			  }
		]
		},
		options: {
        responsive: true,
        showTooltips: true,
		scales: {
			 xAxes: [{
				        barPercentage: 0.3
				    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true,
					steps: 1,
				    stepValue: 1,
                }
            }]
        }
    }
	});
}
// Arterial Chart
	get_arterial_age({!! json_encode($arterial_age) !!})

	function get_arterial_age(arterial_age){

		$("#arterial-chart").remove()
		$("#arterial-row").html('<canvas id="arterial-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("arterial-chart"), {
		    type: 'bar',
		    data: {
		      labels: arterial_age[0][1],
		      datasets: [
				{
					label: "Arterial Age",
					backgroundColor: "#3cba9f",
					data: arterial_age[0][0],
					fill: false
				},
				{
					label: "Arterial Age Average",
					backgroundColor: "lightblue",
					data: arterial_age[0][2],
					fill: false
				}
		      ]
		  	},
		 	 options: {
			    scales: {
			      xAxes: [{
			        barPercentage: 0.3
			    }],
			}
			}
		});
	}

	// Afib Chart
	get_afib({!! json_encode($afib) !!})

	function get_afib(afib){

		$("#afib-chart").remove()
		$("#afib-row").html('<canvas id="afib-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("afib-chart"), {
			type: 'bar',
			    data: {
			      labels: afib[0][1],
			      datasets: [
					{
						label: "Afib",
						backgroundColor: "#3cba9f",
						data: afib[0][0],
						fill: false
					},
					{
						label: "Afib Average",
						backgroundColor: "lightblue",
						data: afib[0][2],
						fill: false
					}
			      ]
			  },
			  options: {
				    scales: {
				      xAxes: [{
				        barPercentage: 0.3
				    }],
				}
			}
		});
	}

	//rpwv Chart

	get_rpwv({!! json_encode($rpwv) !!})

	function get_rpwv(rpwv){

		$("#rpwv-chart").remove()
		$("#rpwv-row").html('<canvas id="rpwv-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("rpwv-chart"), {
		  	type: 'line',
		  	data: {
		        labels: rpwv[0][1],
		        datasets: [
					{
						data: rpwv[0][0],
						label: "rPWV",
						backgroundColor: "#3e95cd",
						fill: false
					},
					{
						data: rpwv[0][2],
						label: "rPWV AVG",
						backgroundColor: "red",
						borderColor: "lightblue",
						pointBorderWidth: 1,
						pointRadius: 4,
						borderColor: "lightblue",
						borderWidth: 5,
						fill: false
					}
		        ]
		    }
		});
	}

	// Hr Graph
	get_hr({!! json_encode($hr) !!})

	function get_hr(hr){

		$("#hr-chart").remove()
		$("#hr-row").html('<canvas id="hr-chart" width="800" height="260"></canvas>')

		new Chart(document.getElementById("hr-chart"), {
		  	type: 'line',
		  	data: {
		        labels: hr[0][1],
		        datasets: [
					{
						data: hr[0][0],
						label: "HR",
						backgroundColor: "#3e95cd",
						fill: false
					},
					{
						data: hr[0][2],
						label: "HR AVG",
						backgroundColor: "red",
						pointBorderWidth: 1,
						pointRadius: 4,
						borderColor: "lightblue",
						borderWidth: 5,
						borderColor: "lightblue",
						fill: false
					}
		        ]
		    }
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$(".modal-wrapper .remove i").click(function(event) {
			$(".modal-wrapper").fadeOut(200);
		});
		//Initialize Calender Modal
		$('#view-additional-history').click(function(event) {
            $('#additional-history').fadeIn(400);
        });

        $('#view-ecg-history').click(function(event) {
            $('#ecg-history').fadeIn(400);
        });

        $('#view-nutrition-history').click(function(event) {
            $('#nutrition-history').fadeIn(400);
        });

        $('#view-bp-history').click(function(event) {
            $('#bp-history').fadeIn(400);
        });

        $('#view-hr-history').click(function(event) {
            $('#hr-history').fadeIn(400);
        });

        $('#view-calories-history').click(function(event) {
            $('#calories-history').fadeIn(400);
        });

        $('#view-arrhythmia-history').click(function(event) {
            $('#arrhythmia-history').fadeIn(400);
        });

        $('#view-arterial-history').click(function(event) {
            $('#arterial-history').fadeIn(400);
        });

        $('#view-afib-history').click(function(event) {
            $('#afib-history').fadeIn(400);
        });

        $('#view-rpwv-history').click(function(event) {
            $('#rpwv-history').fadeIn(400);
        });

		//Js to Submit Advice(Diet and Excerise) to Patient
		$('#advice-form-submit').click(function(){
			var data = $('#advice-form').serialize();

			$('#description').val('');
			$.ajax({
				type:'POST',
				data:data,
				headers:{
					'X-CSRF-TOKEN' : "{{ csrf_token() }}"
				},
				url:"{{ route('doctor.patient.advise.store') }}",
				success:function(res){
					if(res['status']){
						toastr['success']('Advice Successfully Submitted');
					}
					else if(res['errors'] && res['status'] == false){
						$.each(res['errors'], function(key, value){
							toastr['error'](value);
						});
					}
					else{
						toastr['error']('Something Went Wrong')
					}
				}
			});
		});

		// Additional Info
		var additionalInfoCalendar = new HelloWeek({
		    selector: '#additional-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_health_profile_changed_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = additionalInfoCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#additional-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($additional_info_route) }}",
					success:function(res){
						$(".loader").css("visibility","hidden");
						$('#addition-info .row').empty();
						$('#addition-info .row').html(res);
					}
				});
    		}
		});

		//BP History
		var bpCalendar = new HelloWeek({
		    selector: '#bp-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = bpCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#bp-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($bp_history_route) }}",
					success:function(res){
						$('#bp-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_bp_graph(res) // Plot Graph
					}
				});
    		}
		});


		//HR History
		var hrCalendar = new HelloWeek({
		    selector: '#hr-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = hrCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#hr-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($hr_history_route) }}",
					success:function(res){
						$('#hr-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_hr(res) // Plot Graph
					}
				});
    		}
		});


		//Calories History
		var caloriesCalendar = new HelloWeek({
			selector: '#calories-calendar',
			lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($nutrition_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
		    onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = caloriesCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#calories-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($calories_history_route) }}",
					success:function(res){
						$(".loader").css("visibility","hidden");
						get_calories_graph(res) // Plot Graph
					}
				});
    		}
		});

		//rPWV History
		var rpwvCalendar = new HelloWeek({
		    selector: '#rpwv-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = rpwvCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#rpwv-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($rpwv_history_route) }}",
					success:function(res){
						$('#rpwv-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_rpwv(res)
					}
				});
    		}
		});

		// Ecg and PPG History
		var ecgCalendar = new HelloWeek({
		    selector: '#ecg-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = ecgCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#ecg-history').fadeOut();
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($ecg_ppg_history_route) }}",
					success:function(res){
						$(".loader").css("visibility","hidden");
						$('#ecg .row').empty();
						$('#ecg .row').html(res);
					}
				});
    		}
		});

		//arrhythmia Age History
		var arrhythmiaCalendar = new HelloWeek({
		    selector: '#arrhythmia-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = arrhythmiaCalendar.getDays()[0];

				var user_id = {{ $user->id }};
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($arrhythmia_history_route) }}",
					success:function(res){
						$('#arrhythmia-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_arrhythmia_graph(res)
					}
				});
    		}
		});

		//Arterial Age History
		var arterialCalendar = new HelloWeek({
		    selector: '#arterial-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = arterialCalendar.getDays()[0];
				var user_id = {{ $user->id }};
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($arterial_age_history_route) }}",
					success:function(res){
						$('#arterial-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_arterial_age(res)
					}
				});
    		}
		});

		//Afib History
		var afibCalendar = new HelloWeek({
		    selector: '#afib-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($patient_history_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = afibCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#afib-history').fadeOut();

    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($afib_history_route) }}",
					success:function(res){
						$('#afib-history').fadeOut();
						$(".loader").css("visibility","hidden");
						get_afib(res)
					}
				});
    		}
		});


		// Nutrition History
		var nutritionCalendar = new HelloWeek({
		    selector: '#nutrition-calendar',
		    lang: '/en',
    		langFolder: '{{ asset('dist/langs') }}',
    		format: 'YYYY-MM-DD',
		    daysHighlight: [
				{
					days: {!! json_encode($nutrition_change_date) !!},
					backgroundColor: '#f08080',
				}
		    ],
    		onSelect: () => {
            	$(".loader").css("visibility","visible");
    			var date = nutritionCalendar.getDays()[0];
				var user_id = {{ $user->id }};
				$('#nutrition-history').fadeOut
    			$.ajax({
					type: 'GET',
					data: {date, user_id},
					url:"{{ route($nutrition_history_route) }}",
					success:function(res){
						$('#nutrition-history').fadeOut();
						$(".loader").css("visibility","hidden");
						$('#nutrition-row').empty();
						$('#nutrition-row').html(res);
					}
				});
    		}
		});
	});
</script>

@endsection

