<?php

namespace Flo\Backend\Classes;

use Illuminate\Database\Eloquent\Model;

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

		// Model Initiation
		$cols = $model::$displayed_columns;

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
	public function addTable($editable = true)
	{
		$this->fields[] = ['table' => [$this->data, 'editable' => $editable ? true : false]];

		return $this;
	}

	/**
	 * Add a custom template include to the view
	 *
	 * @return this
	 */
	public function addCustom($template, $data = null)
	{

	}

	/**
	 * Add a form field to the view
	 *
	 * @return this
	 */
	public function addForm()
	{
		$this->fields[] = ['form' => null];

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