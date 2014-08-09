<?php namespace My\Core\Filter;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AjaxFilter
 */
class AjaxFilter
{
	/**
	 * @throws NotFoundHttpException
	 */
	public function filter()
	{
		if (! \Input::ajax()) {
			throw new NotFoundHttpException;
		}
	}
}
