<div class="table">
	<table>
		<thead>
			<tr>
			@dd($data)
			@foreach($data->first()->getOriginal() as $head => $content)
				<th>{{$head}}</th>
			@endforeach
			</tr>
		</thead>
		<tbody>
		@foreach($data as $item)
			<tr>
			@foreach($item->getOriginal() as $attr)
				<td>{{$attr}}</td>
			@endforeach
			</tr>
		@endforeach
		</tbody>
	</table>
</div>