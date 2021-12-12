@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Coupon</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/coupon")->addClass('test-class')->method('POST') ?>
				<?= Former::text('name')->value('') ?>
				<?= Former::textarea('description')->value('') ?>
				<?= Former::radios('choose one option')
				  ->radios(array(
				    'percentage' => array('name' => 'type', 'value' => '1','checked'=>'true'),
				    'Absolute Value' => array('name' => 'type', 'value' => '2'),
				  )) ?>

				<?= Former::text('value')->value('') ?>
				<?= Former::text('No_of_users')->value('') ?>
				<!-- <?= Former::radios('choose one option')
				  ->radios(array(
				    'Active' => array('name' => 'status', 'value' => '1','checked'=>'true'),
				    'Inactive' => array('name' => 'status', 'value' => '0'),
				  )) ?>	 -->
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Coupons</h1>
		<table id="adminsettings-table" class="table table-bordered table-hover">
			<thead>
				<th>Name</th>
				<th>Description</th>
				<th>Value</th>
				<th>No of users</th>
                                <th>No of users used coupon</th>
				<th>Type</th>
				<th>Status</th>
				<th>Action</th>
			</thead>
			@foreach ($settings as $s)
			<tr>
				<td class="col-sm-3">
					{{ $s->name }}
				</td>
				<td class="col-sm-4">
					{{ $s->description }}
				</td>
				<td class="col-sm-3">
					{{ $s->val }}
				</td>
				<td class="col-sm-3">
					{{ $s->total_user }}
				</td>
                                <td class="col-sm-3">
					{{ $s->current_user }}
				</td>
				<td class="col-sm-3">
					<?php if($s->type==1) 
					       echo 'Percentage'; 
					         else 
					       echo 'Absolute';   	
					?>
				</td>
				<td class="col-sm-3">
					<?php if($s->active==0) 
					       echo 'Inactive'; 
					         else 
					       echo 'Active';   	
					?>
				</td>
				<td class="col-sm-2">					
					<a href="{{ URL::to('admin/coupon/'.$s->id.'/edit') }}" class="btn btn-large btn-warning">Edit</a>
					<?php if($s->active==0) {?>
					<a href="{{ URL::to('admin/coupon/'.$s->id.'/status') }}" class="btn btn-large btn-warning">Activate</a>
					<?php }else {?>
					<a href="{{ URL::to('admin/coupon/'.$s->id.'/status') }}" class="btn btn-large btn-warning">Deactivate</a>
					<?php }?>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
