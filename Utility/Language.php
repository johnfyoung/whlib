<?php
/**
 * Language.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Utility;

use WHLib\Base\BaseSingleton;
use WHLib\File\FileParser_CSV;
use WHLib\File\Directory;

class Language extends BaseSingleton {
	static $instance;
	var $lang_code;
	var $lang_filepath;
	var $lang_files;
	var $lang_lookup;

	public static function get_instance() {
		if(empty(self::$instance)) {
			self::$instance = new Language();
		}

		return self::$instance;
	}

	public function initialize($lang_file_path, $lang_code) {
		$this->set_lang_filepath($lang_file_path);
		$this->set_lang_code($lang_code);

		$this->get_langfiles();
	}

	public function lookup($line_id) {
		$result = '';

		if(!empty($this->lang_lookup)) {
			if(isset($this->lang_lookup[$line_id])) {
				$result = $this->lang_lookup[$line_id];
			} else {
				trigger_error('Couldn\'t find lang line '. $line_id, E_USER_WARNING);
			}
		} else {
			trigger_error('No lang lines available while looking for '. $line_id, E_USER_WARNING);
		}

		return $result;
	}

	public function t($line_id) {
		echo $this->lookup($line_id);
	}

	protected function set_lang_code($lang) {
		$this->lang_code = $lang;
	}

	protected function set_lang_filepath($path) {
		$this->lang_filepath = $path;
	}

	protected function get_langfiles() {
		if(!empty($this->lang_filepath) && !empty($this->lang_code)) {
			$lang_directory = new Directory($this->lang_filepath . $this->lang_code);
			$this->lang_files = $lang_directory->get_files('/^.*\.csv$/');

			if(!empty($this->lang_files)) {
				foreach ($this->lang_files as $lang_file) {
					$this->parse_langfile($lang_directory->get_path() . $lang_file);
				}
			}
		} else {
			throw new \Exception('Cannot get language files as language filepath is not set.');
		}
	}

	protected function parse_langfile($filepath) {
		$parser = new FileParser_CSV($filepath);

		$raw_lang_lines = $parser->parse(true, true);
		$lang_lines = array();
		foreach($raw_lang_lines as $line) {
			$lang_lines[$line[0]] = $line[1];
		}

		$this->lang_lookup = empty($this->lang_lookup) ? $lang_lines : array_merge($lang_lines, $this->lang_lookup);
	}
}


/* End of file Language.php */
 