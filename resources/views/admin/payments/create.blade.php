@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Payment</h1>

		<div class="col-xs-12" role="tabpanel" data-example-id="togglable-tabs">
			@include('layouts.doctor_tabs')
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
					<?= Former::vertical_open_for_files()->method('POST')->action("/admin/payments")->addClass('test-class') ?>
						<?= Former::hidden('doctor_id')->value($doctor->userData->id) ?>
						<?= Former::text('doctor_shdct_id')->value($doctor->userData->shdct_user_id)->disabled() ?>
						<?= Former::text('transaction_id') ?>
						<?= Former::text('payment_date')->addClass('datetimepicker') ?>
						<?= Former::text('amount') ?>
						<?= Former::select('status')->options(['Pending' => 'Pending', 'Failed' => 'Failed', 'Done' => 'Done']) ?>
						<?= Former::textarea('remarks') ?>
						<?= Former::actions()->large_primary_submit('Submit') ?>
					<?= Former::close() ?>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/payments') }}" class="btn btn-primary">Back to Payments</a></div>
@endsection