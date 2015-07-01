<?php

namespace Flo\Backend\Classes;

class EditableColumnsException extends \Exception
{
	public function __construct($type)
	{
		parent::__construct('Model::$editable_columns is '.$type);
	}
}