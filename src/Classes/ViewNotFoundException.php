<?php

namespace Flo\Backend\Classes;

/**
 * Exception when a view does not exist
 */
class ViewNotFoundException extends \Exception
{
	public function __construct()
	{
		parent::__construct('Invalid argument for view or model');
	}
}