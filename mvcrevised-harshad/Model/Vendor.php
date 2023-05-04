<?php

class Model_Vendor extends Model_Core_Table
{
	  function __construct()
    {
      parent::__construct();
      $this->setTableName('vendor')->setPrimaryKey('vendor_id');
    }
}
