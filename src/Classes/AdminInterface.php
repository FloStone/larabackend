<?php

namespace FloStone\Backend\Classes;

interface AdminInterface
{
	/**
	 * Return the index page
	 *
	 * @return view
	 */
	public function getIndex();

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

	/**
	 * Export data to an excel sheet
	 *
	 * @param string $model
	 * @param string $type
	 * @return ExcelDocument
	 */
	public function getExport($model, $type);

	/**
	 * Log current user out of backend
	 *
	 * @return Response
	 */
	public function getLogout();
}