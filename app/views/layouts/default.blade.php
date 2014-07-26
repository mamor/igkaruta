<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	@include('include.assets')
</head>
<body>
@include('include.navbar')
<div class="container">
	@yield('content')
	@include('include.footer')
</div>
</body>
</html>
