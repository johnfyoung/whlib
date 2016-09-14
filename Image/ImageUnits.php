<?php
/**
 * ImageUnits.php: Utility class for converting measurement units
 *
 * @package
 * @author John Young, Williams Helde Marketing Communications
 * @version $Id: WHLibUnits.php 4637 2012-07-31 03:49:00Z williamshelde $
 */
namespace WHLib\Image;

define('WHLIB_UNIT_INCHESPERMILLIMETER',0.03937);
define('WHLIB_UNIT_INCHESPERPOINT',1/72);

class ImageUnits
{
  public static function inchesToMillimeters($inches)
  {
    return $inches / WHLIB_UNIT_INCHESPERMILLIMETER;
  }
  
  public static function millimetersToInches($mms)
  {
    return $mms * WHLIB_UNIT_INCHESPERMILLIMETER;
  }
  
  public static function inchesToCentimeters($inches)
  {
    return ($inches / WHLIB_UNIT_INCHESPERMILLIMETER) / 10;
  }
  
  public static function centimetersToInches($cms)
  {
    return ($cms / 10) * WHLIB_UNIT_INCHESPERMILLIMETER;
  }
  
  public static function inchesToPoints($inches)
  {
    return $inches / WHLIB_UNIT_INCHESPERPOINT;
  }
  
  public static function pointsToInches($points)
  {
    return $points * WHLIB_UNIT_INCHESPERPOINT;
  }
  
  public static function millimetersToPoints($mms)
  {
    return self::inchesToPoints(self::millimetersToInches($mms));
  }
  
  public static function pointsToMillimeters($points)
  {
    return self::inchesToMillimeters(self::pointsToInches($points));
  }
}


?>