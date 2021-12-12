@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add New Doctor Commission Slab</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/doctor-commission-slabs")->addClass('test-class')->method('POST') ?>
				<?= Former::text('key') ?>
				<?= Former::text('value') ?>
				<?= Former::actions()->primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Slabs</h1>
		<table id="doctor-commission-slabs-table" class="table table-bordered table-hover">
			<thead>
				<th>Key</th>
				<th>Value</th>
				<th>Action</th>
			</thead>
			@foreach ($data as $s)
			<tr>
				<td class="col-sm-4">
					{{ $s->key }}
				</td>
				<td class="col-sm-3">
					{{ $s->value }}
				</td>
				<td class="col-sm-2">
					<a href="{{ URL::to('/admin/doctor-commission-slabs/'.$s->id.'/edit') }}" class="btn btn-primary">Edit</a>
					@if($s->id != 1)
					<?= Former::horizontal_open()->action("admin/doctor-commission-slabs/{$s->id}")->method('DELETE') ?>
						<a class="delete-btn btn btn-danger">Delete</a>
					<?= Former::close() ?>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
