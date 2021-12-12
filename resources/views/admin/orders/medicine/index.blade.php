@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Medicine Orders</h1>
		<table id="orders-table" class="table table-bordered table-hover">
			<thead>
				<th>ID</th>
				<th>Date</th>
				<th>Status</th>
				<th>Action</th>
			</thead>
			@foreach ($orders as $ord)
			<tr>
				<td>{{ $ord->shdct_id }}</td>
				<td>
					{{ $ord->created_at->toDayDateTimeString() }}
				</td>
				<td>
					{{ $ord->status }}
				</td>
				<td>
					<a href="{{ URL::to('/admin/medicine-order/'.$ord->id) }}" class="btn btn-primary">View</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection