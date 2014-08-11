<?php namespace My\Core\Filter;

use Illuminate\Session\TokenMismatchException;

/**
 * Class CSRFFilter
 */
class CSRFFilter
{
	/**
	 * @throws TokenMismatchException
	 */
	public function filter()
	{
		if (\Input::get('_token') !== \Session::token()) {
			throw new TokenMismatchException;
		}
	}
}
