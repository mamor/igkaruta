'use strict';

angular.module('MyApp')
	.controller('ModalResultCtrl', ['$scope', 'actual', 'expect', function ($scope, actual, expect) {
		$scope.actual = actual;
		$scope.expect = expect;
	}]);
