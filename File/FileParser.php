<?php
/**
 * FileParser.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

abstract class FileParser extends File {
  /**
   * all data pulled from the file
   * @var array of array
   */
  var $data;

  /**
   * while stepping through a file, this is the index of the last row pulled
   * @var int
   */
  var $row_current_index;

  /**
   * for stepping through a file, this is a function to delegate getting the next row
   * @var callable
   */
  var $get_row_function = 'fgets';

  /**
   * params to pass to the get next row function
   * @var array
   */
  var $get_row_params = array();

  public function __construct($file_path) {
    $this->permissions = 'r';
    parent::__construct($file_path);
    $this->row_current_index = 0;
    $this->get_row_params[] = $this->file_pointer;
    rewind($this->file_pointer);
  }

  /**
   * retrieve the data parsed from the file
   * @return array
   */
  public function get_data() {
    return $this->data;
  }

  /**
   * parse the whole file at once
   * @return mixed
   */
  abstract public function parse();

  /**
   * from an open file pointer, get the next row
   *
   * @return bool|mixed
   */
  public function get_next_row() {
    if(!feof($this->file_pointer)) {
      $row = call_user_func_array($this->get_row_function, $this->get_row_params);
      return $row;
    }

    return false;
  }

  /**
   * retrieve the index of the last row parsed
   * @return int
   */
  public function get_current_row_index() {
    return $this->row_current_index;
  }
} 