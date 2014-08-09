<?php namespace My\App\Controller;

use My\App\Instagram;

/**
 * APIコントローラ
 *
 * Class ApiController
 */
class ApiController extends AppController
{
	/**
	 * @var Instagram
	 */
	protected $ig;

	public function __construct(Instagram $ig)
	{
		$this->ig = $ig;
	}

	/**
	 * ログインユーザとフォローしているユーザの一覧を返す
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getUsers()
	{
		// セッションがあれば返す
		if ($users = \Session::get('users')) {
			return \Response::json($users);
		}

		// フォローしているユーザを取得する
		$accessToken = \Session::get('accessToken');
		$users = $this->ig->getFollows($accessToken);

		// username でソートする
		$users = array_sort($users, function ($user) {
			return $user['username'];
		});

		// ログインユーザを先頭に加える
		array_unshift($users, $accessToken['user']);

		// セッションにセットする
		\Session::set('users', $users);

		return \Response::json($users);
	}

	/**
	 * 指定ユーザの画像一覧を返す
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPhotos()
	{
		$userId = \Input::get('userId');
		$accessToken = \Session::get('accessToken');

		$photos = $this->ig->getMediaRecent($accessToken, $userId);

		shuffle($photos);

		return \Response::json(array_slice($photos, 0, 24));
	}
}
