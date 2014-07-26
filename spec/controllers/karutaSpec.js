'use strict';

describe('Controller: KarutaCtrl', function () {

	beforeEach(module('MyApp'));

	var KarutaCtrl,
		scope,
		modal,
		httpBackend;

	beforeEach(inject(function ($controller, $rootScope, _$httpBackend_, $modal) {
		httpBackend = _$httpBackend_;
		modal = $modal;
		httpBackend.expectGET('/api/users').respond([{id: 1}, {id: 2}]);

		scope = $rootScope.$new();
		KarutaCtrl = $controller('KarutaCtrl', {
			$scope: scope,
			modal: modal
		});
	}));

	describe('initialize', function () {
		it('should set values for $scope', function () {
			// initializeScope() でセットされる
			expect(scope.photos).toBe(null);
			expect(scope.playing).toBe(false);
			expect(scope.text).toBe('');
			expect(scope.counter).toEqual({win: 0, lose: 0});
			expect(scope.time).toBe(0);
			expect(scope.gameOver).toBe(false);

			// /api/users の完了前の状態
			expect(scope.loading).toEqual({users: true, photos: false});
			expect(scope.users).toBe(null);
			expect(scope.userId).toBe(null);

			// /api/users の完了後の状態
			httpBackend.flush();
			expect(scope.loading).toEqual({users: false, photos: false});
			expect(scope.users).toEqual([{id: 1}, {id: 2}]);
			expect(scope.userId).toBe(1);
		});
	});

	describe('initializeScope()', function () {
		it('should set values for $scope', function () {
			delete scope.loading;
			delete scope.photos;
			delete scope.playing;
			delete scope.text;
			delete scope.counter;
			delete scope.time;
			delete scope.gameOver;

			KarutaCtrl.initializeScope();

			expect(scope.loading).toEqual({users: false, photos: false});
			expect(scope.photos).toBe(null);
			expect(scope.playing).toBe(false);
			expect(scope.text).toBe('');
			expect(scope.counter).toEqual({win: 0, lose: 0});
			expect(scope.time).toBe(0);
			expect(scope.gameOver).toBe(false);
		});
	});

	describe('availablePhotos()', function () {
		it('should return photos that id is not false', function () {
			scope.photos = [
				{id: 1, name: 'foo'},
				{id: false, name: 'bar'},
				{id: false, name: 'baz'},
				{id: 2, name: 'qux'},
			];

			var $actual = KarutaCtrl.availablePhotos();
			var $expect = [{id: 1, name: 'foo'}, {id: 2, name: 'qux'}];

			expect($actual).toEqual($expect);
		});
	});

	describe('startTimeWatch() and stopTimeWatch()', function () {
		it('should start and stop increment $scope.time', inject(function ($interval) {
			expect(scope.time).toBe(0);

			// 計測開始
			KarutaCtrl.startTimeWatch();

			$interval.flush(1000);
			expect(scope.time).toBe(1);

			$interval.flush(1000);
			expect(scope.time).toBe(2);

			// 計測終了
			KarutaCtrl.stopTimeWatch();

			$interval.flush(1000);
			expect(scope.time).toBe(2);
		}));
	});

	describe('modal()', function () {
		var fakeModal;

		beforeEach(function () {
			// @see http://stackoverflow.com/questions/21214868/angularjs-ui-bootstrap-mocking-modal-in-unit-test
			fakeModal = {
				result: {
					then: function(confirmCallback, cancelCallback) {
						//Store the callbacks for later when the user clicks on the OK or Cancel button of the dialog
						this.confirmCallBack = confirmCallback;
						this.cancelCallback = cancelCallback;
					}
				},
				close: function( item ) {
					//The user clicked OK on the modal dialog, call the stored confirm callback with the selected item
					this.result.confirmCallBack( item );
				},
				dismiss: function( type ) {
					//The user clicked cancel on the modal dialog, call the stored cancel callback
					this.result.cancelCallback( type );
				}
			};

			spyOn(modal, 'open').andReturn(fakeModal);
			spyOn(scope, 'start');

			scope.playing = true;
			KarutaCtrl.expect = {id: 1};
		});

		it('should open modal for result - win and availablePhotos length is not 0', function () {
			spyOn(KarutaCtrl, 'availablePhotos').andReturn([{id: 100}]);

			// modal を開く
			KarutaCtrl.modal({id: 1});
			expect(modal.open).toHaveBeenCalledWith(jasmine.any(Object));

			// dismiss() する
			scope.counter = {win: 0, lose: 0};
			fakeModal.dismiss();

			expect(scope.counter).toEqual({win: 1, lose: 0});
			expect(KarutaCtrl.expect.id).toBe(false);
			expect(scope.start).toHaveBeenCalled();
		});

		it('should open modal for result - lose and availablePhotos length is 0', function () {
			spyOn(KarutaCtrl, 'availablePhotos').andReturn([]);

			// modal を開く
			KarutaCtrl.modal({id: 2});
			expect(modal.open).toHaveBeenCalledWith(jasmine.any(Object));

			// dismiss() する
			scope.counter = {win: 0, lose: 0};
			fakeModal.dismiss();

			expect(scope.counter).toEqual({win: 0, lose: 1});
			expect(KarutaCtrl.expect.id).toBe(false);
			expect(scope.start).not.toHaveBeenCalled();
		});
	});

	describe('$scope.getPhotos()', function () {
		it('should get photos from server', function () {
			spyOn(KarutaCtrl, 'initializeScope');

			scope.userId = 100;
			httpBackend.expectGET('/api/photos?userId=100').respond([{id: 1}, {id: 2}]);

			// /api/photos の完了前の状態
			scope.loading = {photos: false};
			scope.photos = null;

			// 実行
			scope.getPhotos();
			expect(scope.loading.photos).toBe(true);
			expect(KarutaCtrl.initializeScope).toHaveBeenCalled();

			// /api/photos の完了後の状態
			httpBackend.flush();
			expect(scope.loading.photos).toBe(false);
			expect(scope.photos).toEqual([{id: 1, _id: 1}, {id: 2, _id: 2}]);
		});
	});

	describe('$scope.start()', function () {
		it('should start KARUTA', function () {
			spyOn(KarutaCtrl, 'availablePhotos').andReturn([{caption: {text: 'xxx'}}]);
			spyOn(KarutaCtrl, 'startTimeWatch');

			scope.playing = false;
			KarutaCtrl.expect = null;
			scope.text = '';

			scope.start();

			expect(scope.playing).toBe(true);
			expect(KarutaCtrl.expect).toEqual({caption: {text: 'xxx'}});
			expect(scope.text).toBe('xxx');
			expect(KarutaCtrl.startTimeWatch).toHaveBeenCalled();
		});
	});

	describe('$scope.stop()', function () {
		it('should stop KARUTA', function () {
			spyOn(KarutaCtrl, 'stopTimeWatch');

			scope.playing = true;
			KarutaCtrl.expect = 'expect';
			scope.text = 'xxx';

			scope.stop();

			expect(scope.playing).toBe(false);
			expect(KarutaCtrl.expect).toBe(null);
			expect(scope.text).toBe('');
			expect(KarutaCtrl.stopTimeWatch).toHaveBeenCalled();
		});
	});

	describe('$scope.answer()', function () {
		it('should do nothing if $scope.playing is false or id is false', function () {
			spyOn(KarutaCtrl, 'stopTimeWatch');

			scope.playing = false;
			scope.answer(false);

			scope.playing = true;
			scope.answer(false);

			scope.playing = false;
			scope.answer(1);

			expect(KarutaCtrl.stopTimeWatch).not.toHaveBeenCalled();
		});

		it('should call stopTimeWatch() and modal() if $scope.playing is true and id is not false', function () {
			spyOn(KarutaCtrl, 'stopTimeWatch');
			spyOn(KarutaCtrl, 'modal');

			scope.photos = [{id: 1}, {id: 2}, {id: 3}];
			scope.playing = true;
			scope.answer(2);

			expect(KarutaCtrl.stopTimeWatch).toHaveBeenCalled();
			expect(KarutaCtrl.modal).toHaveBeenCalledWith({id: 2});
		});
	});
});
