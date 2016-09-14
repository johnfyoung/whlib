<?php
/**
 * FileWriter.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

abstract class FileWriter extends File {

  public function __construct($file_path) {
    $this->permissions = 'w';
    parent::__construct($file_path);
  }

  abstract public function write_data($data);
} 