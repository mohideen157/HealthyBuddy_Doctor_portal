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


@section('content')
<div  id="information-modal">
	
	<div class="tab-content">
		<div id="profile" class="tab-pane fade in active">
			<div class="text-right">
				<!--<span class="hra-percent">{{ Helper::patient_profile_percentage($user->id) }}%</span>-->
                            <a href="{{ route('admin.medcheck') }}" style="margin-left: 220px;">
						    <button class="btn btn-primary">Back</button> 
					        </a>
					        <a href="{{ route('admin.medcheck.store', $user->id) }}">
					        <button type="submit" class="btn btn-primary" style="margin-left: 20px;" >Histroy</button>
					        </a>
			</div>
			<div class="row">
				<div class="col-md-2 logo-profile">
					<a href="#" data-toggle="modal" data-target="#information-modal"><img src="{{ asset($user->profile_image) }}"></a>
				</div>
				<div class="col-md-10 table-responsive">
					<table class="table-bordered profile" width="100%">
						<tbody>
							<tr>
								<th colspan="6" class="title-head">Device Latest Reading</th>								
							</tr>
							<tr>
								<th>Blood Pressure(mmHg)</th>
								<td id="blood_pressure">{{ $bp->bp ?? '-' }}</td>
								<th>Blood Gulcose(mg/dL)</th>
								<td id="blood_gulcose">{{ $bgm->high_blood ?? '-' }}</td>
								<th>Heart Rate(BPM)</th>
								<td id="heart_rate">{{ $hr->hr ?? '-' }}</td>
							</tr>
							<tr>
								<th>Spo2</th>
								<td id="spo2">{{ $spo2->spo2_value ?? '-' }}</td>
								<th>Body Temparature(°F)</th>
								<td id="blood_temparature">{{ $temperature->ptt_value ?? '-' }}</td>								
								<th>BMI</th>
								<td id="bmi">{{ $weightscale->bmi_weight ?? '-' }}</td>
							</tr>
						</tbody>
					</table>
				</div>                    
						
			</div>            
		</div>
		

		<div class="loader">
			<img src="{{ asset('images/loader.gif') }}" class="img-responsive">
		</div>
	</div>
</div>
@endsection