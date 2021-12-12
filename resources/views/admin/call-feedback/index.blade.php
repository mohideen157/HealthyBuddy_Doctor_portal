@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Feedback</h1>
		<table id="feedback-table" class="table table-bordered table-hover">
			<thead>
				<th>Appointment ID</th>
				<th>Doctor Rating</th>
				<th>Patient Rating</th>
			</thead>
			@foreach ($feedback as $f)
			<tr>
				<td>{{ $f['appointment_id'] }}</td>
				<td>{{ $f['doctor_rating'] }}</td>
				<td>{{ $f['patient_rating'] }}</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection