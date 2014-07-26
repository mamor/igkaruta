'use strict';

angular.module('MyApp')
	.controller('KarutaCtrl', ['$scope', 'Http', '$modal', '$interval', function ($scope, Http, $modal, $interval) {
		var self = this;

		// カルタの答え
		self.expect = null;

		// 経過時間計測用の interval
		self.interval = null;

		/**
		 * $scope のプロパティを初期化する
		 */
		self.initializeScope = function () {
			$scope.loading = {users: false, photos: false};
			$scope.photos = null;
			$scope.playing = false;
			$scope.text = '';
			$scope.counter = {win: 0, lose: 0};
			$scope.time = 0;
			$scope.gameOver = false;
		};

		/**
		 * id が false ではない写真一覧を返す
		 */
		self.availablePhotos = function () {
			return _.filter($scope.photos, function (photo) { return photo.id !== false; });
		};

		/**
		 * 経過時間の計測を開始する
		 */
		self.startTimeWatch = function () {
			self.interval = $interval(function () {
				$scope.time++;
			}, 1000);
		};

		/**
		 * 経過時間の計測を停止する
		 */
		self.stopTimeWatch = function () {
			$interval.cancel(self.interval);
		};

		/**
		 * modal を開いて結果判定をする
		 */
		self.modal = function (actual) {
			var modalInstance = $modal.open({
				templateUrl: '/assets/views/modal/result.html',
				controller: 'ModalResultCtrl',
				resolve: {
					actual: function () {
						return actual;
					},
					expect: function () {
						return self.expect;
					}
				}
			});

			modalInstance.result.then(function () {}, function () {
				$scope.counter[self.expect.id === actual.id ? 'win' : 'lose']++;
				self.expect.id = false;

				$scope.gameOver = (self.availablePhotos().length === 0);

				if ($scope.gameOver) {
					return;
				}

				$scope.start();
			});
		};

		/**
		 * 社員一覧を取得する
		 */
		$scope.getPhotos = function () {
			self.initializeScope();

			var params = {};
			params.userId = $scope.userId;

			$scope.loading.photos = true;
			Http.get('/api/photos', {params: params}).then(function (photos) {
				$scope.loading.photos = false;

				$scope.photos = photos;

				angular.forEach($scope.photos, function (photo) {
					photo._id = photo.id;
				});
			});
		};

		/**
		 * カルタをスタートする
		 */
		$scope.start = function () {
			$scope.playing = true;
			self.expect = _.sample(self.availablePhotos());
			$scope.text = self.expect.caption.text;
			self.startTimeWatch();
		};

		/**
		 * カルタをストップする
		 */
		$scope.stop = function () {
			$scope.playing = false;
			self.expect = null;
			$scope.text = '';
			self.stopTimeWatch();
		};

		/**
		 * 回答処理
		 */
		$scope.answer = function (id) {
			if (! $scope.playing || ! id) {
				return;
			}

			self.stopTimeWatch();
			self.modal(_.findWhere($scope.photos, {id: id}));
		};

		/**
		 * ユーザ一覧を取得する
		 */
		(function () {
			self.initializeScope();

			$scope.users = null;
			$scope.userId = null;
			$scope.loading.users = true;
			Http.get('/api/users').then(function (users) {
				$scope.loading.users  = false;
				$scope.users = users;
				$scope.userId = users[0].id;
			});
		})();

	}]);
