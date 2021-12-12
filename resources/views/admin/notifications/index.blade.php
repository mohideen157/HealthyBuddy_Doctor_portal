@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Notifications</h1>
		<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/notifications/clear-all")->addClass('inline-form') ?>
			<?= Former::actions()->primary_submit('Clear All') ?>
		<?= Former::close() ?>
		<table id="notifications-table" class="table table-bordered table-hover">
			@foreach ($all_notifications as $not)
			<tr>
				<td>
					{{ $not->subject }} <br />
					<?php echo nl2br($not->body); ?> <br />
					{{ $not->created_at->diffForHumans() }}
				</td>
				<td>
					<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/notifications/{$not->id}/clear")->addClass('inline-form') ?>
						<?= Former::actions()->primary_submit('Clear') ?>
					<?= Former::close() ?>
				</td>
			</tr>
			@endforeach
			@if(count($all_notifications) <= 0)
			<tr>
				<td colspan="2">No Unread Notification</td>
			</tr>
			@endif
		</table>
	</div>
@endsection