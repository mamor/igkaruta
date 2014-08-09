<?php namespace My\App\Filter;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthFilter
 */
class AuthFilter
{
	/**
	 * アクセストークンが取得できなければエラー
	 *
	 * @throws NotFoundHttpException
	 */
	public function filter()
	{
		$accessToken = \Session::get('accessToken', []);
		if (! array_get($accessToken, 'access_token')) {
			throw new NotFoundHttpException;
		}
	}
}
