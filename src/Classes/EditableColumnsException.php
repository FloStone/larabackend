<?php

namespace Flo\Backend\Classes;

/**
 * Exception if the $editable_columns variable is missingor empty
 *
 * @return \Exception
 */
class EditableColumnsException extends \Exception
{
	public function __construct($type)
	{
		parent::__construct('Model::$editable_columns is '.$type);
	}
}