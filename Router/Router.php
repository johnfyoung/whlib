<?php
/**
 * Router.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Router;

use WHLib\Base\BaseSingleton;

class Router extends BaseSingleton {
	static $instance;
	var $routes;

	public static function get_instance() {
		if(empty(self::$instance)) {
			self::$instance = new Router();
		}

		return self::$instance;
	}

	public function set_routes($route_list) {
		$this->routes = $route_list;
	}

	public function is_valid_route($route) {
		$result = false;

		foreach($this->routes as $route_pattern) {
			if(preg_match('/^'. $route_pattern. '$/', $route, $matches)) {
				$result = true;
				break;
			}
		}

		return $result;
	}

	public function show_404() {
		echo '404';
	}
}

/* End of file Router.php */
 