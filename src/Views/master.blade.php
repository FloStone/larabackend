<!doctype html>

<html>
	
	<head>
		<link rel="stylesheet" href="{{asset('css/admin.css')}}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
	</head>

	<body>
		@include('admin.includes.navigation')
		
		@foreach($fields as $field)
		@foreach($field as $type => $data)
		@include("Backend::templates.$type", ['data' => $data])
		@endforeach
		@endforeach
	</body>

</html>