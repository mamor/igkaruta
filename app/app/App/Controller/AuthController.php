<?php namespace My\App\Controller;

/**
 * 認証コントローラ
 *
 * Class AuthController
 */
class AuthController extends AppController
{
	/**
	 * ログイン画面に遷移する
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogin()
	{
		$params = [
			'client_id' => getenv('INSTAGRAM_CLIENT_ID'),
			'redirect_uri' => url('/auth/callback'),
			'response_type' => 'code',
		];

		$url = 'https://api.instagram.com/oauth/authorize/?'.http_build_query($params);

		return \Redirect::to($url);
	}

	/**
	 * ログイン時のコールバック
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function getCallback()
	{
		// code が取得できなければエラー
		$code = \Input::get('code');
		if (! $code) {
			throw new \Exception('Invalid access.');
		}

		// アクセストークンが取得できなければエラー
		$accessToken = $this->getAccessToken($code);

		if (! array_get($accessToken, 'access_token')) {
			throw new \Exception('Missing access token.');
		}

		// アクセストークンをセッションにセットする
		\Session::set('accessToken', $accessToken);

		return \Redirect::to('');
	}

	/**
	 * ログアウトする
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogout()
	{
		\Session::clear();

		return \Redirect::to('');
	}

	/**
	 * アクセストークンを返す
	 *
	 * @param  string $code
	 * @return array
	 */
	protected function getAccessToken($code)
	{
		$url = 'https://api.instagram.com/oauth/access_token/';

		$params = [
			'client_id' => getenv('INSTAGRAM_CLIENT_ID'),
			'client_secret' => getenv('INSTAGRAM_CLIENT_SECRET'),
			'redirect_uri' => url('/auth/callback'),
			'grant_type' => 'authorization_code',
			'code' => $code,
		];

		return json_decode(\Util::curlPost($url, $params), true);
	}
}
