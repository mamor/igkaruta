<?php namespace My\Core;

/**
 * Class Util
 */
class Util
{
	public function __construct()
	{
	}

	/**
	 * @param  string $fileName
	 * @return string
	 */
	public function fileGetContents($fileName)
	{
		return file_get_contents($fileName);
	}

	/**
	 * @param  string $fileName
	 * @param  string $data
	 * @return int
	 */
	public function filePutContents($fileName, $data)
	{
		return file_put_contents($fileName, $data);
	}

	/**
	 * @param  string $url
	 * @param  array $params
	 * @return string
	 */
	public function curlGet($url, array $params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/**
	 * @param  string $url
	 * @param  array $params
	 * @return string
	 */
	public function curlPost($url, array $params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
}
