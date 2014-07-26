<?php namespace My\App\Filter;

/**
 * Class AuthFilterTest
 */
class AuthFilterTest extends \TestCase
{
	/**
	 * test for filter()
	 *
	 * @test
	 */
	public function testFilter()
	{
		\Session::shouldReceive('get')->once()->with('accessToken', [])->andReturn(['access_token' => 'xxx']);
		(new AuthFilter)->filter();
		$this->assertTrue(true);
	}

	/**
	 * test for filter()
	 *
	 * @test
	 * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function testFilterNotAuthorized()
	{
		\Session::shouldReceive('get')->once()->with('accessToken', [])->andReturn(null);
		(new AuthFilter)->filter();
	}
}
