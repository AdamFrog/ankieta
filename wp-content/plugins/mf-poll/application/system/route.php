<?php

class GRRoute{

	protected static $redirect_url = null;
	
	public static function get($route_key, array $param){

		$routes = GRConfig::instance()->get('route');

		$route = GRConfig::instance()->get('route_prefix') . $routes[$route_key];

		return self::replace_var_in_string($route, $param);

	}

	public static function redirect($route_key, array $param){
		wp_redirect(self::get($route_key, $param));
        exit;
	}

	protected static function replace_var_in_string($url, array $param){

		return str_replace(array_keys($param), array_values($param), $url);

	}

}
