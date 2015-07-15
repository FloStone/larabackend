<?php

namespace Flo\Backend\Traits;

use Request;

trait Query
{
	/**
	 * Custom query added by user
	 *
	 * @var string
	 */
	protected $query;

	public function where($column, $operator, $value = null)
	{
		if ($value)
		{
			$this->query[] = "AND `$column` $operator '$value'";
		}
		else
		{
			$this->query[] = "AND `$column` = $operator";
		}

		return $this;
	}

	public function whereIn($column, array $values)
	{
		$values = implode(',', $values);
		$this->query[] = "AND `$column` IN ($values)";

		return $this;
	}

	public function orWhere($column, $operator, $value = null)
	{
		if ($value)
		{
			$this->query[] = "OR $column = $operator";
		}
		else
		{
			$this->query[] = "OR $column $operator $value";
		}

		return $this;
	}

	private function resolveQuery()
	{
		$object = $this->data;

		if ($this->query)
			$query = implode(' ', $this->query);
		else
			$query = null;

		if ($query)
			$object = $object->whereRaw(delete_first_word($query));

		if ($this->search)
			$object = $object->whereRaw($this->getSearchQuery($this->search));

		$object = $object->orderBy(Request::input('order', 'id'), Request::input('destination', 'asc'))->paginate($this->pagination);

		return $object;
	}
}