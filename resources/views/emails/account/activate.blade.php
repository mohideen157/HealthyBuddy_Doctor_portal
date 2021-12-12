<!DOCTYPE html>
<html>
<body>
	<div>
		Hi {{ $name }},
	</div>
	<div>
		Thanks for choosing SheDoctr. Please activate your account by clicking the button below.
	</div>
	<div>
		<a href="{{ URL::to($link) }}" style="border-radius: 5px;color: #fff;text-decoration: none;display: inline-block;font-size: 14px;font-weight: bold;text-transform: capitalize;background: #348eda;margin: 0;padding: 12px 25px;border: 1px solid #348eda;">Activate SheDoctr Account</a>
	</div>
	<div>
		We may need to communicate important messages with you from time to time, so it's important we have an up-to-date email address for you on file.
	</div>
	<div>
		<br />
		Thanks,<br />
		SheDoctr
	</div>
</body>
</html>