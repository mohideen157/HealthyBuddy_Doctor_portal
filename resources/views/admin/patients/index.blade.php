@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Patients</h1>
		<table id="patients-table" class="table table-bordered table-hover">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile No</th>
                                <th>Registered Date</th>
				<th>Action</th>
			</thead>
			@foreach ($patients as $pat)
			<tr>
				<td>{{ $pat->shdct_user_id }}</td>
				<td>{{ $pat->name }}</td>
				<td>{{ $pat->email }}</td>
				<td>{{ $pat->mobile_no }}</td>
                                <td>{{ $pat->created_at }}</td>
				<td>
					@if($pat->active == 1)
						<?= Former::vertical_open()->method('GET')->action("/admin/patients/deactivate") ?>
							<?= Former::token() ?>
							<?= Former::hidden('user_id')->value($pat->id) ?>
							<?= Former::actions()->danger_submit('Deactivate Account') ?>
						<?= Former::close() ?>
					@else
						<?= Former::vertical_open()->method('GET')->action("/admin/patients/activate") ?>
							<?= Former::token() ?>
							<?= Former::hidden('user_id')->value($pat->id) ?>
							<?= Former::actions()->warning_submit('Activate Account') ?>
						<?= Former::close() ?>
					@endif
					<a href="{{ URL::to('/admin/user/'.$pat->id.'/edit') }}" class="btn btn-primary">Change Password</a><br />
					<a href="{{ URL::to('/admin/patient/'.$pat->id.'/credits') }}" class="btn btn-success">Add Credits</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection