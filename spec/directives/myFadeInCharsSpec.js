'use strict';

describe('Directive: myFadeInChars', function () {

	beforeEach(module('MyApp'));

	var compile,
		scope,
		body;

	beforeEach(inject(function ($compile, $rootScope) {
		compile = $compile;
		scope = $rootScope.$new();
		body = angular.element(document.body);
	}));

	it('should append splitted characters with span tag', function () {
		var element;
		element = '<div my-fade-in-chars="{{ text }}" />';
		element = compile(element)(scope);
		body.append(element);

		var spans;

		scope.text = 'test';
		scope.$apply();

		spans = element.find('span');
		expect(spans.length).toBe(4);
		expect(angular.element(spans[0]).text()).toBe('t');
		expect(angular.element(spans[1]).text()).toBe('e');
		expect(angular.element(spans[2]).text()).toBe('s');
		expect(angular.element(spans[3]).text()).toBe('t');
		angular.forEach(spans, function (span) {
			expect(angular.element(span).css('display')).toBe('none');
		});

		scope.text = 'spec';
		scope.$apply();

		spans = element.find('span');
		expect(spans.length).toBe(4);
		expect(angular.element(spans[0]).text()).toBe('s');
		expect(angular.element(spans[1]).text()).toBe('p');
		expect(angular.element(spans[2]).text()).toBe('e');
		expect(angular.element(spans[3]).text()).toBe('c');
		angular.forEach(spans, function (span) {
			expect(angular.element(span).css('display')).toBe('none');
		});

		scope.text = '';
		scope.$apply();

		spans = element.find('span');
		expect(spans.length).toBe(0);

		element.remove();
	});
});
