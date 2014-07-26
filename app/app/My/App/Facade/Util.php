<?php namespace My\App\Facade;

use \Illuminate\Support\Facades\Facade;

/**
 * Class Util
 */
class Util extends Facade
{
	/**
	 * {@inheritDoc}
	 */
	protected static function getFacadeAccessor()
	{
		return 'util';
	}
}
