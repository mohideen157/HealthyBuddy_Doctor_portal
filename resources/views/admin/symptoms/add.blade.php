@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Add Symptom</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::open()->action("admin/symptom")->addClass('test-class') ?>
				<?= Former::text('name')->value('') ?>
				<?= Former::multiselect('specialties')->options($specialties)->addClass('specialty-select select2') ?>
				<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
			<?= Former::close() ?>
		</div>
	</div>
@endsection