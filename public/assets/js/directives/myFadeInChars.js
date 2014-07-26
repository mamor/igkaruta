'use strict';

angular.module('MyApp')
	.directive('myFadeInChars', [function () {
		return {
			link: function (scope, element, attrs) {
				var delay = attrs.delay || 200;

				attrs.$observe('myFadeInChars', function (myFadeInChars) {
					element.find('span').remove();

					var chars = myFadeInChars.split('');
					angular.forEach(chars, function (char) {
						var span = angular.element('<span/>').text(char).hide();
						element.append(span);
					});

					element.find('span').each(function (index) {
						angular.element(this).delay(index * delay).fadeIn();
					});
				});
			}
		};
	}]);
