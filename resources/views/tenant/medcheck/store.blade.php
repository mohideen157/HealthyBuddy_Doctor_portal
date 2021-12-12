@extends('tenant.component._master')

@section('content')
<div id="information-modal">
    <div class="tab-content">
		<div id="profile" class="tab-pane fade in active">
			<div class="text-right">
				
                            <a href="{{ route('tenant.medcheck') }}" style="margin-left: 220px;">
						    <button class="btn btn-primary">Back</button> 
					        </a>
					        <a href="{{ route('tenant.medcheck.store', $user->id) }}">
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
								<th>Body Temparature(°C)</th>
								<td id="blood_temparature">{{ $temperature->ptt_value ?? '-' }}</td>								
								<th>BMI</th>
								<td id="bmi">{{ $weightscale->bmi_weight ?? '-' }}</td>
							</tr>
						</tbody>
					</table>
				</div>                    
						
			</div>            
		</div>

		<!--<div class="loader">
			<img src="{{ asset('images/loader.gif') }}" class="img-responsive">
		</div>-->
	</div>
	</br>
<!--History Readings Collapse Span-->
	<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Blood Pressure Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse1" class="panel-body collapse">			    
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Blood Pressure(mmHg)</th>
							<th>Reading Time</th>
						 </thead>
						<tbody>
							@foreach($bp1 as $user)
							<tr>
							<td>{{ $user->bp ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>				
		    </div>
		</div>
	</div>
</div>


<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
		<div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Blood Glucose Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse2" class="panel-body collapse">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Blood Glucose(mg/dL)</th>
							<th>Reading Time</th>
						</thead>
						<tbody>
							@foreach($bgm1 as $user)
							<tr>
							<td>{{ $user->high_blood ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				
		    </div>
		</div>
	</div>
</div>



<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
		    <div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Heart Rate Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse3" class="panel-body collapse">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Heart Rate(BPM)</th>
							<th>Qrs</th>
							<th>Qc</th>
							<th>Qtc</th>
							<th>Reading Time</th>
						</thead>
						<tbody>
							@foreach($hr1 as $user)
							<tr>
							<td>{{ $user->hr ?? '' }}</td>
							<td>{{ $user->qrs ?? '' }}</td>
							<td>{{ $user->qt ?? '' }}</td>
							<td>{{ $user->qtc ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>				
		    </div>
		</div>
	</div>
</div>


<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
			<div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">SPO2 Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse4" class="panel-body collapse">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Spo2</th>
							<th>pr</th>
							<th>pi</th>
							<th>Reading Time</th>
						</thead>
						<tbody>
							@foreach($spo21 as $user)
							<tr>
							<td>{{ $user->spo2_value ?? '' }}</td>
							<td>{{ $user->pr ?? '' }}</td>
							<td>{{ $user->pi ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
		    </div>
		</div>
	</div>
</div>



<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
			<div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Body Temperature Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse5" class="panel-body collapse">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Temperature(°C)</th>
							<th>Reading Time</th>
						</thead>
						<tbody>
							@foreach($temperature1 as $user)
							<tr>
							<td>{{ $user->ptt_value ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>				
		    </div>
		</div>
	</div>
</div>



<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
			<div class="panel-heading">
			   <h4 class="panel-title">
			   <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">BMI Readings
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-down"></i>
			   </span>
			   </a>
			   </h4>
			</div>
			<div id="collapse6" class="panel-body collapse">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>Weight(Kg)</th>
							<th>BMI</th>
							<th>Fat Percentage</th>
							<th>Muscle Percentage</th>
							<th>Water Percentage</th>
							<th>BMR</th>
							<th>Reading Time</th>
						</thead>
						<tbody>
							@foreach($weightscale1 as $user)
							<tr>
							<td>{{ $user->bmi_weight ?? '' }}</td>
							<td>{{ $user->bmi ?? '' }}</td>
							<td>{{ $user->fat_per ?? '' }}</td>
							<td>{{ $user->muscle_per ?? '' }}</td>
							<td>{{ $user->water_per ?? '' }}</td>
							<td>{{ $user->bmr ?? '' }}</td>
							<td>{{ $user->device_reading_time ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>				
		    </div>
		</div>
	</div>
</div>









</div>
@endsection

@section('script')
@endsection