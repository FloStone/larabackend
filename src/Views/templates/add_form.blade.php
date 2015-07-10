@use(Flo\Backend\Classes\HTMLTranslator)
<div class="form">
	<form method="post" action="{{action($controller.'@postAdd', ['model' => class_replace($data['model'])])}}">
	@foreach($data['formfields'] as $column => $properties)
	<div class="formfields">
		<label for="{{$column}}">{{isset($properties['label']) ? $properties['label'] : $column}}</label>
		@if(isset($properties['relation']))
		@else
		{!! HTMLTranslator::make(isset($properties['type']) ? $properties['type'] : null, $column) !!}
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>
</div>