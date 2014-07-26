'use strict';

angular
	.module('MyApp', [
		'ngRoute',
		'ui.bootstrap'
	])
	.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
		$locationProvider.html5Mode(true);

		$routeProvider
			.when('/karuta', {
				templateUrl: '/assets/views/karuta.html',
				controller: 'KarutaCtrl'
			})
			.otherwise({
				redirectTo: function () {
					window.location.href = window.location.href;
				}
			});
	}]);
