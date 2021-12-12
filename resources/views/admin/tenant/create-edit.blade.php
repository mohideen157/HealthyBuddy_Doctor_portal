@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-xs-12 tenant-panel">
		   <div class="panel panel-default">
	            <div class="panel-heading">
					<h3 class="panel-title" style="font-size:18px;display: inline-block;">@if(isset($user)) Update Tenants @else Add Tenants @endif</h3>
					<span class="pull-right clickable">
					    <i class="fa fa-chevron-up"></i>
					</span>
				</div>
				<div class="panel-body">
			        <div id="collapse">
						<form action="@if(isset($user)){{ route('admin.tenant.update', $user->id) }} @else{{ route('admin.tenant.store') }} @endif" method="POST">
							{{ csrf_field() }}
							<div class="col-md-6">
								<div class="form-group">
									<label for="company-name">Company Name:</label>
									<input type="text" class="form-control" id="company-name" name="name" placeholder="Enter Company name" value="{{ old('name', $user->name ?? '') }}">
								</div>
								@include('components.error', ['index' => 'name'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="company-phone">Company Phone:</label>
									<input type="text" class="form-control" id="company-phone" name="mobile_no" placeholder="Enter company mobile" value="{{ old('mobile_no', $user->mobile_no ?? '') }}">
								</div>
								@include('components.error', ['index' => 'mobile_no'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="landline">Landline:</label>
									<input type="text" class="form-control" id="landline" name="landline" placeholder="Enter company Landline" value="{{ old('landline', $user->tenant_details->landline ?? '') }}">
								</div>
								@include('components.error', ['index' => 'landline'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="email">Email:</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter company email" value="{{ old('email', $user->email ?? "") }}">
								</div>
								@include('components.error', ['index' => 'email'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="concern-person">Concern Person:</label>
									<input type="text" class="form-control" id="concern-person" name="concern_person" placeholder="Enter Concern Person name" value="{{ old('concern_person', $user->tenant_details->concern_person ?? "") }}">
								</div>
								@include('components.error', ['index' => 'concern_person'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="concern-person-mobile">Concern Person Phone:</label>
									<input type="text" class="form-control" id="concern-person-mobile" name="concern_person_mobile" placeholder="Enter concern person mobile" value="{{ old('concern_person_mobile', $user->tenant_details->concern_person_mobile ?? "") }}">
								</div>
								@include('components.error', ['index' => 'concern_person_mobile'])
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="address">Address:</label>
									<textarea class="form-control" id="address" rows="5" name="address">{{ old('address', $user->tenant_details->address ?? '') }}</textarea>
								</div>
								@include('components.error', ['index' => 'address'])
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="details">Company Details:</label>
									<textarea class="form-control" id="details" rows="5" name="details">{{ old('address', $user->tenant_details->details ?? '') }}</textarea>
								</div>
								@include('components.error', ['index' => 'details'])
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="slug">Slug URL:</label>
									<input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug of Tenant" value="{{ old('slug', $user->tenant_details->slug ?? "") }}">
								</div>
								@include('components.error', ['index' => 'slug'])
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
				    </div>
			    </div>
		   </div>
	    </div>
	</div>
</div>
@endsection