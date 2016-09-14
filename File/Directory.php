<?php
/**
 * Directory.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\File;

class Directory {
	var $dir_path;
	var $dir;
	var $file_listing;
	var $files;
	var $subdirs;
	var $is_dir_empty;
	var $permissions = 'r';

	public function __construct($path) {
		$this->dir_path = $path;
		$this->init();
	}

	public function __destruct() {
		$this->_close();
	}

	protected function init() {
		if($this->is_dir()) {
			$this->dir_path = strpos($this->dir_path,'/',strlen($this->dir_path)) ? $this->dir_path : $this->dir_path . '/';
		}
	}

	protected function is_dir() {
		if(!is_dir($this->dir_path)) {
			throw new \Exception('Supplied filesystem path is not a directory.');
		}

		return true;
	}

	public function listing($clean = false) {
		if(empty($this->file_listing) || $clean) {
			if($this->is_dir()) {
				$this->file_listing = scandir($this->dir_path);

				// first two elements in the array should be . and ..
				while($this->file_listing[0] == '.' || $this->file_listing[0] == '..') {
					array_shift($this->file_listing);
				}
			}
		}

		return $this->file_listing;
	}

	public function get_files($pattern = '', $clean = false) {
		return $this->get_filesystem_items('files', $pattern, $clean);
	}

	public function get_directories($pattern = '', $clean = false) {
		return $this->get_filesystem_items('directories', $pattern, $clean);
	}

	protected function get_filesystem_items($type, $pattern = '', $clean = false) {
		$result = null;
		$list = array();

		if(!$this->is_empty($clean)) {
			switch($type) {
				case 'files':
					$list = $this->files;
					break;
				case 'directories':
					$list = $this->subdirs;
					break;
				default:
					throw new Exception('Provided filesystem type is unknown');
			}

			if(!empty($pattern)) {
				$result = preg_grep($pattern, $list);
			} else {
				$result = $this->files;
			}
		}

		return $result;
	}

	public function is_empty($clean = false) {
		if(!isset($this->is_dir_empty) || $clean) {
			$this->create_catalog($clean);
			if(empty($this->files) && empty($this->subdirs)) {
				$this->is_dir_empty = true;
			} else {
				$this->is_dir_empty = false;
			}
		}

		return $this->is_dir_empty;
	}

	public function get_path() {
		return $this->dir_path;
	}

	protected function create_catalog($clean = false) {
		if(!isset($this->is_dir_empty) || $clean) {
			$listing = $this->listing($clean);
			$this->files = array();
			$this->subdirs = array();

			foreach($listing as $item) {
				if(is_dir($item)) {
					$this->subdirs[] = $item;
				} else {
					$this->files[] = $item;
				}
			}
		}
	}

	public function find($pattern = '') {
		$result = null;

		if(!empty($pattern)) {
			$result = glob($this->dir_path.$pattern);
		}

		return $result;
	}

	protected function _open() {
		if(empty($this->dir)) {
			$this->dir = dir($this->dir_path);
		}
	}

	protected function _close() {
		if(!empty($this->dir)) {
			$this->dir->close();
		}
	}
}


/* End of file Directory.php */
 