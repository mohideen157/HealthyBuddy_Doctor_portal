@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctor Ledger</h1>

		<div class="col-xs-12" role="tabpanel" data-example-id="togglable-tabs">
			@include('layouts.doctor_tabs')
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in">
					<div class="col-xs-12">
						<div class="row">
							<?= Former::vertical_open()->id('ledger-filter-form') ?>
								<div class="col-xs-12 col-sm-6 col-md-3">
									<?= Former::select('call_type')->options($call_type_arr)->data_column(1)->label('Call Type')->addClass('ledger-select-filter') ?>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-3">
									<?= Former::select('status')->options($status_arr)->data_column(-2)->label('Status')->addClass('ledger-select-filter') ?>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-3">
									<?= Former::text('date_from')->label('Date From')->id('date-from')->data_column(-1)->addClass('ledgerdatepicker ledger-text-filter') ?>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-3">
									<?= Former::text('date_to')->label('Date To')->id('date-to')->data_column(-1)->addClass('ledgerdatepicker ledger-text-filter') ?>
								</div>					
							<?= Former::close() ?>
						</div>
					</div>

					<table id="ledger-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Date</th>
								<th>Call Type</th>
								<th>Appointment ID</th>
								<th>Patient ID</th>
								<th>Transaction ID</th>
								<th>Consultation Price</th>
								<th>Paid by Patient</th>
								<th>SheDoctr</th>
								<th>Doctor Commission</th>
								<th>Other Details</th>
								<th>Status</th>
								<th>Date</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th colspan="7"></th>
								<th>123</th>
								<th>123</th>
								<th></th>
							</tr>
						</tfoot>
						@foreach ($data as $d)
						<tr>
							<td>{{ $d['date_time']->format('M j Y') }}, {{ $d['date_time']->format('h:i A') }}</td>
							<td>{{ ucwords($d['consultation_type']) }}</td>
							<td>{{ $d['appointment_id'] }}</td>
							<td>{{ $d['patient_id'] }}</td>
							<td>{{ $d['transaction_id'] }}</td>
							<td>{{ $d['consultation_price'] }}</td>
							<td>{{ $d['patient_rs'] }}</td>
							<td>{{ $d['shedoctr_rs'] }}</td>
							<td>{{ $d['doctor_rs'] }}</td>
							<td><?php echo $d['other_details']; ?></td>
							<td>{{ $d['status'] }}</td>
							<td>{{ $d['date_time']->toDateString() }}</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection