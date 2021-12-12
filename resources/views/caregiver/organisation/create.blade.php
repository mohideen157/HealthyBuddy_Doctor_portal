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
			 <h3 class="panel-title" style="font-size:18px;display: inline-block;">@if(!isset($user)) Create Organisation @else Update Organisation @endif</h3>
			 <span class="pull-right clickable">
				<i class="fa fa-chevron-up"></i>
			 </span>
		   </div>
		   <div class="panel-body">
		      <div id="collapse">
		      	@if(isset($user))
		      	<?php $pid=$user->user->id; ?>
		      	@endif
				<form action='@if(isset($user)){{ url("caregiver/organisation/update/$user->id/$pid") }} @else{{ url("caregiver/organisation/store") }} @endif' method="POST">
					{{ csrf_field() }}
					<div class="col-md-6">
						<div class="form-group">
							<label for="organisation-name">Organisation Name:</label>
							<input type="text" class="form-control" id="organisation-name" name="name" placeholder="Enter organisation name" value="{{ old('name', $user->user->name ?? "") }}">
						</div>
						 
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="organisation-phone">Organisation Phone:</label>
							<input type="number" class="form-control" id="organisation-phone" name="mobile_no" placeholder="Enter organisation mobile" value="{{ old('mobile_no', $user->user->mobile_no ?? "") }}">
						</div>
						 
					</div>
					 
					<div class="col-md-6">
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter organisation email" value="{{ old('email', $user->user->email ?? "") }}">
						</div>
						 
					</div>
					 
					 
					
					 
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