<nav>
	<ul>
		@foreach($actions as $name => $method)
		<?php if (is_active_route($method)) $active = $method; ?>
		<li>
			<a href="{{action('AdminController@'.$method)}}" @if(is_active_route($method)) class="active" @endif>{{$name}}</a>
		</li>
		@endforeach
	</ul>
	@if(isset($active))
	<form method="get" action="{{action('AdminController@'.$active)}}">
		<input type="search" name="search" placeholder="Search...">
	</form>
	@endif
</nav>