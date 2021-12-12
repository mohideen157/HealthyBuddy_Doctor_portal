@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Add Specialty</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::open_for_files()->action("admin/specialty")->addClass('test-class') ?>
				<?= Former::text('name')->value('') ?>
				<?= Former::textarea('details')->value('') ?>
				<?= Former::file('image') ?>
				<?= Former::select('parent')->options($specialties)->addClass('specialty-select select2') ?>
				<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
			<?= Former::close() ?>
		</div>
	</div>
@endsection