<?php namespace My\Core\Filter;

use \Illuminate\Session\TokenMismatchException;

/**
 * Class CSRFFilterTest
 */
class CSRFFilterTest extends \TestCase
{
	/**
	 * test for filter()
	 *
	 * excluded methods
	 *
	 * @test
	 */
	public function testFilterExcludedMethods()
	{
		$methods = ['GET', 'DELETE'];

		foreach ($methods as $method) {
			\Input::shouldReceive('getMethod')->once()->andReturn($method);
			\Input::shouldReceive('input')->never();
			\Session::shouldReceive('token')->never();

			try {
				(new CsrfFilter)->filter();
				$this->assertTrue(true);
			} catch (TokenMismatchException $e) {
				$this->fail();
			}
		}
	}

	/**
	 * test for filter()
	 *
	 * target methods
	 *
	 * @test
	 */
	public function testFilterTargetMethods()
	{
		$methods = ['POST', 'PUT', 'PATCH'];

		foreach ($methods as $method) {
			\Input::shouldReceive('getMethod')->once()->andReturn($method);
			\Input::shouldReceive('input')->once()->andReturn('x');
			\Session::shouldReceive('token')->once()->andReturn('x');

			try {
				(new CsrfFilter)->filter();
				$this->assertTrue(true);
			} catch (TokenMismatchException $e) {
				$this->fail();
			}
		}
	}

	/**
	 * test for filter()
	 *
	 * target methods - TokenMismatch
	 *
	 * @test
	 */
	public function testFilterTargetMethodsTokenMismatch()
	{
		$methods = ['POST', 'PUT', 'PATCH'];

		foreach ($methods as $method) {
			\Input::shouldReceive('getMethod')->once()->andReturn($method);
			\Input::shouldReceive('input')->once()->andReturn('y');
			\Session::shouldReceive('token')->once()->andReturn('x');

			try {
				(new CsrfFilter)->filter();
				$this->fail();
			} catch (TokenMismatchException $e) {
				$this->assertTrue(true);
			}
		}
	}
}
