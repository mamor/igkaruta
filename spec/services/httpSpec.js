'use strict';

describe('Service: Http', function () {

	beforeEach(module('MyApp'));

	var Http,
		httpBackend;

	beforeEach(inject(function (_Http_, _$httpBackend_) {
		Http = _Http_;
		httpBackend = _$httpBackend_;
	}));

	describe('get()', function () {
		it('should call $http.get()', function () {
			httpBackend.whenGET('http://example.com/?key=value').respond('response');

			var _response = null;
			Http.get('http://example.com/', {params: {key: 'value'}}).then(function (response) {
				_response = response;
			});

			expect(_response).toBe(null);
			httpBackend.flush();
			expect(_response).toBe('response');
		});
	});
});
