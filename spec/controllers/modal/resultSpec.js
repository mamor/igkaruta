'use strict';

describe('Controller: ModalResultCtrl', function () {

	beforeEach(module('MyApp'));

	var ModalResultCtrl,
		scope;

	beforeEach(inject(function ($controller, $rootScope) {
		scope = $rootScope.$new();
		ModalResultCtrl = $controller('ModalResultCtrl', {
			$scope: scope,
			actual: 'actual',
			expect: 'expect'
		});
	}));

	describe('initialize', function () {
		it('should set values for $scope', function () {
			expect(scope.actual).toBe('actual');
			expect(scope.expect).toBe('expect');
		});
	});
});
