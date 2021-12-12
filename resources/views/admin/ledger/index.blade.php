@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctor Ledgers</h1>
		<div class="table-responsive">
			<table id="active-doctors-table" class="table table-bordered table-hover">
				<thead>
					<th>SheDoctr ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Mobile No</th>
					<th>Paid till now</th>
					<th>Pending Balance</th>
					<th>Actions</th>
				</thead>
				@foreach ($data as $d)
				<tr>
					<td>{{ $d['sh_id'] }}</td>
					<td>{{ $d['name'] }}</td>
					<td>{{ $d['email'] }}</td>
					<td>{{ $d['mobile_no'] }}</td>
					<td>{{ $d['paid'] }}</td>
					<td>{{ $d['pending'] }}</td>
					<td>
						<a href="{{ URL::to('admin/doctors/'.$d['id'].'/ledger') }}" class="btn btn-primary">View Ledger</a>
						<a href="{{ URL::to('admin/payments/create?doctor_id='.$d['id']) }}" class="btn btn-success">Add Payment</a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection