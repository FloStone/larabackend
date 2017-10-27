<?php

namespace FloStone\Backend\Traits;

use Request;

trait Query
{
	/**
	 * Custom query added by user
	 *
	 * @var string
	 */
	protected $query;

	/**
	 * Where query addition
	 *
	 * @param string $column
	 * @param string|int $operator
	 * @param string|int $value
	 * @return this
	 */
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

	/**
	 * Where In query addition
	 *
	 * @param string $column
	 * @param array $values
	 * @return this
	 */
	public function whereIn($column, array $values)
	{
		$values = implode(',', $values);
		$this->query[] = "AND `$column` IN ($values)";

		return $this;
	}

	/**
	 * OrWhere query addition
	 *
	 * @param string $column
	 * @param string|int $operator
	 * @param string|int $value
	 * @return this
	 */
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

	/**
	 * Resolve the query and get an object from database
	 *
	 * @return object
	 */
	private function resolveQuery()
	{
		$object = $this->data;

		/* Check if a conditional query is set */
		if ($this->query)
			$query = implode(' ', $this->query);
		else
			$query = null;

		/* If a query is set execute it before everything */
		if ($query)
			$object = $object->whereRaw(delete_first_word($query));

		/* If search has input execute search query */
		if ($this->search)
			$object = $object->whereRaw($this->getSearchQuery($this->search));

		/* Orderby and paginate query */
		$object = $object->orderBy(Request::input('order', 'id'), Request::input('destination', 'asc'))->paginate($this->pagination);

		return $object;
	}
}