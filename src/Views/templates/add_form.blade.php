<div class="form">
	<form method="post" action="{{action('AdminController@postAdd', ['model' => class_replace($data['model'])])}}">
	@foreach($data['formfields'] as $type => $name)
	<div class="formfields">
		<label for="{{$name}}">{{$name}}</label>
		@if($type === 'textarea' || $type === 'text')
		<textarea name="{{$name}}" cols="30" rows="10"></textarea>
		@elseif($type === 'password')
		<input type="password" name="{{$name}}">
		@else
		<input type="text", name="{{$name}}">
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>
</div>