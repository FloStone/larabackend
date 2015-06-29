<nav>
	<ul>
		@foreach(App\Http\Controllers\AdminController::$displayed_actions as $name => $method)
		<li>
			<a href="{{action('AdminController@'.$method)}}" @if(is_active_route($method)) class="active" @endif>{{$name}}</a>
		</li>
		@endforeach
	</ul>
</nav>