<div class="table">
	<table>
		<thead>
			<tr>
				@foreach($data[0]->first()->getOriginal() as $head => $content)
				<th>{{$head}}</th>
				@endforeach
				@if($data['editable'])
				<th>Edit</th>
				<th>Delete</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@if($data['editable'])
			<tr>
				<td>
					<a href="{{action('AdminController@getAdd', ['model' => class_replace(get_class($data[0]->first()))])}}">Add</a>
				</td>
				@foreach($data[0]->first()->getOriginal() as $item)
				<td></td>	
				@endforeach
				<td></td>
			</tr>
			@endif
			@foreach($data[0] as $item)
			<tr>
				@foreach($item->getOriginal() as $attr)
				<td>{{$attr}}</td>
				@endforeach
				@if($data['editable'])
				<td><a href="{{action('AdminController@getEdit', ['id' => $item->id, 'model' => class_replace(get_class($item))])}}">Edit</a></td>
				<td><a href="{{action('AdminController@getDelete', ['id' => $item->id, 'model' => class_replace(get_class($item))])}}">Delete</a></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>