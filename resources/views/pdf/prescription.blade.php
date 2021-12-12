<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="doctorPrescription">
	<table class="header" style="width:100%">
		<tr>
			<td width="25%"><img src="{{ public_path('images/logo-small.png') }}"></td>
			<td width="25%"></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		<tr>
			<td width="25%">
				<p class="commonColor">Doctor Name</p>
				<h4>{{ $doctor['name'] }}</h4>
			</td>
			<td width="25%">
				<p class="commonColor">Patient Name</p>
				<h4>{{ $patient['name'] }}</h4>
			</td>
			<td width="25%">
				<p class="commonColor">Doctor Speciality</p>
				<h4>{{ $doctor['specialty'] }}</h4>
			</td>
			<td width="25%">
				<p class="commonColor">Patient ID</p>
				<h4>{{ $patient['shedct_id'] }}</h4>
			</td>
		</tr>
		<tr>
			<td width="25%">Date&#58;{{ $date }}</td>
			<td width="25%"></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
	</table>
	<table class="report" style="width:100%">
		<tr>
			<td><p class="commonColor">Diagnosis Report</p></td>
		</tr>
		<tr>
			<td><p>{{ $report }}</p></td>
		</tr>
		
		@if($next_visit)
		<tr>
			<td><p class="commonColor">Next Visit</p></td>
		</tr>		
		<tr>
			<td><p>{{ $next_visit }}</p></td>
		</tr>
		@endif
	</table>
	@if (!empty($lab_tests))
	<table class="lab-test" style="width:100%">
		<tr>
			<td><p class="commonColor">Lab Tests</p></td>
		</tr>
		<tr>
			<td>
				<ul class="list-unstyled medicineAndTest">
					@foreach ($lab_tests as $test) 
						<li>{{ $test }}</li>
					@endforeach
				</ul>
			</td>
		</tr>
	</table>
	@endif
	@if (!empty($medicines))
	<table class="medicines" style="width:100%">
		<!-- <tr>
			<td><p class="commonColor">Medicines</p></td>
		</tr> -->
		<tr>
			<td>
				<table class="table table-bordered medicineTime" style="width:100%">
					<thead>
						<tr>
							<th width="14%">Medicine Name</th>
							<th width="14%">Medicine Type</th>
							<th width="14%">Morning</th>
							<th width="14%">Afternoon</th>
							<th width="14%">Evening</th>
							<th width="14%">Night</th>
							<th width="16%">Add Note</th>
						</tr>
					</thead>
					@foreach($medicines as $med)
						<tr>
							<td width="14%">{{ $med['name'] }}</td>
							<td width="14%">{{ $med['type'] }}</td>
							<td width="14%">{{ $med['morning'] }}</td>
							<td width="14%">{{ $med['afternoon'] }}</td>
							<td width="14%">{{ $med['evening'] }}</td>
							<td width="14%">{{ $med['night'] }}</td>
							<td width="16%">{{ $med['note'] }}</td>
						</tr>
					@endforeach
				</table>
			</td>
		</tr>
	</table>
	@endif
	<table style="width:100%">
		<tr>
			<td width="40%">
{{-- <img src="{{ public_path('images/doctorCertificate.png') }}" class="img-responsive"> --}}
			</td>
			<td width="10%"></td>
			<td width="50%">
				<img width="200px" src="data:image;base64,{{ $doctor['signature'] }}">
				<h4>{{ $doctor['name'] }}</h4>
				<p class="commonColor">Specialist:&nbsp;{{ $doctor['specialty'] }}</p>
				<p class="commonColor" style="margin-top:10px;">Doctor registration Number</p>
				<p>{{ $doctor['registration_no'] }}</p>
			</td>
		</tr>
	</table>
</body>
</html>