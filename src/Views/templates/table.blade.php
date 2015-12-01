@use(Illuminate\Database\Eloquent\Collection)
@define($model = $data['model'])
@define($dest = Request::input('destination') ? Request::input('destination') == 'asc' ? 'desc' : 'asc' : 'asc')
@define($order = Request::input('order'))
<div class="table">
	<table>
		<thead>
			<tr>
				@if(!isset($model::$displayed_columns['id']))
					<th><a href="{{Request::url().'?order=id&#38;destination='.($order == 'id' ? $dest : 'asc')}}" class="{{$order == 'id' ? 'order '.$dest : ''}}">ID</a></th>
				@endif
				@foreach($model::$displayed_columns as $head => $properties)
					@if(isset($properties['label']))
						@if(isset($properties['relation']))
							<th>{{$properties['label']}}</th>
						@else
							<th><a href="{{Request::url().'?order='.$head.'&#38;destination='.($head == $order ? $dest : 'asc')}}" class="{{$order == $head ? 'order '.$dest : ''}}">{{$properties['label']}}</a></th>
						@endif
					@else
						@if(isset($properties['relation']))
							<th>{{$head}}</th>
						@else
							<th><a href="{{Request::url().'?order='.$head.'&#38;destination='.($head == $order ? $dest : 'asc')}}" class="{{$order == $head ? 'order '.$dest : ''}}">{{$head}}</a></th>
						@endif
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
							@if(isset($properties['type']))
								@if($properties['type'] == 'image')
								<td><img src="{{asset($item->$column)}}" alt="{{$properties['label']}}"></td>
								@elseif($properties['type'] == 'file')
								<td><a href="{{asset($item->$column)}}">Download</a></td>
								@else
								<td>{!! $item->$column !!}</td>
								@endif
							@else
								<td>{!! $item->$column !!}</td>
							@endif
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