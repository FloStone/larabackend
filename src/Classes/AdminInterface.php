<?php

namespace Flo\Backend\Classes;

interface AdminInterface
{
	/**
	 * Edit an instance of a Model
	 *
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function getEdit($id, $model);

	/**
	 * Delete an instance of a Model
	 *
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function getDelete($id, $model);

	/**
	 * Add an instance of a Model
	 *
	 * @param string $model
	 * @return void
	 */
	public function getAdd($model);

	/**
	 * Edit an instance of a model
	 * POST request
	 *
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function postEdit($id, $model);

	/**
	 * Delete an instance of a model
	 * POST request
	 *
	 * @param int $id
	 * @param string $model
	 * @return void
	 */
	public function postDelete($id, $model);

	/**
	 * Add an instance of a model
	 * POST request
	 * 
	 * @param string $model
	 * @return void
	 */
	public function postAdd($model);
}