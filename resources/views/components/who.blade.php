@if (Auth::guard('web')->check())
	<p class="text-success">you are login as USER</p>
@else
	<p class="text-danger">you are logout as USER</p>
@endif

@if (Auth::guard('admin')->check())
	<p class="text-success">you are login as ADMIN</p>
@else
	<p class="text-danger">you are logout as ADMIN</p>
@endif