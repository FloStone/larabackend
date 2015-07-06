@use(Flo\Backend\HTMLTranslator)
<div class="form">
	<form method="post" action="{{action($controller.'@postAdd', ['model' => class_replace($data['model'])])}}">
	@foreach($data['formfields'] as $column => $properties)
	<div class="formfields">
		<label for="{{$column}}">{{$properties['label'] ?: $type}}</label>
		@if($properties['type'] === 'textarea' || $properties['type'] === 'text')
		<textarea name="{{$column}}" cols="30" rows="10">
		</textarea>
		@elseif($properties['type'] === 'password')
		<input type="password" name="{{$column}}">
		@else
		<input type="text" name="{{$column}}">
		@endif
		{!! HTMLTranslator::make($properties['type'], $column) !!}
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>
</div>