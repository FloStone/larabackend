<div class="form">
<h2>Are you sure you want to delete this ?</h2>
	<form method="post" action="{{action('AdminController@postDelete', ['id' => $data['model']->id, 'model' => class_replace(get_class($data['model']))])}}">
	@foreach($data['model']->getOriginal() as $column => $value)
	<div class="formfields">
		<label for="{{$column}}">{{$column}}</label>
		@if($type == 'textarea' || $type === 'text')
		<textarea name="{{$column}}" cols="30" rows="10" disabled="disabled">{{$value}}</textarea>
		@elseif($type == 'password')
		@else
		<input type="text", name="{{$column}}" value="{{$value}}" disabled="disabled">
		@endif
	</div>
	@endforeach
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="submit" value="Delete" class="submit-button">
	</form>
</div>