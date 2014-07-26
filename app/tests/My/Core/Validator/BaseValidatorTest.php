<?php namespace My\Core\Validator;

use Mockery as m;
use Illuminate\Validation\Factory;

/**
 * Class BaseValidatorTest
 */
class BaseValidatorTest extends \TestCase
{
	/**
	 * test for with()
	 *
	 * @test
	 */
	public function testWith()
	{
		$validator = new BaseValidator(new Factory($this->app['translator']));

		$data = ['k' => 'v'];
		$validator->with($data);

		$this->assertTrue($this->getProperty($validator, 'data') === $data);
	}

	/**
	 * test for passes() and errors()
	 *
	 * @test
	 */
	public function testPassesAndErrors()
	{
		// pass
		$mValidator = m::mock();
		$mValidator->shouldReceive('setAttributeNames')->once();
		$mValidator->shouldReceive('passes')->once()->andReturn(true);

		$mFactory = m::mock('\Illuminate\Validation\Factory[make]', [$this->app['translator']]);
		$mFactory->shouldReceive('make')->once()->with(
			m::type('array'), m::type('array'), m::type('array'))->andReturn($mValidator);

		$validator = new BaseValidator($mFactory);

		$this->assertTrue($validator->passes());

		// fail
		$mValidator = m::mock();
		$mValidator->shouldReceive('setAttributeNames')->once();
		$mValidator->shouldReceive('passes')->once()->andReturn(false);
		$mValidator->shouldReceive('messages')->once()->andReturn('messages');

		$mFactory = m::mock('\Illuminate\Validation\Factory[make]', [$this->app['translator']]);
		$mFactory->shouldReceive('make')->once()->with(
			m::type('array'), m::type('array'), m::type('array'))->andReturn($mValidator);

		$validator = new BaseValidator($mFactory);

		$this->assertFalse($validator->passes());
		$this->assertTrue($validator->errors() === 'messages');
	}
}
