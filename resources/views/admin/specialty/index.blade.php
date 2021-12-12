@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Specialties</h1>
		<table id="specialty-table" class="table table-bordered table-hover">
			<thead>
				<th>Specialty Name</th>
				<th></th>
				<th>Details</th>
				<th>Parent</th>
				<th>Action</th>
			</thead>
			@foreach ($specialities as $speciality)
			<tr>
				<td class="col-sm-2">{{ $speciality->specialty }}</td>
				<td class="col-sm-1"><img src="{{ $speciality->image }}" class="img-responsive"></td>
				<td class="col-sm-5">{{ $speciality->details }}</td>
				<td class="col-sm-2">{{ $spec[$speciality->parent] }}</td>
				<td class="col-sm-2">					
					<a href="{{ URL::to('admin/specialty/'.$speciality->id.'/edit') }}" class="btn btn-large btn-warning">Edit</a>
					<?= Former::vertical_open_for_files()->method('DELETE')->action("/admin/specialty/$speciality->id")->addClass('inline-form') ?>
						<?= Former::actions()->danger_submit('Delete') ?>
					<?= Former::close() ?>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection