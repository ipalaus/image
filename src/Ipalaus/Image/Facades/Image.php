<?php namespace Ipalaus\Image\Facades;

use Illuminate\Support\Facades\Facade;

class Image extends Facade {

	/**
	 * Return a new Image object.
	 *
	 * @param  string $path The path to the image.
	 * @return \Ipalaus\Image\Image
	 */
	public static function make($path = null)
	{
		return new \Ipalaus\Image\Image($path);
	}

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'ipalaus.image'; }

}