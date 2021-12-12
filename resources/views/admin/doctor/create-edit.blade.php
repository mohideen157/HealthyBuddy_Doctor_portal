@extends('layouts.master')
<?php error_reporting(0); ?>
@section('content')
<div class="container-fluid">
<div class="row">
  <div class="col-md-12 col-xs-12 tenant-panel">
	<div class="panel panel-default tenant-panel">
	    <div class="panel-heading">
			 <h3 class="panel-title" style="font-size:18px;display: inline-block;">@if(!isset($user)) Create Doctor @else Update Doctor @endif</h3>
			<span class="pull-right clickable">
				<i class="fa fa-chevron-up"></i>
			</span>
		</div>
		<div class="panel-body">
		  <div id="collapse">
				<form action="@if(isset($user)){{ route('admin.doctor.update', $user->id) }} @else{{ route('admin.doctor.store') }} @endif" method="POST">
					{{ csrf_field() }}
					<div class="col-md-6">
						<div class="form-group">
							<label for="doctor-name">Doctor Name:</label>
							<input type="text" class="form-control" id="doctor-name" name="name" placeholder="Enter Doctor name" value="{{ old('name', $user->name ?? '') }}">
						</div>
						@include('components.error', ['index' => 'name'])
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="doctor-phone">Doctor Phone:</label>
							<input type="text" class="form-control" id="mobile-no" name="mobile_no" placeholder="Enter Doctor mobile" value="{{ old('mobile_no', $user->mobile_no ?? '') }}">
						</div>
						@include('components.error', ['index' => 'mobile_no'])
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="landline">Landline:</label>
							<input type="text" class="form-control" id="landline" name="landline" placeholder="Enter Doctor Landline" value="{{ old('landline', $user->doctor->landline ?? '') }}">
						</div>
						@include('components.error', ['index' => 'landline'])
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter Doctor email" value="{{ old('email', $user->email ?? '') }}">
						</div>
						@include('components.error', ['index' => 'email'])
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="experiance">experiance:</label>
							<input type="number" class="form-control" id="experiance" name="experiance" placeholder="Enter experiance name" value="{{ old('experiance', $user->doctor->experiance ?? '') }}">
						</div>
						@include('components.error', ['index' => 'experiance'])
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="current-hospital">Current Hospital:</label>
							<input type="text" class="form-control" id="current-hospital" name="current_hospital" placeholder="Enter Current Hospital" value="{{ old('current_hospital', $user->doctor->current_hospital ?? '') }}">
						</div>
						@include('components.error', ['index' => 'current_hospital'])
					</div>

					<div class="col-md-12">

						<div class="form-group">
							<label for="expertise">Expertise:</label>
							<select  class="form-control" name="expertise[]" id="expertise" multiple>
								@if(!empty($expertises))
								@foreach($expertises as $expertise)
									<option value="{{ $expertise->id }}" @if(isset($user))@if(in_array($expertise->id, Helper::decode($user->doctor->expertise))) selected @endif @endif>{{ ucfirst($expertise->name) }}</option>
								@endforeach
								@endif
							</select>
						</div>
						@include('components.error', ['index' => 'expertise'])
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="address">Address:</label>
							<textarea class="form-control" id="address" rows="5" name="address">{{ old('address', $user->doctor->address ?? '') }}</textarea>
						</div>
						@include('components.error', ['index' => 'address'])
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="profile-details">Profile Details:</label>
							<textarea class="form-control" id="profile-details" rows="5" name="profile_details">{{ old('profile_details', $user->doctor->profile_details ?? '') }}</textarea>
						</div>
						@include('components.error', ['index' => 'profile_details'])
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

@section('script')
	<script type="text/javascript">
	$(document).ready(function(){
		// select2 for expertise
		$('#expertise').select2();
	});
	</script>
@endsection