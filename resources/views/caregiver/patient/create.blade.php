@extends('caregiver.component._master')

@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 tenant-panel">
	   <div class="panel panel-default">
	   	 @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
           @endif
	       <div class="panel-heading">
			 <h3 class="panel-title" style="font-size:18px;display: inline-block;">@if(!isset($user)) Create Patient @else Update Patient @endif</h3>
			 <span class="pull-right clickable">
				<i class="fa fa-chevron-up"></i>
			 </span>
		   </div>
		   <div class="panel-body">
		      <div id="collapse">
				<form action="@if(isset($user)){{ url('caregiver/patient/update', $user->id) }} @else{{ url('caregiver/patient/store') }} @endif" method="POST">
					{{ csrf_field() }}
					<div class="col-md-6">
						<div class="form-group">
							<label for="organisation-name">Patient Name:</label>
							<input type="text" class="form-control" id="organisation-name" name="name" placeholder="Enter Patient name" value="{{ old('name', $user->name ?? "") }}">
						</div>
						 
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="organisation-phone">Patient Phone:</label>
							<input type="number" class="form-control" id="organisation-phone" name="mobile_no" placeholder="Enter Patient mobile" value="{{ old('mobile_no', $user->mobile_no ?? "") }}">
						</div>
						 
					</div>
					 
					<div class="col-md-6">
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter Patient email" value="{{ old('email', $user->email ?? "") }}">
						</div>
						 
					</div>
              
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label for="email">Organisation:</label>
						<?php  $orgid=(isset($user->organisation_id)) ? $user->organisation_id :0 ?>	 
                    {!! Form::select('organisation_id', $org, $orgid, ['class' => 'form-control']) !!}
						</div>
						 
					</div> -->
					 
					  
					 
					
					 
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">@if(isset($user))Update @else Add @endif</button>
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