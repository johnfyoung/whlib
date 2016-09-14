<?php
/**
 * FileWriter_JSON.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

class FileWriter_JSON extends FileWriter {
  public function write_data($data) {
    $result = json_decode($data);

    if(json_last_error() !== JSON_ERROR_NONE) {
      $data = json_encode($data);
    }

    fwrite($this->file_pointer,$data);
  }
} 