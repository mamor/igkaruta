<?php namespace My\App\Controller;

use Mockery as m;

/**
 * Class ApiControllerTest
 */
class ApiControllerTest extends \TestCase
{
	/**
	 * test for getUsers()
	 *
	 * @test
	 */
	public function testGetUsers()
	{
		$accessToken = ['xxx' => 'yyy', 'user' => ['username' => 'mamor']];
		$users = [['username' => 'mamor'], ['username' => 'angularjs'], ['username' => 'laravel']];

		// Instagram のインスタンスを差し替える
		$ig = m::mock('My\App\Instagram[getFollows]');
		$ig->shouldReceive('getFollows')
			->once()->with($accessToken)->andReturn([['username' => 'laravel'], ['username' => 'angularjs']]);
		\App::instance('My\App\Instagram', $ig);

		// モック
		\Session::shouldReceive('get')->once()->with('users')->andReturn(null);
		\Session::shouldReceive('get')->once()->with('accessToken')->andReturn($accessToken);
		\Session::shouldReceive('set')->once()->with('users', $users);

		// 実行
		$controller = \App::make('My\App\Controller\ApiController');
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $controller->getUsers();

		$this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);

		$actual = $response->getContent();
		$expect = json_encode($users);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * test for getUsers()
	 *
	 * @test
	 */
	public function testGetUsersFromSession()
	{
		$users = [['username' => 'mamor'], ['username' => 'angularjs'], ['username' => 'laravel']];

		// モック
		\Session::shouldReceive('get')->once()->with('users')->andReturn($users);
		\Session::shouldReceive('get')->never()->with('accessToken');

		// 実行
		$controller = \App::make('My\App\Controller\ApiController');
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $controller->getUsers();

		$this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);

		$actual = $response->getContent();
		$expect = json_encode($users);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * test for getPhotos()
	 *
	 * @test
	 */
	public function testGetPhotos()
	{
		$accessToken = ['xxx' => 'yyy', 'user' => ['username' => 'mamor']];

		// Instagram のインスタンスを差し替える
		$ig = m::mock('My\App\Instagram[getMediaRecent]');
		$ig->shouldReceive('getMediaRecent')->once()->with($accessToken, 'zzz')->andReturn(array_pad([], 100, 'aaa'));
		\App::instance('My\App\Instagram', $ig);

		// モック
		\Session::shouldReceive('get')->with('accessToken')->andReturn($accessToken);
		\Input::shouldReceive('input')->once()->with('userId', '')->andReturn('zzz');

		// 実行
		$controller = \App::make('My\App\Controller\ApiController');
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = $controller->getPhotos();

		$this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
		$this->assertTrue($response->getContent() === json_encode(array_pad([], 24, 'aaa')));
	}
}
