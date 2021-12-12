<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>&nbsp;</h3>
		<ul class="nav side-menu">
			<li>
				<a href="{{ URL::to('admin') }}">Home</a>
			</li>
{{-- 			<li>
				<a>Settings <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a>Specialty <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ URL::to('admin/specialty') }}">Specialties</a></li>
							<li><a href="{{ URL::to('admin/specialty/create') }}">Add Specialty</a></li>
						</ul>
					</li>
					<li>
						<a>Symptoms <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ URL::to('admin/symptom') }}">Symptoms</a></li>
							<li><a href="{{ URL::to('admin/symptom/create') }}">Add Symptom</a></li>
						</ul>
					</li>
					<li>
						<a href="{{ URL::to('admin/medicine-types') }}">Medicine Type</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/languages') }}">Languages</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/allergy') }}">Allergies</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/disease') }}">Diseases</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/medication') }}">Medications</a>
					</li>
					<li>
						<a>Promo Code Banner <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ URL::to('admin/promo-code-banner') }}">Promo Code Banner</a></li>
							<li><a href="{{ URL::to('admin/promo-code-banner/create') }}">Add Banner</a></li>
						</ul>
					</li>
					<li>
						<a href="{{ URL::to('admin/settings') }}">Admin Settings</a>
					</li>
				</ul>
			</li>
			<li class="{{ Request::is('admin/doctors/*')?'active':'' }}">
				<a>Users <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" style="{{ Request::is('admin/doctors/*')?'display:block':'' }}">
					<li class="{{ Request::is('admin/doctors/*')?'active':'' }}">
						<a>Doctors <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu" style="{{ Request::is('admin/doctors/*')?'display:block':'' }}">
							<li><a href="{{ URL::to('admin/doctors/inactive') }}">Inactive</a></li>
							<li><a href="{{ URL::to('admin/doctors/active') }}">Active</a></li>
							<li><a href="{{ URL::to('admin/doctors/appointmentslist') }}">Doctor-appointment list</a></li>

							<li><a href="{{ URL::to('admin/doctors/specialty_list') }}">Doctor-speciality list</a></li>
						</ul>
					</li>
					<li>
						<a href="{{ URL::to('admin/patients') }}">Patient</a>
					</li>
				</ul>
			</li>
			<li>
				<a>Articles <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ URL::to('admin/articles/inactive') }}">Inactive</a></li>
					<li><a href="{{ URL::to('admin/articles/active') }}">Active</a></li>
				</ul>
			</li>
			<li>
				<a>Orders <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ URL::to('admin/medicine-orders') }}">Medicine</a></li>
					<li><a href="{{ URL::to('admin/lab-test-orders') }}">Lab Tests</a></li>
				</ul>
			</li>
			<li>
				<a>Fee Slabs <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ URL::to('admin/cancel-fee-slabs') }}">Cancellation Fee</a></li>
					<li><a href="{{ URL::to('admin/reschedule-fee-slabs') }}">Reschedule Fee</a></li>
					<li><a href="{{ URL::to('admin/doctor-commission-slabs') }}">Doctor Commission</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ URL::to('admin/coupon') }}">Coupons</a>
			</li>
			<li class="{{ Request::is('admin/payments/*')?'active':'' }}">
				<a>Payments <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" style="{{ Request::is('admin/payments/*')?'display:block':'' }}">
					<li><a href="{{ URL::to('admin/doctors/ledger') }}">Ledger</a></li>
					<li class="{{ Request::is('admin/payments/*')?'active':'' }}"><a href="{{ URL::to('admin/payments') }}">Payments</a></li>
				</ul>
			</li>
			<li>
				<a>Feedback <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ URL::to('admin/feedback') }}">Feedback</a></li>
					<li><a href="{{ URL::to('admin/call-feedback') }}">Call Feedback</a></li>
				</ul>
			</li>
 --}}
			<li>
				<a>Tenants <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ route('admin.tenant.create') }}">Add Tenant</a></li>
					<li><a href="{{ route('admin.tenant') }}">Show Tenant</a></li>
				</ul>
			</li>
			<li>
				<a>Expertise <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ route('admin.expertise') }}">Show Expertise</a></li>
				</ul>
			</li>
			<li>
				<a>Doctors <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ route('admin.doctor.create') }}">Add Doctor</a></li>
					<li><a href="{{ route('admin.doctor') }}">Show Doctor</a></li>
				</ul>
			</li>
			<li>
				<a>Organisations <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ route('admin.organisation') }}">Show Organisation</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ route('admin.assign.doctor') }}">Assign Doctor</a>
			</li>
			<li>
				<a href="{{ route('admin.patient.profile') }}">Patient Profile</a>
			</li>
		</ul>
	</div>
</div>
<!-- /sidebar menu -->