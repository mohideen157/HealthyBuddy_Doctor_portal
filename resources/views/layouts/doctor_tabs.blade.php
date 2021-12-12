<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	<li role="presentation" class="{{ Request::is('admin/doctors/*/profile')?'active':'' }}">
		<a href="{{ URL::to('/admin/doctors/'.$doctor->doctor_id.'/profile') }}" >Home</a>
	</li>
	<li role="presentation" class="{{ Request::is('admin/doctors/*/commission-slab')?'active':'' }}">
		<a href="{{ URL::to('/admin/doctors/'.$doctor->doctor_id.'/commission-slab') }}">Commission Slab</a>
	</li>
	<li role="presentation" class="{{ Request::is('admin/doctors/*/ledger')?'active':'' }}">
		<a href="{{ URL::to('/admin/doctors/'.$doctor->doctor_id.'/ledger') }}">Ledger</a>
	</li>
	<li role="presentation" class="{{ Request::is('admin/doctors/*/bank-details')?'active':'' }}">
		<a href="{{ URL::to('/admin/doctors/'.$doctor->doctor_id.'/bank-details') }}">Bank Details</a>
	</li>				
	<li role="presentation" class="{{ Request::is('admin/payments/create*')?'active':'' }}">
		<a href="{{ URL::to('/admin/payments/create?doctor_id='.$doctor->doctor_id) }}">Add Payment</a>
	</li>
</ul>