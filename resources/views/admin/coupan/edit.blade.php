@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Edit Coupon</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/coupon/{$setting->id}")->addClass('test-class')->method('PUT') ?>
				<?= Former::text('name')->value($setting->name)->readonly(true) ?>
				<?= Former::textarea('description')->value($setting->description) ?>
				<?= Former::text('value')->value($setting->val) ?>
				<?= Former::radios('choose one option')
				  ->radios(array(
				    'percentage' => array('name' => 'type', 'value' => '1',),
				    'Absolute Value' => array('name' => 'type', 'value' => '2'),
				  ))->check($setting->type) ?>	
				<?= Former::text('No_of_users')->value($setting->total_user) ?>
				<!-- <?= Former::radios('choose one option')
				  ->radios(array(
				    'Active' => array('name' => 'status', 'value' => '1'),
				    'Inactive' => array('name' => 'status', 'value' => '0'),
				  ))->check($setting->active) ?> -->	
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/coupon') }}" class="btn btn-primary">Back to coupon</a></div>
@endsection
