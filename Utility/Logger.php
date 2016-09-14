<?php
/**
 * Logger.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Utility;

use WHLib\File\FileLog;

define('LOG_LEVEL_DEBUG', 10);
define('LOG_LEVEL_INFO', 8);
define('LOG_LEVEL_WARNING', 3);
define('LOG_LEVEL_ERROR', 3);

class Logger {
  static $instance;
  var $log_file;

  protected function __construct($file_path = '') {
    $this->log_file = new FileLog($file_path);
  }

  public static function get_instance() {
    if(empty(self::$instance)) {
      self::$instance = new Logger();
    }

    return self::$instance;
  }

  public function screen($msg, $level = LOG_LEVEL_INFO) {
    if($level <= LOG_LEVEL) {
      $now = date("H:i:s");

      echo "<pre>". $now ."---". $msg ."</pre>";
    }
  }

  public function log($msg, $level = LOG_LEVEL_INFO) {
    if($level <= LOG_LEVEL) {
      $this->log_file->write_line(date("H:i:s") .' --- '. $msg);
    }
  }
} 