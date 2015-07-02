@define($model = get_class($data['model']))
<div class="form">
<h2>Are you sure you want to delete this ?</h2>
	<form method="post" action="{{action('AdminController@postDelete', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($model::$displayed_columns as $column => $properties)
	<div class="formfield">
		<label for="{{$column}}">{{$properties['label'] ?: $column}}:</label>
		<br>
		<p>{{$data['model']->$column}}</p>
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Delete" class="submit-button">
	</form>
</div>