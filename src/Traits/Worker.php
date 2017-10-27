<?php

namespace FloStone\Backend\Traits;

use Schema;

trait Worker
{
	/**
	 * Generates a query to use search using $searchable_fields
	 *
	 * @param string $search
	 * @return string
	 */
	public function getSearchQuery($search)
	{
		$model = $this->model;

		if (isset($model::$searchable_columns) && !empty($model::$searchable_columns))
			$columns = $model::$searchable_columns;
		else
			$columns = Schema::getColumnListing((new $model)->getTable());

		$query = '';
		$i = 1;
		$count = (int)count($columns);

		foreach($columns as $field)
		{
			$query = $query . "`$field` like '%$search%' ";

			if ($i < $count)
			{
				$query = $query . 'OR ';
				$i++;
			}
		}

		return $query;
	}

	/**
	 * Check if the model displayed fields have relations
	 * And remove them since they cannot be used by the query builder
	 *
	 * @return array
	 */
	public function checkColumnsForRelation()
	{
		$model = $this->model;
		$displayed_columns = $model::$displayed_columns;

		$array = [];

		foreach($displayed_columns as $column => $properties)
		{
			if (!isset($properties['relation']))
			{
				$array[$column] = $properties;
			}
		}

		return $array;
	}

	/**
	 * Get all methods of a class without gettig the methods of the parent class
	 *
	 * @param string $class
	 * @return array
	 */
	public function getClassMethods($class)
	{
		$methods = [];
		$reflection = new \ReflectionClass($class);

		foreach($reflection->getMethods() as $m)
		{
			if ($m->class == $class)
				$methods[] = $m->name;
		}

		return $methods;
	}
}