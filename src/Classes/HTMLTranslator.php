<?php

namespace Flo\Backend\Classes;

class HTMLTranslator
{
	public static $types = [
		'string'	=> 'text',
		'text'		=> 'text',
		'textarea'	=> 'textarea',
		'integer'	=> 'text',
		'int'		=> 'text',
		'password'	=> 'password',
		'pass'		=> 'pass',
		'checkbox'	=> 'checkbox',
		'boolean'	=> 'checkbox',
		'select'	=> 'select',
		'selectbox'	=> 'select',
		'enum'		=> 'select',
		'file'		=> 'file'
	];

	public static function make($type = null, $name, $data = null)
	{
		if ($type == 'textarea')
		{
			return "<textarea name=\"$name\">$data</textarea>";
		}
		else
		{
			$trans = static::$types[$type ?: 'string'];

			return "<input type=\"$trans\" name=\"$name\" value=\"$data\">";
		}
	}
}