@use(Illuminate\Database\Eloquent\Collection)
@define($model = $data['model'])
<div class="table">
	<table>
		<thead>
			<tr>
				@if(!isset($model::$displayed_columns['id']))
				<th>ID</th>
				@endif
				@foreach($model::$displayed_columns as $head => $properties)
				@if(isset($properties['label']))
				<th>{{$properties['label']}}</th>
				@else
				<th>{{$head}}</th>
				@endif
				@endforeach
				@if($data['editable'])
				@if($data['data']->first())
				<th class="editable">Edit</th>
				<th class="editable">Delete</th>
				@endif
				@endif
			</tr>
		</thead>
		<tbody>
			@if($data['editable'])
			<tr>
				<td>
					<a href="{{action($controller.'@getAdd', ['model' => class_replace($model)])}}">Add</a>
				</td>
				@if($data['data']->first())
				@foreach($model::$displayed_columns as $item)
				<td></td>	
				@endforeach
				<td></td>
				<td></td>
				@endif
			</tr>
			@endif
			@if($data['data']->first())
			@foreach($data['data'] as $item)
			<tr>
				<td>{{$item->id}}</td>
				@foreach($model::$displayed_columns as $column => $properties)
				@if(isset($properties['relation']))
					@define($relation = $item->$properties['relation']['method'])
					@if($relation instanceof Collection)
					<td>
					@foreach($relation as $related)
					{{$related->toArray()[$properties['relation']['display']]}}<br>
					@endforeach
					</td>
					@else
					{{$relation->toArray()[$properties['relation']['display']]}}<br>
					@endif
				@else
				<td>{{$item->$column}}</td>
				@endif
				@endforeach
				@if($data['editable'])
				<td class="editable"><a href="{{action($controller.'@getEdit', ['id' => $item->id, 'model' => class_replace($model)])}}">Edit</a></td>
				<td class="editable"><a href="{{action($controller.'@getDelete', ['id' => $item->id, 'model' => class_replace($model)])}}">Delete</a></td>
				@endif
			</tr>
			@endforeach
			@endif
		</tbody>
	</table>
	<div class="pagination-container">
		{!!$data['data']->appends(Request::input())->render()!!}
	</div>
</div>