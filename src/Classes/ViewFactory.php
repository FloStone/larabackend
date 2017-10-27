<?php

namespace FloStone\Backend\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Flo\Backend\Classes\EditableColumnsException;
use Flo\Backend\Traits\Query;
use Flo\Backend\Traits\Worker;

use Request;

/**
 * Class ViewFactory creates Admin Views with fields defined
 *
 * @package  Flo\Backend
 * @author  Flo5581
 */
class ViewFactory
{
	use Query, Worker;

	/**
	 * Fields returned in view
	 *
	 * @var array
	 */
	private $fields;

	/**
	 * Actions displayed in menu
	 *
	 * @var array
	 */
	private $actions;

	/**
	 * Data of the current model
	 *
	 * @var Collection
	 */
	private $data;

	/**
	 * Called controller
	 *
	 * @var string
	 */
	private $controller;

	/**
	 * Input from search field
	 *
	 * @var string
	 */
	private $search;

	/**
	 * Amount of items per page
	 * Default is 20
	 *
	 * @see Flo\Backend\AdminController@view
	 * @var int
	 */
	private $pagination;

	/**
	 * Indicates if the data query has been resolved
	 *
	 * @var bool
	 */
	private $resolved = false;

	/**
	 * Basic construction
	 *
	 * @return void
	 */
	public function __construct(array $actions, $model, $controller, $search = null, $pagination = null)
	{
		$this->actions = $actions;
		$this->fields = [];
		$this->model = $model;
		$this->controller = $controller;
		$this->search = $search;
		$this->pagination = $pagination;

		$displayed_columns = $this->checkColumnsForRelation();

		// Model Initiation
		if (isset($displayed_columns['id']))
		{
			$cols = array_keys($displayed_columns);
		}
		else
		{
			$cols = array_merge(['id'], array_keys($displayed_columns));
		}

		if (!is_null($cols) && !empty($cols))
		{
			$this->data = $model::select($cols);
		}
		else
		{
			$this->data = $model::all();
		}
	}

	/**
	 * Add a table field to the view
	 *
	 * @return this
	 */
	private function addTable(Collection $custom_data = null, $editable = true)
	{
		$this->fields[] = ['table' => ['data' => $custom_data ?: $this->data, 'editable' => $editable ? true : false, 'model' => $this->model]];

		return $this;
	}

	/**
	 * Add a custom template include to the view
	 *
	 * @return this
	 */
	private function addCustom($template, $data = null)
	{
		$this->fields[] = ['custom' => $template, 'data' => $data ?: $this->data];

		return $this;
	}

	/**
	 * Add a form field to the view
	 *
	 * @return this
	 */
	private function addForm($type, $id = null, Collection $custom_data = null)
	{
		$model = $this->model;

		if (isset($model::$editable_columns))
		{
			if (empty($model::$editable_columns))
				throw new EditableColumnsException('empty');

			$formfields = $model::$editable_columns;
		}
		else
		{
			throw new EditableColumnsException('undefined');
		}

		if ($type == DELETE || $type == EDIT)
		{
			$model = $model::where('id', $id)->first();
		}

		$this->fields[] = [$type.'_form' => ['formfields' => $formfields, 'model' => $model]];

		return $this;
	}

	/**
	 * Add an export field to the view
	 *
	 * @param string $type fileextension
	 * @param Collection $custom_data
	 * @return this
	 */
	private function addExport($type, Collection $custom_data = null)
	{
		$model = $this->model;

		$this->fields[] = ['export' => [$custom_data ?: $model, 'type' => $type]];

		return $this;
	}

	/**
	 * Call all the private methods but execute query cconditions first
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return method
	 */
	public function __call($method, $arguments)
	{
		if (method_exists($this, $method))
		{
			if (!$this->resolved)
			{
				if ($this->data instanceof EloquentCollection === false)
				{
					$this->data = $this->resolveQuery();
					$this->resolved = true;
				}
			}
			return call_user_func_array([$this, $method], $arguments);
		}
	}

	/**
	 * Render the view
	 *
	 * @return view
	 */
	public function render()
	{
		return view('Backend::master', ['fields' => $this->fields, 'actions' => $this->actions, 'controller' => $this->controller]);
	}
}