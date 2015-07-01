<?php

namespace Flo\Backend\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Flo\Backend\Classes\EditableColumnsException;

/**
 * Class ViewFactory creates Admin Views with fields defined
 *
 * @package  Flo\Backend
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
	 * Basic construction
	 *
	 * @return void
	 */
	public function __construct(array $actions, $model)
	{
		$this->actions = $actions;
		$this->fields = [];
		$this->model = $model;

		// Model Initiation
		if (array_search('id', $model::$displayed_columns))
		{
			$cols = $model::$displayed_columns;	
		}
		else
		{
			$cols = array_merge(['id'], $model::$displayed_columns);
		}

		if (!is_null($cols) && !empty($cols))
		{
			$this->data = $model::select($cols)->get();	
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
		$this->fields[] = ['table' => [$custom_data ?: $this->data, 'editable' => $editable ? true : false]];

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
	public function addForm($type, $id = null, $custom_data = null)
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
	 * Render the view
	 *
	 * @return view
	 */
	public function render()
	{
		return view('Backend::master', ['fields' => $this->fields, 'actions' => $this->actions]);
	}
}