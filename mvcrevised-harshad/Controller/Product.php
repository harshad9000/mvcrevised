<?php 

class Controller_Product extends Controller_Core_Action 
{
	
	public function gridAction()
	{
		$query = "SELECT * FROM `product`";

		$adapter = $this->getAdapter();
		$products = $adapter->fetchAll($query);
		if (!$products) {
			throw new Exception("products not found.", 1);
		}
		require_once 'view/product/grid.phtml';
	}

	public function addAction()
	{
		require_once 'view/product/add.phtml';
	}

	public function insertAction()
	{
			$request = $this->getRequest();
			$productData = $request->getPost();

			$query = "INSERT INTO `product`(`name`, `cost`, `SKU`, `price`, `quantity`, `description`, `status`, `color`, `material`) VALUES ('$productData[name]','$productData[cost]','$productData[SKU]','$productData[price]','$productData[quantity]','$productData[description]','$productData[status]','$productData[color]','$productData[material]')";

			$adapter = new Model_Core_Adapter();
			$result = $adapter->insert($query);
			header("Location:index.php?c=product&a=grid");
	}

	public function editAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "SELECT * FROM `product` WHERE `product_id`={$id}";
		$adapter = $this->getAdapter();
		$product = $adapter->fetchRow($query);
		require_once 'view/product/edit.phtml';
	}

	public function updateAction()
	{
			$request = $this->getRequest();
			$productData = $request->getPost();

			$id = $request->getParams('id');

			$query = "UPDATE `product` SET 
							`name`='$productData[name]',
							`cost`='$productData[cost]',
							`SKU`='$productData[SKU]',
							`price`='$productData[price]',
							`quantity`='$productData[quantity]',
							`description`='$productData[description]',
							`status`='$productData[status]',
							`color`='$productData[color]',
							`material`='$productData[material]' 
							WHERE `product_id` = {$id}";
			$adapter = $this->getAdapter();
			$adapter->update($query);
			header("Location:index.php?c=product&a=grid");
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `product` WHERE `product_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=Product&a=grid");
	}

}
?>