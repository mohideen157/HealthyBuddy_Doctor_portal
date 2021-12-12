@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Active Doctors</h1>
		<table id="active-doctors-table" class="table table-bordered table-hover">
			<thead>
				<th>SheDoctr ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile No</th>
				<th>Download</th>
                                <th>Activated Date</th>
				<th>Medical Registration No</th>
				<th>Commission Slab</th>
				<th>Actions</th>
			</thead>
			@foreach ($active_doctors as $d)
                         <?php ?>
			<tr>
				<td><a href="{{ URL::to('/admin/doctors/'.$d->doctor_id.'/profile') }}">{{ $d->userData->shdct_user_id }}</a></td>
				<td>{{ $d->userData->name }}</td>
				<td>{{ $d->userData->email }}</td>
				<td>{{ $d->userData->mobile_no }}</td>
				<td> <a href="{{ URL::to($d->profile_image) }}">Download </a>
				</td>
                                <td>{{ $d->activated_at }}</td>
				<td>{{ $d->registration_no }}</td>
				<td>{{ $d->commissionSlab->key }} ( {{ $d->commissionSlab->value }}% )</td>
				<td>
					@if($d->show_on_homepage == 0)
						@if($d->specialty && !$d->userData->profile_image_default)
							<?= Former::vertical_open()->method('GET')->action("/admin/doctors/showOnHomepage") ?>
								<?= Former::token() ?>
								<?= Former::hidden('profile_id')->value($d->id) ?>
								<?= Former::actions()->large_primary_submit('Show On Homepage') ?>
							<?= Former::close() ?>
						@endif
					@else
						<?= Former::vertical_open()->method('GET')->action("/admin/doctors/removeFromHomepage") ?>
							<?= Former::token() ?>
							<?= Former::hidden('profile_id')->value($d->id) ?>
							<?= Former::actions()->large_danger_submit('Remove From Homepage') ?>
						<?= Former::close() ?>
					@endif
					<?= Former::vertical_open()->method('GET')->action("/admin/doctors/deactivate") ?>
						<?= Former::token() ?>
						<?= Former::hidden('user_id')->value($d->doctor_id) ?>
						<?= Former::actions()->warning_submit('Deactivate Account') ?>
					<?= Former::close() ?>
					@if($d->priority_doctor == 0)
						<?= Former::vertical_open()->method('GET')->action("/admin/doctors/markPriority") ?>
							<?= Former::token() ?>
							<?= Former::hidden('profile_id')->value($d->id) ?>
							<?= Former::actions()->primary_submit('Show on Priority') ?>
						<?= Former::close() ?>
					@else
						<?= Former::vertical_open()->method('GET')->action("/admin/doctors/unmarkPriority") ?>
							<?= Former::token() ?>
							<?= Former::hidden('profile_id')->value($d->id) ?>
							<?= Former::actions()->primary_submit('Remove from Priority') ?>
						<?= Former::close() ?>
					@endif
					<a href="{{ URL::to('/admin/doctors/'.$d->doctor_id.'/profile') }}" class="btn btn-success">View</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection