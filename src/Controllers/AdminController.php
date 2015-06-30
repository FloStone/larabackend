<?php

namespace Flo\Backend\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * AdminController for Backend
 * 
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
	protected function view($path, $data = [])
	{
		return view($path, $data)->with('actions', static::$displayed_actions);
	}
}