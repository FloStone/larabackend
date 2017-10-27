<?php

namespace FloStone\Backend\Classes;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Flo\Backend\Traits\Worker;

/**
 * Class recombinator recombines a Collection to an array with working relation output
 *
 * @package  Flo\Backend
 */
abstract class Recombinator
{
	use Worker;

	/**
	 * Create the recombined array without set fields
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
			$methods = $this->getClassMethods(get_class($item));

			$origin = static::arrayValuesToString($item->getOriginal());

			foreach($methods as $method)
			{
				$origin[$method] = static::getRelationItems($item, $method);
			}

			$collection->add($origin);
		}

		return $collection->toArray();
	}

	/**
	 * Create recombined array with set fields
	 *
	 * @param Collection $data
	 */
	public static function var_set(Collection $data)
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
					$display = isset($properties['relation']['display']) ? $properties['relation']['display'] : null;

					$new[] = static::getRelationItems($item, $method, $display);
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

	/**
	 * Get the relation items
	 *
	 * @param Model $item
	 * @param string $method
	 * @param string $display
	 * @return string
	 */
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

			if ($display)
				return $relation_item->$display;
			else
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

	/**
	 * Convert all values of an array to a string
	 * Resolves problems with integer numbers
	 *
	 * @param array $array
	 * @return array
	 */
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