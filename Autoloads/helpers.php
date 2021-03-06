<?php

define('EDIT', 'edit');
define('DELETE', 'delete');
define('ADD', 'add');
define('HUHU', 'HUHU');

if (!function_exists('norm_action'))
{
	function norm_action($action)
	{
		$action = str_replace(['get', 'post', 'patch', 'put', 'delete'], '', $action);
		$action = str_replace('/[A-Z]/', '/-$1/', $action);

		return strtolower($action);
	}
}

if (!function_exists('is_active_route'))
{
	function is_active_route($route)
	{
		$route = norm_action($route);
		
		if (\Request::segment(2) == norm_action($route))
			return true;
		elseif ($route == 'index' && is_null(\Request::segment(2)))
			return true;
		else
			return false;
	}
}

if (!function_exists('class_replace'))
{
	function class_replace($string)
	{
		if (stripos($string, '\\') !== false)
			return str_replace('\\', '__', $string);
		elseif (strpos($string, '__') !== false)
			return str_replace('__', '\\', $string);
		else
			return $string;
	}
}

if (!function_exists('delete_first_word'))
{
	function delete_first_word($string)
	{
		$array = explode(' ', $string);

		array_shift($array);

		$string = implode(' ', $array);

		return $string;
	}
}