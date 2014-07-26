<?php namespace My\App\Controller;

/**
 * Class FrontControllerTest
 */
class FrontControllerTest extends \TestCase
{
	/**
	 * test for getIndex()
	 *
	 * @test
	 */
	public function testGetIndex()
	{
		$controller = \App::make('My\App\Controller\FrontController');
		\View::shouldReceive('make')->once()->with('front');
		$controller->getIndex();
	}
}
