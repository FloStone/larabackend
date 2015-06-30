<?php

namespace Flo\Backend\Classes;

interface AdminInterface
{
	/**
	 * Edit an instance of a Model
	 *
	 * @return void
	 */
	public function getEdit($id, $model);

	/**
	 * Delete an instance of a Model
	 *
	 * @return void
	 */
	public function getDelete($id, $model);

	/**
	 * Add an instance of a Model
	 *
	 * @return void
	 */
	public function getAdd($model);
}