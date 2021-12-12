@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctors Specialty list</h1>
		<table id="spec-doctors-table" class="table table-bordered table-hover">
			<thead>
				<th>SheDoctr ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile No</th>
				<th>Medical Registration No</th>
                                <th>specialty</th>
			</thead>
			@foreach ($doctors as $d)
                        
			<tr>
   
				<td class="col-sm-2">{{ $d->userData->shdct_user_id }}</td>
				<td class="col-sm-2">{{ $d->userData->name }}</td>
				<td class="col-sm-2">{{ $d->userData->email }}</td>
				<td class="col-sm-2">{{ $d->userData->mobile_no }}</td>
				<td class="col-sm-2">{{ $d->registration_no }}</td>
                                <td class="col-sm-2">{{ $d-> specialty }}</td>
				
			</tr>
			@endforeach
		</table>
	</div>
@endsection