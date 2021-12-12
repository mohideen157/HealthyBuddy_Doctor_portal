@extends('layouts.master')

@section('style')
@endsection

@section('content')
<div class="row">
	<h1 class="text-center">Patient Details</h1>
	<table id="adminsettings-table" class="table table-bordered table-hover">
		<thead>
			<th>ID</th>
			<th>Name </th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Organisation</th>
			<th>Tenant</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->shdct_user_id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->mobile_no }}</td>
					<td>{{ $user->email }}</td>
					<td>Medlife</td>
					<td>HCL</td>
					<td>
						<a href="{{ route('patient.profile.show', $user->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-check" aria-hidden="true"></i></a>
						{{-- <a href="" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a> --}}
						{{-- <a class="btn btn-xs btn-danger" data-id=""><i class='fa fa-trash-o'></i></a> --}}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection

@section('script')
@endsection