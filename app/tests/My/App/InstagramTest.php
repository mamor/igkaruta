<?php namespace My\App;

/**
 * Class InstagramTest
 */
class InstagramTest extends \TestCase
{
	/**
	 * test for getFollows()
	 *
	 * @test
	 */
	public function testGetFollows()
	{
		$params = ['access_token' => 'xxx'];

		// モック
		\Util::shouldReceive('curlGet')
			->once()->with('https://api.instagram.com/v1/users/111/follows', $params)->andReturn(json_encode(['data' => ['xxx', 'yyy']]));

		// 実行
		$ig = new Instagram;
		$accessToken = ['access_token' => 'xxx', 'user' => ['id' => 111]];
		$actual = $ig->getFollows($accessToken);
		$expect = ['xxx', 'yyy'];
		$this->assertEquals($expect, $actual);
	}

	/**
	 * test for getMediaRecent()
	 *
	 * @test
	 */
	public function testGetMediaRecent()
	{
		$url = 'https://api.instagram.com/v1/users/111/media/recent';
		$params = ['access_token' => 'xxx'];

		// モック
		$m = $this->getMock('My\App\Instagram', ['getPhotos']);
		$m->expects($this->once())->method('getPhotos')->with($url, $params)->willReturn('photos');

		// 実行
		$accessToken = [
			'access_token' => 'xxx',
			'user' => ['id' => 111]
		];

		$photos = $m->getMediaRecent($accessToken, 111);
		$this->assertTrue($photos === 'photos');
	}

	/**
	 * test for getPhotos()
	 *
	 * @test
	 */
	public function testGetPhotos()
	{
		// Util::curlGet 1回目のモック
		$url = 'http://example.com';
		$params = ['access_token' => 'xxx'];
		$photos = [
			'pagination' => ['next_url' => 'http://example.com?page=1'],
			'data' => [
				['caption' => ['text' => 'yyy']],
				['caption' => []],
				['caption' => ['text' => 'zzz']],
			],
		];

		\Util::shouldReceive('curlGet')
			->once()->with($url, $params)->andReturn(json_encode($photos));

		// Util::curlGet 2回目のモック
		$photos = [
			'pagination' => ['next_url' => 'http://example.com?page=2'],
			'data' => [
				['caption' => ['text' => 'aaa']],
				['caption' => []],
				['caption' => ['text' => 'bbb']],
			],
		];

		\Util::shouldReceive('curlGet')
			->once()->with('http://example.com?page=1', $params)->andReturn(json_encode($photos));

		// Util::curlGet 3回目のモック
		$photos = [
			'pagination' => [],
			'data' => [
				['caption' => ['text' => 'ccc']],
				['caption' => []],
				['caption' => ['text' => 'ddd']],
			],
		];

		\Util::shouldReceive('curlGet')
			->once()->with('http://example.com?page=2', $params)->andReturn(json_encode($photos));

		// 実行
		$ig = new Instagram;
		$method = $this->getMethod($ig, 'getPhotos');

		$actual = $method->invokeArgs($ig, [$url, $params]);
		$expect = [
			['caption' => ['text' => 'yyy']],
			['caption' => ['text' => 'zzz']],
			['caption' => ['text' => 'aaa']],
			['caption' => ['text' => 'bbb']],
			['caption' => ['text' => 'ccc']],
			['caption' => ['text' => 'ddd']],
		];
		$this->assertEquals($expect, $actual);
	}

	/**
	 * test for getPhotos()
	 *
	 * @test
	 */
	public function testGetPhotosOverLimit()
	{
		$url = 'http://example.com';
		$params = ['access_token' => 'xxx'];
		$photos = [
			'pagination' => ['next_url' => 'http://example.com?page=1'],
			'data' => array_pad([], 100, ['caption' => ['text' => 'yyy']]),
		];

		// モック
		\Util::shouldReceive('curlGet')
			->once()->with($url, $params)->andReturn(json_encode($photos));

		// 実行
		$ig = new Instagram;
		$method = $this->getMethod($ig, 'getPhotos');
		$actual = $method->invokeArgs($ig, [$url, $params, 75]);
		$expect = array_pad([], 75, ['caption' => ['text' => 'yyy']]);
		$this->assertEquals($expect, $actual);
	}
}
