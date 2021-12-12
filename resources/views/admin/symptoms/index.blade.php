@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Symptoms</h1>
		<table id="symptom-table" class="table table-bordered table-hover">
			<thead>
				<th>Symptom Name</th>
				<th>Specialty</th>
				<th>Action</th>
			</thead>
			@foreach ($symptoms as $symptom)
			<tr>
				<td class="col-sm-2">{{ $symptom->symptoms }}</td>
				<td>
					{{ implode(', ', $specialties[$symptom->id]) }}
				</td>
				<td class="col-sm-3">					
					<a href="{{ URL::to('admin/symptom/'.$symptom->id.'/edit') }}" class="btn btn-large btn-warning">Edit</a>
					<?= Former::horizontal_open()->action("admin/symptom/{$symptom->id}")->method('DELETE') ?>
						<?= Former::actions()->danger_submit('Delete')?>
					<?= Former::close() ?>	
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection