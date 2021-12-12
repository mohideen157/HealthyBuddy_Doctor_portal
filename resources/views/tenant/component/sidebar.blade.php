<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>&nbsp;</h3>
		<ul class="nav side-menu">
			<li>
				<a href="{{ URL::to('admin') }}">Home</a>
			</li>
			<li>
				<a>Organizations <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="{{ route('tenant.organisation') }}">Organizations</a></li>
					<li><a href="{{ route('tenant.organisation.create') }}">Add Organization</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ route('tenant.patient.profile') }}">Patient Profile</a>
			</li>
		</ul>
	</div>
</div>
<!-- /sidebar menu -->