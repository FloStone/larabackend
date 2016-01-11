<!doctype html>

<html>

	<head>
		<link rel="stylesheet" href="{{asset('css/admin.css')}}">
		<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
		<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
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
		@yield('content')
		@include('Backend::includes.footer')
	</body>

	<script>
	$(document).ready(function(){
		tinymce.init({
			selector: "textarea",
			menubar: false,
			plugins: "code link textcolor directionality image",
			toolbar: [
				"undo redo cut copy paste | fontsizeselect | forecolor backcolor ",
				"code | link unlink | ltr rlt | image"
			]
		})
	})
	</script>

</html>