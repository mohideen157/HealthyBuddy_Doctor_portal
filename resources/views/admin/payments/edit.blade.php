@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Edit Payment</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/payments/{$payment['id']}")->addClass('test-class') ?>
				<?= Former::text('transaction_id')->value($payment['transaction_id'])->readonly() ?>
				<?= Former::text('doctor_id')->value($payment['doctor_shdct_id'])->readonly() ?>
				<?= Former::text('payment_date')->value($payment['payment_date'])->addClass('datetimepicker') ?>
				<?= Former::text('amount')->value($payment['amount']) ?>
				<?= Former::select('status')->options(['Pending' => 'Pending', 'Failed' => 'Failed', 'Done' => 'Done'], $payment['status']) ?>
				<?= Former::textarea('remarks')->value($payment['remarks']) ?>
				<?= Former::actions()->large_primary_submit('Submit') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/payments') }}" class="btn btn-primary">Back to Payments</a></div>
@endsection