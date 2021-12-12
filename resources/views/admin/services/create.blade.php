@extends('layouts.master')

@section('content')
	<h3 class="text-center">Add New Service</h3>
	<div class="col-xs-8 col-xs-offset-2">
		<?= Former::open_for_files()->action("ourservices")->addClass('test-class') ?>
			<?= Former::text('title') ?>
			<?= Former::textarea('description')?>
			<?= Former::file('image') ?>
			<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
		<?= Former::close() ?>
	</div>
@endsection