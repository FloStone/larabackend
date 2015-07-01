<!doctype html>

<html>
	
	<head>
		<link rel="stylesheet" href="{{asset('css/admin.css')}}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
		<meta charset="utf-8">
	</head>
	<body>
		@include('Backend::includes.navigation')

		@if(isset($fields))
		@foreach($fields as $field)
		@if(isset($field['custom']))
		@include($field['custom'], $field['data'])
		@else
			@foreach($field as $type => $data)
				@include("Backend::templates.$type", ['data' => $data])
			@endforeach
		@endif
		@endforeach
		@endif
	</body>

</html>