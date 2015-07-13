<?php

namespace Flo\Backend\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Flo\Backend\Classes\EditableColumnsException;

use Request;

/**
 * Class ViewFactory creates Admin Views with fields defined
 *
 * @package  Flo\Backend
 * @author  Flo5581
 */
class ViewFactory
{
	/**
	 * Fields returned in view
	 *
	 * @var array
	 */
	private $fields;

	/**
	 * Instance of Worker
	 *
	 * @var Flo\Backend\Worker
	 */
	private $worker;

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
	 * Basic construction
	 *
	 * @return void
	 */
	public function __construct(array $actions, $model, $controller, $search = null, $pagination = null)
	{
		$this->worker = new Worker($model);
		$this->actions = $actions;
		$this->fields = [];
		$this->model = $model;
		$this->controller = $controller;

		$displayed_columns = $this->worker->checkColumnsForRelation();

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
			if ($search)
			{
				$this->data = $model::select($cols)->whereRaw($this->worker->getSearchQuery($search))->orderBy(Request::input('order', 'id'), Request::input('destination', 'asc'))->paginate($pagination);
			}
			else
			{
				$this->data = $model::select($cols)->orderBy(Request::input('order', 'id'), Request::input('destination', 'asc'))->paginate($pagination);
			}
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
	public function addTable(Collection $custom_data = null, $editable = true)
	{
		$this->fields[] = ['table' => ['data' => $custom_data ?: $this->data, 'editable' => $editable ? true : false, 'model' => $this->model]];

		return $this;
	}

	/**
	 * Add a custom template include to the view
	 *
	 * @return this
	 */
	public function addCustom($template, $data = null)
	{
		$this->fields[] = ['custom' => $template, 'data' => $data ?: $this->data];

		return $this;
	}

	/**
	 * Add a form field to the view
	 *
	 * @return this
	 */
	public function addForm($type, $id = null, Collection $custom_data = null)
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

	public function addExport($type, Collection $custom_data = null)
	{
		$model = $this->model;

		$this->fields[] = ['export' => [$custom_data ?: $model, 'type' => $type]];

		return $this;
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