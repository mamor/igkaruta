<?php namespace My\App\Controller;

/**
 * Class IndexControllerTest
 */
class IndexControllerTest extends \TestCase
{
	/**
	 * test for getIndex()
	 *
	 * @test
	 */
	public function testGetIndex()
	{
		$controller = \App::make('My\App\Controller\IndexController');
		\View::shouldReceive('make')->once()->with('index');
		$controller->getIndex();
	}
}
