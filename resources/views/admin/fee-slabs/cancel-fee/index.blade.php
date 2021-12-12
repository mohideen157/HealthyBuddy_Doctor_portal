@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add New Cancellation Fee Slab</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/cancel-fee-slabs")->addClass('test-class')->method('POST') ?>
				<?= Former::text('from')->value($new_from)->readonly() ?>
				<?= Former::text('to')->value('') ?>
				<?= Former::text('fee')->value('') ?>
				<?= Former::actions()->primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Slabs</h1>
		<table id="adminsettings-table" class="table table-bordered table-hover">
			<thead>
				<th>From</th>
				<th>To</th>
				<th>Fee</th>
				<th>Action</th>
			</thead>
			@foreach ($slabs as $s)
			<tr>
				<td class="col-sm-3">
					{{ $s->from }}
				</td>
				<td class="col-sm-4">
					{{ $s->to }}
				</td>
				<td class="col-sm-3">
					{{ $s->fee }}
				</td>
				<td class="col-sm-2">
					<a href="{{ URL::to('/admin/cancel-fee-slabs/'.$s->id.'/edit') }}" class="btn btn-primary">Edit</a>
					<?= Former::horizontal_open()->action("admin/cancel-fee-slabs/{$s->id}")->method('DELETE') ?>
						<a class="delete-btn btn btn-danger">Delete</a>
					<?= Former::close() ?>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
