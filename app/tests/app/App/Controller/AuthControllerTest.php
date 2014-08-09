<?php namespace My\App\Controller;

use Mockery as m;

/**
 * Class AuthControllerTest
 */
class AuthControllerTest extends \TestCase
{
	/**
	 * test for getLogin()
	 *
	 * @test
	 */
	public function testGetLogin()
	{
		// 実行
		$controller = \App::make('My\App\Controller\AuthController');
		/** @var \Illuminate\Http\RedirectResponse $response */
		$response = $controller->getLogin();

		$params = [
			'client_id' => getenv('INSTAGRAM_CLIENT_ID'),
			'redirect_uri' => url('/auth/callback'),
			'response_type' => 'code',
		];

		$url = 'https://api.instagram.com/oauth/authorize/?'.http_build_query($params);

		$this->assertTrue($response->getTargetUrl() === $url);
	}

	/**
	 * test for getCallback()
	 *
	 * @test
	 * @expectedException \Exception
	 */
	public function testGetCallbackInvalidCode()
	{
		\Input::replace(['code' => null]);

		// 実行
		$m = $this->getMock('My\App\Controller\AuthController', ['getAccessToken']);
		$m->expects($this->never())->method('getAccessToken');
		$m->getCallback();
	}

	/**
	 * test for getCallback()
	 *
	 * @test
	 * @expectedException \Exception
	 */
	public function testGetCallbackMissingAccessToken()
	{
		\Input::replace(['code' => 'xxx']);

		// 実行
		$m = $this->getMock('My\App\Controller\AuthController', ['getAccessToken']);
		$m->expects($this->once())->method('getAccessToken')->with('xxx')->willReturn([]);
		$m->getCallback();
	}

	/**
	 * test for getCallback()
	 *
	 * @test
	 */
	public function testGetCallback()
	{
		\Input::replace(['code' => 'xxx']);

		// モック
		\Session::shouldReceive('set')->with('accessToken', ['access_token' => 'yyy'])->once();

		// 実行
		$m = $this->getMock('My\App\Controller\AuthController', ['getAccessToken']);
		$m->expects($this->once())->method('getAccessToken')->with('xxx')->willReturn(['access_token' => 'yyy']);
		/** @var \Illuminate\Http\RedirectResponse $response */
		$response = $m->getCallback();

		$this->assertTrue($response->getTargetUrl() === url());
	}

	/**
	 * test for getLogout()
	 *
	 * @test
	 */
	public function testGetLogout()
	{
		// モック
		\Session::shouldReceive('clear')->once();

		// 実行
		$controller = \App::make('My\App\Controller\AuthController');
		/** @var \Illuminate\Http\RedirectResponse $response */
		$response = $controller->getLogout();

		$this->assertTrue($response->getTargetUrl() === url());
	}

	/**
	 * test for getAccessToken()
	 *
	 * @test
	 */
	public function testGetAccessToken()
	{
		$url = 'https://api.instagram.com/oauth/access_token/';
		$params = [
			'client_id' => getenv('INSTAGRAM_CLIENT_ID'),
			'client_secret' => getenv('INSTAGRAM_CLIENT_SECRET'),
			'redirect_uri' => url('/auth/callback'),
			'grant_type' => 'authorization_code',
			'code' => 'xxx',
		];

		// モック
		\Util::shouldReceive('curlPost')->once()->with($url, $params)->andReturn('yyy');

		// 実行
		$controller = \App::make('My\App\Controller\AuthController');
		$method = $this->getMethod($controller, 'getAccessToken');

		$actual = $method->invokeArgs($controller, ['xxx']);
		$expect = json_decode('yyy');
		$this->assertEquals($expect, $actual);
	}
}
