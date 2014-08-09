<?php namespace My\App;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends \My\Core\ServiceProvider
{
	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		parent::register();

		\App::bind('util', function () {
			return new Util;
		});
	}
}
