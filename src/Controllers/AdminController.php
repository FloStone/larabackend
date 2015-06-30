<?php

namespace Flo\Backend\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Model;

use Flo\Backend\Classes\ViewNotFoundException;

use Flo\Backend\Classes\ViewFactory as View;

/**
 * AdminController for Backend
 *
 * @author  Flo5581
 * @package  Flo\Backend
 */
class AdminController extends BaseController
{
	use DispatchesJobs, ValidatesRequests;

	/**
	 * Actions displayed in the menu
	 *
	 * @var array
	 */
	public static $displayed_actions = [];

	/**
	 * Returns the view given
	 *
	 * @return view
	 */
	protected function view($path = null, array $data = [])
	{
		if (class_exists($path))
		{
			return new View(static::$displayed_actions, $path);
		}
		elseif (!is_null($path))
		{
			return view($path, $data)->with('actions', static::$displayed_actions);
		}
		else
		{
			throw new ViewNotFoundException;
		}
	}
}