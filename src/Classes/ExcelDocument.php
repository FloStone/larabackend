<?php

namespace Flo\Backend\Classes;

use Excel;
use Schema;

/**
 * Class Excel Document Creates excel document
 */
class ExcelDocument
{
	/**
	 * Model class
	 *
	 * @var string
	 */
	private $model;

	/**
	 * Initiate Excel sheet
	 *
	 * @param string $model
	 * @param string $type
	 * @return Excel
	 */
	public function __construct($model, $type)
	{
		$model = class_replace($model);
		$this->model = $model;

		if (isset($model::$export_fields) && !empty($model::$export_fields))
			$this->fields = $model::$export_fields;
		else
			$this->fields = Schema::getColumnListing((new $model)->getTable());

		
		$this->createDocument($type);
	}

	/**
	 * Create the document
	 *
	 * @param string $type
	 * @return Excel
	 */
	public function createDocument($type)
	{
		$model = $this->model;
		$data = $model::select($this->fields)->get();

		Excel::create($this->getName(), function($excel) use ($data)
		{
			$excel->sheet($this->getName(), function($sheet) use ($data)
			{
				$sheet->cells(1, function($cell){
					$cell->setFont(['bold' => true]);
				});
				$sheet->fromArray($data->toBase()->toArray());
			});
		})->download($type);
	}

	public function getName()
	{
		$array = explode('\\', $this->model);
		return array_pop($array);
	}

}