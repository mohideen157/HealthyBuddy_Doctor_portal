@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Add Credits</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<h3>Name - {{ $user->name }}</h3>
				</div>
				<div class="col-xs-12 col-sm-4">
					<h3>ID - {{ $user->shdct_user_id }}</h3>
				</div>
				<div class="col-xs-12 col-sm-4">
					<h3>Available Credits - {{ $credits->credits }}</h3>
				</div>
			</div>
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/patient/{$user->id}/credits") ?>
				<?= Former::text('credits')->value('') ?>
				<?= Former::actions()->large_primary_submit('Submit') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/reschedule-fee-slabs') }}" class="btn btn-primary">Back to Cancel Fee Slabs</a></div>
@endsection