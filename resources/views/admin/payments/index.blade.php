@extends('layouts.master')

@section('content')
	<div class="row">		
		<h1 class="text-center">Payments</h1>
		<table id="payments-table" class="table table-bordered table-hover">
			<thead>
				<th>Transaction ID</th>
				<th>Doctor ID</th>
				<th>Payment Date</th>
				<th>Appointment Date</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Remarks</th>
				<th>Action</th>
			</thead>
			@foreach ($payments as $pay)
			<tr>
				<td>{{ $pay['transaction_id'] }}</td>
				<td>{{ $pay['doctor_shdct_id'] }}</td>
				<td>{{ $pay['payment_date'] }}</td>
				<td>@if($pay['status'] == 'Done') {{ $pay['payment_date'] }} @endif</td>
				<td>{{ $pay['amount'] }}</td>
				<td>{{ $pay['status'] }}</td>
				<td>{{ $pay['remarks'] }}</td>
				<td>
					<a href="{{ URL::to('admin/payments/'.$pay["id"].'/edit') }}" class="btn btn-large btn-warning">Edit</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection

