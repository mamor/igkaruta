<?php namespace My\App\Controller;

/**
 * Class IndexController
 */
class IndexController extends AppController
{
	protected $layout = 'layouts.default';

	/**
	 * トップ
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		return \View::make('index');
	}
}
