<?php namespace Ipalaus\Image;

use GMagick;

class Image extends GMagick {

	/**
	 * The image filename.
	 *
	 * @var string
	 */
	protected $filename = null;

	/**
	 * The Gmagick constructor.
	 *
	 * @param   string $path
	 * @return  \Ipalaus\Image\Image
	 */
	public function __construct($path = null)
	{
		parent::__construct($path);

		$this->filename = $path;

		return $this;
	}

	/**
	 * Sets the compression quality factor (0-100). The GraphicsMagick default
	 * value is 75.
	 *
	 * @param  integer $quality The quality factor.
	 * @return \Ipalaus\Image\Image
	 */
	public function quality($quality)
	{
		return $this->setCompressionQuality($quality);
	}

	/**
	 * Scales the size of an image to the given dimensions. The other parameter
	 * will be calculated if 0 is passed as either param.
	 *
	 * @param  integer $width  The number of columns in the scaled image.
	 * @param  integer $height The number of rows in the scaled image.
	 * @return \Ipalaus\Image\Image
	 */
	public function scale($width = 0, $height = 0)
	{
		return $this->scaleimage($width, $height);
	}

	/**
	 * Extracts a region of the image.
	 *
	 * @param  integer $width  The width of the crop.
	 * @param  integer $height The height of the crop
	 * @param  integer $x      The X coordinate of the cropped region's top left corner
	 * @param  integer $y      The Y coordinate of the cropped region's top left corner
	 * @return \Ipalaus\Image\Image
	 */
	public function crop($width, $height, $x, $y)
	{
		return $this->cropimage($width, $height, $x, $y);
	}

	/**
	 * Creates a fixed square size by first scaling the image and then cropping
	 * a specified area from the center.
	 *
	 * @param  integer $size The size of the square.
	 * @return \Ipalaus\Image\Image
	 */
	public function square($size)
	{
		$width  = $this->getimagewidth();
		$height = $this->getimageheight();

		if ($width / $size < $height / $size) {
			$this->scale($size);
		} else {
			$this->scale(0, $size);
		}

		$width  = $this->getimagewidth();
		$height = $this->getimageheight();

		$y = floor(max(0, $height - $size) / 2);
		$x = floor(max(0, $width - $size) / 2);

		return $this->crop($size, $size, $x, $y);
	}

	/**
	 * Creates a fixed size thumbnail by first scaling the image down and
	 * cropping a specified area from the center. The second parameter will be
	 * equal to the first if 0 (or nothing) is passed.
	 *
	 * @param  integer $width  The width of the thumbnail
	 * @param  integer $height The height of the thumbnail
	 * @return \Ipalaus\Image\Image
	 */
	public function thumbnail($width, $height = 0)
	{
		// set height equal to width if is not setted
		$height == 0 and $height = $width;

		return $this->cropthumbnailimage($width, $height);
	}

	/**
	 * Writes an image to the specified filename. If the filename parameter is
	 * NULL, the image is written to the filename where was read by.
	 *
	 * @param  string $path The image path.
	 * @return \Ipalaus\Image\Image
	 */
	public function save($path = null)
	{
		return $this->write($path);
	}

	/**
	 * Clears all resources associated to Gmagick object and, if available,
	 * reads the initial image from filename. If the deep parameter is set to
	 * TRUE it will return a clean Gmagick object.
	 *
	 * @param  boolean $deep Set this to true will start a clean Gmagick object.
	 * @return \Ipalaus\Image\Image
	 */
	public function clear($deep = false)
	{
		if ($deep or is_null($this->filename)) return parent::clear();

		parent::clear();

		return $this->readimage($this->filename);
	}

}