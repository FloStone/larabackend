<?php

namespace FloStone\Backend\Classes;

/**
 * Class HTMLTranslator converts fields defined in Model
 * To working html inputs
 *
 * @package Flo\Backend
 * @author Flo5581
 */
class HTMLTranslator
{
	/**
	 * Dictionary of field types
	 * Key is the model field
	 * Value is the html input type
	 *
	 * @var array
	 */
	public static $types = [
		'string'	=> 'text',
		'text'		=> 'text',
		'textarea'	=> 'textarea',
		'integer'	=> 'text',
		'int'		=> 'text',
		'password'	=> 'password',
		'pass'		=> 'password',
		'checkbox'	=> 'checkbox',
		'boolean'	=> 'checkbox',
		'select'	=> 'select',
		'selectbox'	=> 'select',
		'enum'		=> 'select',
		'file'		=> 'file',
		'image'		=> 'file'
	];

	/**
	 * Run the dictionary
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $data
	 * @return html
	 */
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

	/**
	 * Return only the type without html
	 *
	 * @param string $key
	 * @return string
	 */
	public static function type($key)
	{
		return static::$types[$key];
	}
}