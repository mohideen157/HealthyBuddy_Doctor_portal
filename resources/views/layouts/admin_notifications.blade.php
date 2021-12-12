<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-envelope-o"></i>
		<span class="badge bg-green">{{ $notifications['count'] }}</span>
	</a>
	<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
		@if($notifications['count'] == 0)
			<li>
				<span>
					No New Notification
				</span>
			</li>
		@else
			@foreach ($notifications['notifications'] as $not)
				<li>
					<a href="javascript:void(0)">
						<!-- <span class="image"><img src="/bower_components/gentelella/production/images/img.jpg" alt="Profile Image" /></span> -->
						<span>
							<span>{{ $not->subject }}</span>
							<span class="time">{{ $not->created_at->diffForHumans() }}</span>
						</span>
						<span class="message">
							{{ $not->body }}
						</span>
					</a>
				</li>
			@endforeach
			<li>
				<div class="text-center">
					<a href="{{ URL::to('admin/notifications') }}">
						<strong>See All Alerts</strong>
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</li>
		@endif
	</ul>
</li>