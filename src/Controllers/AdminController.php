<?php

namespace Flo\Backend\Controllers;

use Input;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Model;

use Flo\Backend\Classes\ModelNotFoundException;
use Flo\Backend\Classes\ViewFactory as View;
use Flo\Backend\Classes\AdminInterface;

/**
 * AdminController for Backend
 *
 * @author  Flo5581
 * @package  Flo\Backend
 */
class AdminController extends BaseController implements AdminInterface
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
	 * @param strin $model [<description>]
	 * @return view
	 */
	protected function view($model = null, array $data = [])
	{
		if (class_exists($model))
		{
			return new View(static::$displayed_actions, $model, Input::has('search') ? Input::get('search') : null);
		}
		else
		{
			throw new ModelNotFoundException($model);
		}
	}

	public function customView($path, array $data = [])
	{
		return view($path, $data)->with('actions', static::$displayed_actions);
	}

	/**
	 * Edit an instance of a model
	 *
	 * @param int $id
	 * @param string $model
	 * @return view
	 */
	public function getEdit($id, $model)
	{
		// Convert model string back to readable
		$model = class_replace($model);
		
		return (new View(static::$displayed_actions, $model))->addForm(EDIT, $id)->render();
	}

	/**
	 * Add an instance of a model
	 *
	 * @param string $model
	 * @return view
	 */
	public function getAdd($model)
	{
		$model = class_replace($model);

		return (new View(static::$displayed_actions, $model))->addForm(ADD)->render();
	}

	/**
	 * Delete an instance of a model
	 *
	 * @param int $id
	 * @param string $model
	 * @return view
	 */
	public function getDelete($id, $model)
	{
		$model = class_replace($model);

		return (new View(static::$displayed_actions, $model))->addForm(DELETE, $id)->render();
	}

	/**
	 * Edit an instance of a model
	 * POST request
	 *
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function postEdit($id, $model)
	{
		$model = class_replace($model);

		$class = $model::find($id);
		foreach($model::$editable_columns as $column)
		{
			$class->$column = Input::get($column);
		}
		$class->save();

		return redirect('admin');
	}

	/**
	 * Add an instance of a model
	 * POST request
	 * 
	 * @param string $model
	 * @return void
	 */
	public function postAdd($model)
	{
		$model = class_replace($model);

		$class = new $model;

		foreach($model::$editable_columns as $column)
		{
			$class->$column = Input::get($column);
		}

		$class->save();

		return redirect('admin');
	}

	/**
	 * Delete an instance of a model
	 * POST request
	 * 
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function postDelete($id, $model)
	{
		$model = class_replace($model);

		$model::find($id)->delete();

		return redirect('admin');
	}
}