@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Change Password</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/user/{$user->id}") ?>
				<?= Former::password('password')->value('') ?>
				<?= Former::password('confirm_password')->value('') ?>
				<?= Former::actions()->large_primary_submit('Submit') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/reschedule-fee-slabs') }}" class="btn btn-primary">Back to Cancel Fee Slabs</a></div>
@endsection