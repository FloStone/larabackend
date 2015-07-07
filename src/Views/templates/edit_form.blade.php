@use(Flo\Backend\Classes\HTMLTranslator)
@define($model = get_class($data['model']))
<div class="form">
	<form method="post" action="{{action($controller.'@postEdit', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($model::$editable_columns as $column => $properties)
	<div class="formfield">
		<label for="{{$column}}">{{isset($properties['label']) ? $properties['label'] : $column}}</label>
		{!! HTMLTranslator::make(isset($properties['type']) ? $properties['type'] : null, $column, $data['model']->$column) !!}
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Save" class="submit-button">
	</form>

</div>