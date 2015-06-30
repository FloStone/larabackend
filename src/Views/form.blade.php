@extends('admin.master')
@section('content')
<form action="#">
	<div class="formfield">
		<label for="text">Text</label>
		<input type="text">
	</div>
	<div class="formfield">
		<label for="password">Password</label>
		<input type="password">
	</div>
	<div class="formfield">
	<label for="textarea">Textarea</label>
	<textarea name="textarea" cols="30" rows="10">

	</textarea>
	</div>
</form>
@stop