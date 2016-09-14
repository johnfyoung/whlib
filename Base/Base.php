<?php
/**
 * Base.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Base;

defined('PROJECT_ROOT') OR exit('No direct script access allowed');

use WHLib\Errors\ErrorHandler;
use WHLib\Utility\Logger;

abstract class Base {
  var $logger;
  var $class;
  var $error_handler;

  protected function init() {
    $this->logger = Logger::get_instance();
    $this->error_handler = ErrorHandler::get_instance();
    $this->class = get_class($this);
  }

  protected function log($msg, $level = 5) {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,2);

    $msg = $this->class .':'. $backtrace[1]['function'] .': '. $msg;

    $this->logger->log($msg, $level);
  }
}


/* End of file Base.php */
 