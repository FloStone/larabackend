@define($model = get_class($data['model']))
<div class="form">
	<form method="post" action="{{action($controller.'@postEdit', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($model::$editable_columns as $column => $properties)
	<div class="formfield">
		<label for="{{$column}}">{{$properties['label'] ?: $column}}</label>
		@if(isset($properties['type']))

		@if($properties['type'] === 'textarea' || $properties['type'] === 'text')
			<textarea name="{{$name}}" cols="30" rows="10" value="{{$data['model']->$column}}"></textarea>
		@elseif($properties['type'] === 'password')
			<input type="password" name="{{$column}}">
		@elseif($properties['type'] === 'checkbox')
			<input type="checkbox" name="{{$column}}" {{(bool)$data['model']->$column ? 'checked' : ''}}>
		@else
			<input type="text" name="{{$column}}" value="{{$data['model']->$column}}">
		@endif

		@else
		<input type="text" name="{{$column}}" value="{{$data['model']->$column}}">
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>

</div>