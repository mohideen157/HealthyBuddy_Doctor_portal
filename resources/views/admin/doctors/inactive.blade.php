@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Inactive Doctors</h1>
		<table id="inactive-doctors-table" class="table table-bordered table-hover">
			<thead>
				<th>SheDoctr ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile No</th>
                                <th>Deactivated Date</th>
				<th>Medical Registration No</th>
				<th>Medical Degree</th>
				<th>Government ID</th>
				<th>Medical Registration Certificate</th>
				<th>ActionA</th>
			</thead>
			@foreach ($inactive_doctors as $d)
			<tr>
				<td>{{ $d->userData->shdct_user_id }}</td>
				<td>{{ $d->userData->name }}</td>
				<td>{{ $d->userData->email }}</td>
				<td>{{ $d->userData->mobile_no }}</td>
                                <td>{{ $d->created_at }}</td>
				<td>{{ $d->registration_no }}</td>
				<td>
					@if($d->documents && $d->documents->medical_degree)
						<a href="{{ URL::to('/').$d->documents->medical_degree }}" target="_blank">Open</a>
						@if($d->documents->medical_degree_verified)
							<br /><button class="btn disabled btn-primary">Approved</button>
						@elseif ($d->documents->medical_degree_reject_reason)
							<br /><button class="btn disabled btn-danger">Rejected</button>
							<br />Reason - {{ $d->documents->medical_degree_reject_reason }}
						@else
							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents") ?>
								<?= Former::hidden('medical_degree_verified')->value(1); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
								<?= Former::actions()->xs_primary_submit('Approve'); ?>
							<?= Former::close() ?>

							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents")->setAttributes(['class' => 'reject-doc-form']) ?>
								<?= Former::hidden('medical_degree_verified')->value(0); ?>
								<?= Former::hidden('reason')->value('')->class('reason'); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
							<?= Former::close() ?>
							<button class="btn btn-xs btn-danger reject-doc-button">Reject</button>
						@endif
					@endif
				</td>
				<td>
					@if($d->documents && $d->documents->government_id)
						<a href="{{ URL::to('/').$d->documents->government_id }}" target="_blank">Open</a>
						@if($d->documents->government_id_verified)
							<br /><button class="btn disabled btn-primary">Approved</button>
						@elseif ($d->documents->government_id_reject_reason)
							<br /><button class="btn disabled btn-danger">Rejected</button>
							<br />Reason - {{ $d->documents->government_id_reject_reason }}
						@else
							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents") ?>
								<?= Former::hidden('government_id_verified')->value(1); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
								<?= Former::actions()->xs_primary_submit('Approve'); ?>
							<?= Former::close() ?>

							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents")->setAttributes(['class' => 'reject-doc-form']) ?>
								<?= Former::hidden('government_id_verified')->value(0); ?>
								<?= Former::hidden('reason')->value('')->class('reason'); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
							<?= Former::close() ?>

							<button class="btn btn-xs btn-danger reject-doc-button">Reject</button>
						@endif
					@endif
				</td>
				<td>
					@if($d->documents && $d->documents->medical_registration_certificate)
						<a href="{{ URL::to('/').$d->documents->medical_registration_certificate }}" target="_blank">Open</a>
						@if($d->documents->medical_registration_certificate_verified)
							<br /><button class="btn disabled btn-primary">Approved</button>
						@elseif ($d->documents->medical_registration_certificate_reject_reason)
							<br /><button class="btn disabled btn-danger">Rejected</button>
							<br />Reason - {{ $d->documents->medical_registration_certificate_reject_reason }}
						@else
							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents") ?>
								<?= Former::hidden('medical_registration_certificate_verified')->value(1); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
								<?= Former::actions()->xs_primary_submit('Approve'); ?>
							<?= Former::close() ?>

							<?= Former::vertical_open()->method('PUT')->action("/admin/doctors/documents")->setAttributes(['class' => 'reject-doc-form']) ?>
								<?= Former::hidden('medical_registration_certificate_verified')->value(0); ?>
								<?= Former::hidden('reason')->value('')->class('reason'); ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
							<?= Former::close() ?>
							<button class="btn btn-xs btn-danger reject-doc-button">Reject</button>
						@endif
					@endif
				</td>
				<td>
					@if(!$d->is_verified)
						@if($d->documents && $d->documents->medical_registration_certificate_verified && $d->documents->government_id_verified && $d->documents->medical_degree_verified)
							<?= Former::vertical_open()->method('GET')->action("/admin/doctors/approve") ?>
								<?= Former::token() ?>
								<?= Former::hidden('user_id')->value($d->doctor_id) ?>
								<?= Former::actions()->large_primary_submit('Approve') ?>
							<?= Former::close() ?>
						@else
							<button class="btn disabled btn-primary">Approve</button>
						@endif
					@else
						<?= Former::vertical_open()->method('GET')->action("/admin/doctors/activate") ?>
							<?= Former::token() ?>
							<?= Former::hidden('user_id')->value($d->doctor_id) ?>
							<?= Former::actions()->success_submit('Activate Account') ?>
						<?= Former::close() ?>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection