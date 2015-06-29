<!doctype html>

<html>
	
	<head>
		<link rel="stylesheet" href="{{asset('css/admin.css')}}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
	</head>

	<body>
		@include('admin.includes.navigation')
		@yield('content')
	</body>

</html>