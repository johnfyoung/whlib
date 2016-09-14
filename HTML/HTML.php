<?php
/**
 * HTML.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\HTML;

use WHLib\Base\BaseSingleton;

class HTML extends BaseSingleton {

  static public function render($path, $data) {
    ob_start();
    extract($data);
    require($path);
    return ob_get_clean();
  }

  static public function pagination_link($url, $page_id, $page_number) {
    return $url ."?". $page_id ."=". $page_number;
  }
}

/* End of file Html.php */
 