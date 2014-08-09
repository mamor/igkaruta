<?php namespace My\Core\Validator;

use Illuminate\Validation\Factory;

/**
 * Class BaseValidator
 */
class BaseValidator
{
	/**
	 * @var Factory
	 */
	protected $factory;

	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var \Illuminate\Support\MessageBag
	 */
	protected $errors;

	/**
	 * @var array
	 */
	protected $rules = [];

	/**
	 * @var array
	 */
	protected $messages = [];

	/**
	 * @var array
	 */
	protected $attributeNames = [];

	/**
	 * @param  Factory $factory
	 */
	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param  array $data
	 * @return $this
	 */
	public function with(array $data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function passes()
	{
		$validator = $this->factory->make($this->data, $this->rules, $this->messages);

		$validator->setAttributeNames($this->attributeNames);

		if ($validator->passes()) return true;

		$this->errors = $validator->messages();

		return false;
	}

	/**
	 * @return \Illuminate\Support\MessageBag
	 */
	public function errors()
	{
		return $this->errors;
	}
}
