@use(Illuminate\Support\Collection)
@use(Illuminate\Database\Eloquent\Collection as EloquentCollection)
@use(Illuminate\Database\Eloquent\Model)
@use(Flo\Backend\Classes\Recombinator)
@define($model = get_class($data['model']))
<div class="form">
<h2>Are you sure you want to delete this ?</h2>
	<form method="post" action="{{action($controller.'@postDelete', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($model::$displayed_columns as $column => $properties)
	<div class="formfield">
		<label for="{{$column}}">{{$properties['label'] ?: $column}}:</label>
		<br>
		@if(isset($properties['relation']))
		@if($data['model']->$column instanceof EloquentCollection or $data['model']->$column instanceof Collection)
		<p>
		@foreach($data['model']->$column as $item)
		{{Recombinator::getFirstArrayEntry($item)}}<br>
		@endforeach
		</p>
		@else
		<p>{{Recombinator::getFirstArrayEntry($data['model']->$column)}}</p>
		@endif
		@else
		<p>{{$data['model']->$column}}</p>
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Delete" class="submit-button">
	</form>
</div>