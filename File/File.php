<?php
/**
 * File.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;


abstract class File {
  var $file_path;
  var $file_pointer;
  var $data;
  var $permissions = 'r';

  public function __construct($file_path) {
    $this->file_path = $file_path;
    $this->_init();
  }

  public function __destruct() {
    $this->_close();
  }

  protected function _init() {
    $this->data = array();
    $this->_open();
  }

  protected function _open() {
    $this->file_pointer = fopen($this->file_path,$this->permissions);
  }

  protected function _close() {
    if(is_resource($this->file_pointer)) {
      fclose($this->file_pointer);
    }
  }

  public function get_pointer() {
    return $this->file_pointer;
  }

} 