<?php

namespace Flo\Backend\Classes;

use Excel;
use Schema;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

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
		{
			$fields = $model::$export_fields;

			$this->fields[] = 'id';

			foreach($fields as $field => $properties)
			{
				if (!isset($properties['relation']))
					$this->fields[] = $field;
			}
		}
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

		$data = $this->recombineData($data);

		Excel::create($this->getName(), function($excel) use ($data)
		{
			$excel->sheet($this->getName(), function($sheet) use ($data)
			{
				$sheet->cells(1, function($cell){
					$cell->setFont(['bold' => true]);
				});
				$sheet->fromArray($data);
			});
		})->download($type);
	}

	/**
	 * Get the name of the Model Class
	 *
	 * @return string
	 */
	public function getName()
	{
		$array = explode('\\', $this->model);
		return array_pop($array);
	}

	/**
	 * Recombine data to add relations to the export
	 *
	 * @param Collection $data
	 * @return array
	 */
	public function recombineData(EloquentCollection $data)
	{
		$model = $this->model;

		// Run if the $relation_fields is empty or not set
		if (!isset($model::$export_fields) || empty($model::$export_fields))
		{
			return Recombinator::make($data);
		}
		// Otherwise run the normal execution
		else
		{
			return Recombinator::make($data, true);
		}
	}
}