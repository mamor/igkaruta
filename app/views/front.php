<!doctype html>
<html lang="ja" ng-app="MyApp">
<head>
	<meta charset="UTF-8">
	<title>KARUTA</title>
	<?php echo View::make('include.assets'); ?>
	<!-- AngularJS -->
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.20/angular.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular-route.min.js"></script>
	<!-- AngularUI Bootstrap -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.0/ui-bootstrap-tpls.min.js"></script>
	<!-- Underscore.js -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script>
	<!-- app -->
	<script src="/assets/js/app.js"></script>
	<script src="/assets/js/services/http.js"></script>
	<script src="/assets/js/directives/myFadeInChars.js"></script>
	<script src="/assets/js/controllers/karuta.js"></script>
	<script src="/assets/js/controllers/modal/result.js"></script>
</head>
<body>
<?php echo View::make('include.navbar'); ?>
<div class="container">
	<div ng-view></div>
</div>
</body>
</html>
