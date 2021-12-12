@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctor Details</h1>

		<div class="col-xs-12" role="tabpanel" data-example-id="togglable-tabs">
			@include('layouts.doctor_tabs')
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
					<table class="table table-bordered table-hover">
						<tr>
							<th class="col-xs-2">Shedoctr ID</th>
							<td class="col-xs-10">{{ $doctor->userData->shdct_user_id }}</td>
						</tr>
						<tr>
							<th class="col-xs-2">Name</th>
							<td class="col-xs-10">{{ $doctor->name }}</td>
						</tr>
						<tr>
							<th class="col-xs-2">Email</th>
							<td class="col-xs-10">{{ $doctor->userData->email }}</td>
						</tr>
						<tr>
							<th class="col-xs-2">Mobile</th>
							<td class="col-xs-10">{{ $doctor->userData->mobile_no }}</td>
						</tr>
						<tr>
							<th class="col-xs-2">Medical Registration No.</th>
							<td class="col-xs-10">{{ $doctor->registration_no }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection