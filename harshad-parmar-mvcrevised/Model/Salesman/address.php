<?php

class Model_Salesman_Address extends Model_Core_Table
{
	function __construct()
	{
		parent::__construct();
		$this->setTableName('Salesman_address')->setPrimarykey('address_id');
	}
}