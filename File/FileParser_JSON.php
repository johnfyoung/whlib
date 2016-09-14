<?php
/**
 * FileParser_JSON.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

class FileParser_JSON extends FileParser {
  var $field_names;

  public function parse() {
    $row_count = 0;
    while(!feof($this->file_pointer))
    {
      $row = fgets($this->file_pointer);

      if($row_count == 0) {
        $this->field_names = json_decode($row);
      } else {
        $this->data[] = $this->_create_data_row(json_decode($row));
      }

      $row_count++;
    }

    return $this->data;
  }

  public function parse_data() {
    $this->_close();

    $json_encoded_data = file_get_contents($this->file_path);

    return json_decode($json_encoded_data);
  }

  protected function _create_data_row($row_data) {
    $row = array();

    $field_count = 0;
    foreach($this->field_names as $field) {
      $row[$field] = $row_data[$field_count];
      $field_count++;
    }

    return $row;
  }
} 