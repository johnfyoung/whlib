<?php
/**
 * FileWriter_CSV.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

class FileWriter_CSV extends FileWriter {

  /**
   * Make a csv string, 1st row is headers
   * @param $row_data associative array
   */
  public static function create_csv_string($row_data) {
    $csv_string = '';

    foreach($row_data as $count => $row) {
      if($count == 0) {
        $csv_string .= implode(',', array_keys($row));
      }

      $csv_string .= PHP_EOL .implode(',', array_values($row));
    }

    return $csv_string;
  }

  public static function output_to_browser($row_data, $output_file_name) {
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$output_file_name);

    $file_writer = new FileWriter_CSV('php://output');

    foreach($row_data as $row_count => $row) {
      if($row_count == 0) {
        $file_writer->write_data(array_keys($row));
      }

      $file_writer->write_data(array_values($row));
    }
  }

  /**
   * @param $data array
   */
  public function write_data($data) {
    fputcsv($this->file_pointer,$data,',','"');
  }
} 