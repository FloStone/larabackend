<div class="form">
	<form method="post" action="{{action('AdminController@postEdit', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($data['formfields'] as $type => $name)
	<div class="formfields">
		<label for="{{$name}}">{{$name}}</label>
		@if($type === 'textarea')
		<textarea name="{{$name}}" cols="30" rows="10" value="{{$data['model']->$name}}"></textarea>
		@elseif($type === 'password')
		<input type="password" name="{{$name}}">
		@else
		<input type="text" name="{{$name}}" value="{{$data['model']->$name}}">
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>
</div>