<?php 

class Controller_Vendor extends Controller_Core_Action 
{
	public function gridAction()
	{
		$query = "SELECT * FROM `vendor`";
		$adapter = $this->getAdapter();
		$vendors = $adapter->fetchAll($query);
		if (!$vendors) {
			throw new Exception("products not found.", 1);
		}
		require_once 'view/vendor/grid.phtml';
	}

	public function addAction()
	{
		require_once 'view/vendor/add.phtml';
	}

	public function insertAction()
	{
			$request = $this->getRequest();
			$vendorData = $request->getPost();
			$query = "INSERT INTO `vendor`(`name`, `address`) VALUES ('$vendorData[name]','$vendorData[address]')";
			$adapter = new Model_Core_Adapter();
			$result = $adapter->insert($query);
			header("Location:index.php?c=vendor&a=grid");
	}

	public function editAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "SELECT * FROM `vendor` WHERE `vendor_id`={$id}";
		$adapter = $this->getAdapter();
		$product = $adapter->fetchRow($query);
		require_once 'view/vendor/edit.phtml';
	}

	public function updateAction()
	{
			$request = $this->getRequest();
			$productData = $request->getPost();
			$id = $request->getParams('id');
			$query = "UPDATE `vendor` SET 
							`name`='$vendorData[name]',
							`address`='$vendorData[address]' 
							WHERE `vendor_id` = {$id}";
			$adapter = $this->getAdapter();
			$adapter->update($query);
			header("Location:index.php?c=vendor&a=grid");
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `vendor` WHERE `vendor_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=vendor&a=grid");
	}

}
?>