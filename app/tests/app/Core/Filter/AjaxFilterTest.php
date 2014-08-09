<?php namespace My\Core\Filter;

/**
 * Class AjaxFilterTest
 */
class AjaxFilterTest extends \TestCase
{
	/**
	 * test for filter()
	 *
	 * @test
	 */
	public function testFilter()
	{
		\Input::shouldReceive('ajax')->once()->andReturn(true);

		(new AjaxFilter)->filter();

		$this->assertTrue(true);
	}

	/**
	 * test for filter()
	 *
	 * not ajax
	 *
	 * @test
	 * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function testFilterNotAjax()
	{
		\Input::shouldReceive('ajax')->once()->andReturn(false);

		(new AjaxFilter)->filter();
	}
}
