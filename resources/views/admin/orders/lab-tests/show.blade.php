@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Order Details</h1>
		<table class="table table-bordered table-hover">
			<tr>
				<td class="col-xs-3">ID</td>
				<td class="col-xs-9">{{ $order->shdct_id }}</td>
			</tr>
			<tr>
				<td class="col-xs-3">Date</td>
				<td class="col-xs-9">{{ $order->created_at->toDayDateTimeString() }}</td>
			</tr>
			<tr>
				<td class="col-xs-3">Ordered By</td>
				<td class="col-xs-9">
					{{ $user->name }}<br />
					{{ $user->email }}<br />
					{{ $user->mobile_no }}
				</td>
			</tr>
			<tr>
				<td class="col-xs-3">Delivery Address</td>
				<td class="col-xs-9">
					<?php echo nl2br($order->address); ?>
				</td>
			</tr>
			@if($order->prescription)
				<tr>
					<td class="col-xs-3">Prescription</td>
					<td class="col-xs-9">
						<a href="{{ URL::to('/admin/lab-test-order/'.$order->id.'/prescription') }}" target="_blank">View Prescription</a>
					</td>
				</tr>
			@endif
			<tr>
				<td class="col-xs-3">Status</td>
				<td class="col-xs-9">
					{{ $order->status }}
				</td>
			</tr>
		</table>

		<h3><strong>Lab Tests</strong></h3>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Note</th>
				</tr>
			</thead>
			<tbody>
				@foreach($order->labtests as $lt)
				<tr>
					<td>{{ $lt->test_name }}</td>
					<td>{{ $lt->datetime->toFormattedDateString() }}</td>
					<td>{{ $lt->datetime->format('h:i A') }}</td>
					<td>{{ $lt->note }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<h3><strong>Actions</strong></h3>
		<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/lab-test-order/{$order->id}")->addClass('inline-form') ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4">
					<?= Former::select('status')->options($possible_status, $order->status)->addClass('status-select') ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4">
					<?= Former::text('deliver_by')->value($order->deliver_by)->addClass('datetimepicker') ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4">
					<?= Former::text('delivered_on')->value($order->delivered_on)->addClass('datetimepicker') ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4">
					<?= Former::textarea('remarks')->value($order->remarks) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<?= Former::actions()->primary_submit('Submit') ?>
				</div>
			</div>
		<?= Former::close() ?>
		<!-- <div class="text-center"><a href="{{ URL::to('admin/lab-test-orders') }}" class="btn btn-primary">Back to Order</a></div> -->
	</div>
@endsection