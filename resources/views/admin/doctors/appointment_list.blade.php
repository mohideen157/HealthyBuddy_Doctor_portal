@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Appointment Details</h1>
		<table id="active-doctors-table" class="table table-bordered table-hover">
			<thead>
				<th>Appointment ID</th>
				<th>Patient Name</th>
                                <th>Patient Mobile Number</th> 
				<th>Doctor Name</th>
				<th>Consultation_price</th>
				<th>Appointment Date </th>
				<th>Appointment Time </th>
				<th>Consultation Type</th>
				<th>Call status Reason</th>
                <th>Call status Details</th>
			</thead>
			@foreach ($appointment_list as $d)
             <?php //dd($d);?>
			<tr>
   
				<td class="col-sm-2">{{ $d->shdct_appt_id }}</td>
				<td class="col-sm-2">{{ $d->patient_name }}</td>
                                <td class="col-sm-2">{{ $d-> mobile_no }}</td>
				<td class="col-sm-2">{{ $d->name }}</td>
				<td class="col-sm-2">{{ $d->consultation_price }}</td>
				<td class="col-sm-2">{{ $d->date }}</td>
				<td class="col-sm-2">{{ $d->time_start }}</td>
				<td class="col-sm-2">{{ $d->consultation_type }}</td>
                <td class="col-sm-2">{{ $d-> reason }}</td>
                 <td class="col-sm-2">{{ $d-> details }}</td>
				
			</tr>
			@endforeach
		</table>
	</div>
@endsection