<?php
/**
 * Image.php: A Custom Image descriptor class
 *
 * @package WHLib
 * @author John Young, Williams Helde Marketing Communications
 * @version $Id: WHLibImage.php 5062 2013-08-07 00:25:21Z williamshelde $
 */
namespace WHLib\Image;

/*require_once 'ImageUnits.php';*/

use WHLib\Image\ImageUnits;

define('WHLIB_IMAGE_PIXELDEPTH_DEFAULT', 300);

/**
 * an enum to configure what units to return from WHLibImage's
 * dimensions functions
 * @author johnyoung
 */
class ImageUnitType
{
  const Pixels = 1;
  const Millimeters = 2;
  const Inches = 3;
  const Centimeters = 4;
  const Points = 5;
}

/**
 * WHLibImage: an Image description class
 * requires GD
 * @author johnyoung
 *
 */
class Image
{
  /**
   * file path to the image
   * @var string
   */
  private $_path;
  
  /**
   * the image width in pixels 
   * @var int
   */
  private $_width;
  
  /**
   * the image height in pixels
   * @var unknown_type
   */
  private $_height;
  
  /**
   * the file type
   * @var ImageUnitType Constant
   * @see EXIF documentation: http://www.php.net/manual/en/function.exif-imagetype.php
   */
  private $_type;
  
  /**
   * MIME type
   * @var string
   */
  private $_mime;
  
  /**
   * Pixel count per inch
   * @var int
   */
  private $_pixeldepth;
  
  /**
   * Constructor
   * @param string $path file path to the image 
   * @param int $pixels number of pixels per square inch
   */
  public function __construct($path, $dpi = null)
  {
    $imageinfo = getimagesize($path);
    if($imageinfo)
    {
      $this->_path = $path;
      $this->_width = $imageinfo[0];
      $this->_height = $imageinfo[1];
      $this->_type = $imageinfo[2];
      $this->_mime = $imageinfo['mime'];

      $this->_setpixeldepth($dpi);
    }
    else
    {
      throw new \Exception("WHLibImage can't find the image file at ". $path);
    }
  }
  
  /**
   * Accessor for the image's file path
   * @return string
   */
  public function path()
  {
    return $this->_path;
  }
  
  /**
   * Calculate the image width for a given unit type
   * @param ImageUnitType $unit
   * @return float
   */
  public function width($unit = ImageUnitType::Pixels)
  {
    return $this->_convertdimension($this->_width, $unit);
  }
  
  /**
   * Calculate the image height for a given unit type
   * @param ImageUnitType $unit
   * @return float
   */
  public function height($unit = ImageUnitType::Pixels)
  {
    return $this->_convertdimension($this->_height, $unit);
  }
  
  /**
   * Accessor for the image type
   * @return string 3 char extension
   * @see EXIF documentation: http://www.php.net/manual/en/function.exif-imagetype.php
   */
  public function type()
  {
    return self::lookupImageType($this->_type);
  }

	/**
	 * Determine the aspect of the image
	 *
	 * @return string an aspect description
	 */
	public function aspect() {
		$aspect = '';

		if($this->_width > $this->_height) {
			$aspect = 'landscape';
		} else if($this->_width < $this->_height) {
			$aspect = 'portrait';
		} else if($this->_width == $this->_height) {
			$aspect = 'square';
		}

		return $aspect;
	}
  
  /**
   * Accessor for the MIME type
   * @return string
   */
  public function mime()
  {
    return $this->_mime;
  }

  private function _setpixeldepth($dpi) {
    $known_dpi = !empty($dpi) ? $dpi : false;
    $default_dpi = WHLIB_IMAGE_PIXELDEPTH_DEFAULT;

    /* Without ImageMagik, this is more work than is allowed by time allotted
    if($known_dpi) {

    } else {
      switch($this->type()) {
        case 'jpg':
          $exif_data = exif_read_data($this->_path);

          if(!empty($exif_data) && ($exif_data['XResolution'])) {
            $this->_pixeldepth = (int)($exif_data['XResolution']);
          } else { //assuming jfif
            //$dpi = $this->_jfif_resolution($this->_path);
            //$this->_pixeldepth = $dpi[0];
            $this->_pixeldepth = $default_dpi;
          }
          break;
        case 'png':

          break;
        case 'gif':

          break;
        default:
          $this->_pixeldepth = $default_dpi;
      }
    }
    */

    $this->_pixeldepth = !empty($known_dpi) ? $known_dpi : $default_dpi;
  }

  private function _jfif_resolution($file) {
    $a = fopen($file,'r');
    $string = fread($a,20);
    fclose($a);

    $data = bin2hex(substr($string,14,4));
    $x = substr($data,0,4);
    $y = substr($data,4,4);

    return array(hexdec($x),hexdec($y));
  }
  
  /**
   * Convert a pixel count to the given unit with the image's pixel depth
   * @param int $pixels
   * @param ImageUnitType $unit
   * @throws \Exception
   * @return float
   */
  private function _convertdimension($pixels, $unit = ImageUnitType::Pixels)
  {
    $result = $pixels;
    
    switch($unit) 
    {
      case ImageUnitType::Pixels:
        $result = $pixels;
        break;
      case ImageUnitType::Millimeters:
        $result = ImageUnits::inchesToMillimeters($pixels/$this->_pixeldepth);
        break;
      case ImageUnitType::Inches:
        $result = $pixels/$this->_pixeldepth;
        break;
      default:
        throw new \Exception("WHLibImage can't convert the dimension to that unit.");
    }
    
    return $result;
  }
  
  /**
   * convert IMAGETYPE constant to 3 letter extension
   * @param int the IMAGETYPE constant
   * @return string
   * @see EXIF documentation: http://www.php.net/manual/en/function.exif-imagetype.php
   */
  public static function lookupImageType($imagetype)
  {
    $result = "";
    
    switch($imagetype)
    {
      case IMAGETYPE_GIF:
        $result = "gif";
        break;
      case IMAGETYPE_JPEG:
        $result = "jpg";
        break;
      case IMAGETYPE_PNG:
        $result = "png";
        break;
    }
    
    return $result;
  }
}


?>