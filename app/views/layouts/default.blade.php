<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	@include('include.assets')
</head>
<body>
@include('include.navbar')
<div class="container">
	@yield('content')
</div>
</body>
</html>
