<?php namespace My\App\Controller;

/**
 * フロント用コントローラ
 *
 * Class FrontController
 */
class FrontController extends AppController
{
	/**
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		// AngularJS を用いるので、ここでは何もしない
		return \View::make('front');
	}
}
