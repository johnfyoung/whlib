<?php
/**
 * ErrorHandler.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Errors;

use WHLib\Base\BaseSingleton;
use WHLib\Utility\Logger;

class ErrorHandler extends BaseSingleton {
  static $instance;

  protected function __construct() {
    set_error_handler(array($this, 'handle_error'));
    $this->logger = Logger::get_instance();
  }

  public static function get_instance() {
    if(empty(self::$instance)) {
      self::$instance = new ErrorHandler();
    }

    return self::$instance;
  }

  public function handle_error($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
      return false;
    }

    $this->logger->log('ERROR: #'. $errno .' in '. $errfile .', line '. $errline .' - '. $errstr, LOG_LEVEL_ERROR);
  }
}


/* End of file ErrorHandler.php */
 