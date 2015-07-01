<?php

namespace Flo\Backend\Classes;

/**
 * Exception when a model does not exist
 */
class ModelNotFoundException extends \Exception
{
	public function __construct($model)
	{
		parent::__construct("$model could not be found");
	}
}