<?php
/**
 * FileLog.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHlib\File;

defined('LOG_FILES_PATH') OR exit('No log file path defined');

class FileLog extends File {

  public function __construct($file_path = '') {
    $this->permissions = 'a';

    if(empty($file_path)) {
      $file_path = LOG_FILES_PATH .'/'. date('Ymd') ."_log.txt";
    }
    parent::__construct($file_path);
  }

  public function write_line($msg) {
    fwrite($this->file_pointer, $msg . PHP_EOL);
  }
}


/* End of file FileLog.php */
 