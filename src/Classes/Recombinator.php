<?php

namespace Flo\Backend\Classes;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class recombinator recombines a Collection to an array with working relation output
 *
 * @package  Flo\Backend
 */
class Recombinator
{
	/**
	 * Create the recombined array
	 *
	 * @param Collection $data
	 * @return array
	 */
	public static function make(Collection $data, $var_set = false)
	{
		if ($var_set)
			return static::var_set($data);

		$collection = new EloquentCollection;

		foreach($data as $item)
		{
			$methods = Worker::getClassMethods(get_class($item));

			$origin = static::arrayValuesToString($item->getOriginal());

			foreach($methods as $method)
			{
				$origin[$method] = static::getRelationItems($item, $method);
			}

			$collection->add($origin);
		}

		return $collection->toArray();
	}

	public static function var_set($data)
	{
		$collection = new EloquentCollection;

		$model = get_class($data->first());

		foreach($data as $item)
		{
			$origin = static::arrayValuesToString($item->getOriginal());

			$new = [];

			foreach($model::$export_fields as $field => $properties)
			{
				if (isset($properties['relation']))
				{
					$method = $properties['relation']['method'];

					$new[] = static::getRelationItems($item, $method);
				}
				else
				{
					$new[] = $item->$field;
				}
			}

			$collection->add($new);
		}

		return $collection->toArray();
	}

	public static function getRelationItems(Model $item, $method, $display = null)
	{
		if ($item->$method instanceof EloquentCollection || $item->$method instanceof Collection)
		{
			$relation = $item->$method;

			$return = [];

			foreach($relation as $relation_item)
			{
				$return[] = static::getFirstArrayEntry($relation_item);
			}

			return implode("\n", $return);
		}
		elseif ($item->$method instanceof Model)
		{
			$relation_item = $item->$method;

			return static::getFirstArrayEntry($relation_item);
		}
	}

	/**
	 * Get the first entry of a model Item
	 *
	 * @param Model $item
	 * @return string
	 */
	public static function getFirstArrayEntry(Model $relation_item)
	{
		$relation_array = $relation_item->toArray();

		if (isset($relation_array['updated_at']))
			unset($relation_array['updated_at']);

		if(isset($relation_array['created_at']))
			unset($relation_array['created_at']);

		if (isset($relation_array['id']))
			unset($relation_array['id']);

		if (isset($relation_array['pivot']))
			unset($relation_array['pivot']);

		return array_shift($relation_array);
	}

	public static function arrayValuesToString(array $array)
	{
		$fixed = [];

		foreach($array as $key => $value)
		{
			$fixed[$key] = (string)$value;
		}

		return $fixed;
	}
}