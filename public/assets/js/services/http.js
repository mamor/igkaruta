'use strict';

angular.module('MyApp')
	.service('Http', ['$http', '$q', function ($http, $q) {
		var self = this;

		/**
		 * @param  {string} url
		 * @param  {object} options
		 * @return {object} promise
		 */
		self.get = function (url, options) {
			var deferred = $q.defer();

			var _options = options ? angular.copy(options) : {};

			$http.get(url, _options).success(function (response) {
				deferred.resolve(response);
			}).error(function (response) {
				deferred.reject(response);
			});

			return deferred.promise;
		};
	}]);
