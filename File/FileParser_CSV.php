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

class FileParser_CSV extends FileParser {
  var $field_names;

  public function __construct($file_path) {
	parent::__construct($file_path);
	$this->get_row_function = 'fgetcsv';
	$this->get_row_params = array($this->file_pointer,0,',');
  }

  /**
   * @inherit
   */
  public function parse($first_row_is_field_names = false, $store_as_array = false) {
	$row = parent::get_next_row();

	while(!empty($row)) {
		if($this->row_current_index == 0 && $first_row_is_field_names) {
			$this->field_names = $row;
		} else {
			if($store_as_array) {
				$this->data[] = $row;
			} else {
				$this->data[] = $this->_create_data_row($row);
			}
		}

		$this->row_current_index++;
		$row = parent::get_next_row();
	}

	return $this->data;
  }

	/**
	* merge the field names with field data
	* @param $row_data
	*
	* @return array
	*/
	protected function _create_data_row($row_data) {
		$row = array();

		$field_count = 0;
		foreach($this->field_names as $field) {
			$row[$field] = $row_data[$field_count];
			$field_count++;
		}

		return $row;
	}

	public function get_field_names() {
		return $this->field_names;
	}
} 