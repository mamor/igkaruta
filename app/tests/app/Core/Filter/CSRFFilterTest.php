<?php namespace My\Core\Filter;

/**
 * Class CSRFFilterTest
 */
class CSRFFilterTest extends \TestCase
{
	/**
	 * test for filter()
	 *
	 * @test
	 */
	public function testFilter()
	{
		\Session::shouldReceive('token')->once()->andReturn('xxx');
		\Input::replace(['_token' => 'xxx']);

		(new CSRFFilter)->filter();

		$this->assertTrue(true);
	}

	/**
	 * test for filter()
	 *
	 * token mismatch
	 *
	 * @test
	 * @expectedException \Illuminate\Session\TokenMismatchException
	 */
	public function testFilterTokenMismatch()
	{
		\Session::shouldReceive('token')->once()->andReturn('xxx');
		\Input::replace(['_token' => 'yyy']);

		(new CSRFFilter)->filter();
	}
}
