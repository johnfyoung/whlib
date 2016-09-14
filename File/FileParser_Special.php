<?php
/**
 * FileParser_Special.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

class FileParser_Special extends FileParser {
  public function parse() {
    $row_count = 0;
    while(!feof($this->file_pointer))
    {
      $row = fgets($this->file_pointer);

      $parts = explode(': ',$row);
      if($parts[1] != 'none') {
        $this->data[$parts[0]] = trim($parts[1]);
      }

      $row_count++;
    }

    return $this->data;
  }
}