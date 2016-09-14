<?php
/**
 * BaseSingleton.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */
 
namespace WHLib\Base;

class BaseSingleton extends Base {

  protected function __construct() {
    $this->init();
  }

}


/* End of file BaseSingleton.php */
 