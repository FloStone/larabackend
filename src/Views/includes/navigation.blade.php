<nav>
	<ul>
		@foreach($actions as $name => $method)
		<li>
			<a href="{{action('AdminController@'.$method)}}" @if(is_active_route($method)) class="active" @endif>{{$name}}</a>
		</li>
		@endforeach
	</ul>
	<input type="search" name="search" placeholder="Search...">
</nav>