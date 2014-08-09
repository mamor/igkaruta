<?php namespace My\App;

/**
 * Instagram API 実行クラス
 *
 * Class Instagram
 */
class Instagram
{
	/**
	 * v1/users/%s/follows を実行する
	 *
	 * @param  array $accessToken
	 * @return array
	 */
	public function getFollows(array $accessToken)
	{
		$format = 'https://api.instagram.com/v1/users/%s/follows';
		$url = sprintf($format, $accessToken['user']['id']);
		$params = ['access_token' => $accessToken['access_token']];

		$response = \Util::curlGet($url, $params);

		return json_decode($response, true)['data'];
	}

	/**
	 * v1/users/%s/media/recent を実行する
	 *
	 * @param  array $accessToken
	 * @param  int $userId
	 * @return array
	 */
	public function getMediaRecent(array $accessToken, $userId)
	{
		$format = 'https://api.instagram.com/v1/users/%s/media/recent';
		$url = sprintf($format, $userId);
		$params = ['access_token' => $accessToken['access_token']];

		return $this->getPhotos($url, $params);
	}

	/**
	 * 写真一覧を取得する
	 *
	 * @param  string $url
	 * @param  array $params
	 * @param  int $limit
	 * @return array
	 */
	protected function getPhotos($url, array $params, $limit = 100)
	{
		$ret = [];

		do {
			// 写真一覧を取得する
			$response = \Util::curlGet($url, $params);
			$photos = json_decode($response, true);

			foreach (array_get($photos, 'data', []) as $photo) {
				// caption.text の無い写真は飛ばす
				if (! array_get($photo, 'caption.text')) {
					continue;
				}

				$ret[] = $photo;

				// 指定数に達したら終了する
				if (count($ret) === $limit) {
					break 2;
				}
			}

			// 次のページがあれば再実行する
			$url = array_get($photos, 'pagination.next_url', false);
		} while ($url);

		return $ret;
	}
}
