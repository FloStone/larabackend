<nav>
	<ul>
		@if(isset($actions))
		@foreach($actions as $name => $method)
		@define(if (is_active_route($method)) $active = $method)
		<li>
			<a href="{{action($controller.'@'.$method)}}" @if(is_active_route($method)) class="active" @endif>{{$name}}</a>
		</li>
		@endforeach
		@endif
	</ul>
	@if(isset($active))
	<form method="get" action="{{action($controller.'@'.$active)}}">
		<input type="search" name="search" placeholder="Search..." value="{{Request::input('search') ?: ''}}">
	</form>
	<div class="logout">
		<a href="{{action($controller.'@getLogout')}}">
			Logout
		</a>
	</div>
	@endif
</nav>