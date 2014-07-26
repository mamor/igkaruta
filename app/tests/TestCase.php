<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	/**
	 * {@inheritDoc}
	 */
	public function tearDown()
	{
		Mockery::close();

		parent::tearDown();
	}

	/**
	 * get public method
	 *
	 * @param  object $object
	 * @param  string $methodName
	 * @return ReflectionMethod
	 */
	protected function getMethod($object, $methodName)
	{
		$reflection = new ReflectionClass($object);
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method;
	}

	/**
	 * get public property
	 *
	 * @param  object $object
	 * @param  string $propertyName
	 * @return mixed
	 */
	protected function getProperty($object, $propertyName)
	{
		$reflection = new ReflectionClass($object);
		$property = $reflection->getProperty($propertyName);
		$property->setAccessible(true);

		return $property->getValue($object);
	}
}
