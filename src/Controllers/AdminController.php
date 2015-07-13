<?php

/*************************************\
|	Backend package for Laravel 5	  |
|*************************************|
|									  |
|									  |
|									  |
|									  |
\*************************************/

namespace Flo\Backend\Controllers;

use Input;
use Session;
use Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Model;

use Flo\Backend\Classes\ModelNotFoundException;
use Flo\Backend\Classes\ViewFactory as View;
use Flo\Backend\Classes\AdminInterface;
use Flo\Backend\Classes\ExcelDocument;

/**
 * AdminController for Backend
 *
 * @author  Flo5581
 * @package  Flo\Backend
 */
abstract class AdminController extends BaseController implements AdminInterface
{
	use DispatchesJobs, ValidatesRequests;

	/**
	 * Actions displayed in the menu
	 *
	 * @var array
	 */
	public static $displayed_actions = [];

	/**
	 * Redirect session initialization
	 *
	 * @return void
	 */
	public function __construct()
	{
		$uri = implode('/', Request::segments());

		if ($uri != Session::get('current_page'))
		{
			if (Session::has('current_page'))
			{
				if (Request::method() == "POST");
				else
					Session::put('last_page', Session::get('current_page'));
			}

			Session::put('current_page', $uri);
		}
	}

	/**
	 * Returns the view given
	 *
	 * @param string $model
	 * @param int $pagination
	 * @return view
	 */
	protected function view($model = null, $pagination = 20)
	{
		if (class_exists($model))
		{
			return new View(static::$displayed_actions, $model, $this->getChildClass(), Input::has('search') ? Input::get('search') : null, $pagination);
		}
		else
		{
			throw new ModelNotFoundException($model);
		}
	}

	public function customView($path, array $data = [])
	{
		return view($path, $data)->with('actions', static::$displayed_actions)->with('controller', $this->getChildClass());
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
		
		return (new View(static::$displayed_actions, $model, $this->getChildClass()))->addForm(EDIT, $id)->render();
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

		return (new View(static::$displayed_actions, $model, $this->getChildClass()))->addForm(ADD)->render();
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

		return (new View(static::$displayed_actions, $model, $this->getChildClass()))->addForm(DELETE, $id)->render();
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

		$this->workOnModel($class, $model);

		return redirect(Session::get('last_page'));
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

		$this->workOnModel($class, $model);
		
		return redirect(Session::get('last_page'));
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

		return redirect(Session::get('last_page'));
	}

	/**
	 * Work on Model
	 *
	 * @param Model $class
	 * @param string $model
	 * @return void
	 */
	public function workOnModel(Model $class, $model)
	{
		foreach($model::$editable_columns as $column => $properties)
		{
			if (isset($properties['type']) && $properties['type'] == 'checkbox')
			{
				if (Input::get($column))
					$class->$column = true;
				else
					$class->$column = false;
			}
			else
			{
				$class->$column = Input::get($column);
			}
		}
		$class->save();
	}

	/**
	 * Export data to an excel sheet
	 *
	 * @param string $model
	 * @param string $type
	 * @return ExcelDocument
	 */
	public function getExport($model, $type)
	{
		return new ExcelDocument($model, $type);
	}

	/**
	 * Get the child controller class
	 *
	 * @return string
	 */
	public function getChildClass()
	{
		return str_replace('App\Http\Controllers\\', '', get_called_class());
	}

	public function getLogout()
	{
		\Auth::logout();

		return redirect('/');
	}
}