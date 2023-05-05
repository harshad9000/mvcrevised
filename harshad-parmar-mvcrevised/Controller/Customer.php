<?php
class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		$query = "SELECT * FROM `customer`";
		$customers = Ccc::getModel('Customer_Row')->fetchAll($query);
		$this->getView()->setTemplate('customer/grid.phtml')->setData(['customers' => $customers]);
		$this->render();
	}
	public function addAction()
	{
		$this->getView()->setTemplate('customer/add.phtml');
		$this->render();
	}
	public function editAction()
	{
		try {
			$customerId = (int) Ccc::getModel('Core_Request')->getParams('id');
			if (!$customerId) {
				throw new Exception("Invalid Id", 1);
			}
			$customer = Ccc::getModel('Customer_Row')->load($customerId);
			if (!$customer) {
				throw new Exception("Invalid Id", 1);
			}
			$billingId = $customer->billing_address_id;
			$shippingId = $customer->shipping_address_id;
			$billingAddress = Ccc::getModel('Customer_Row')->getBillingAddress($billingId);
			if (!$billingAddress) {
				throw new Exception("Invalid Id", 1);
			}
			
			$shippingAddress = Ccc::getModel('Customer_Row')->getShippingAddress($shippingId);
			if (!$shippingAddress) {
				throw new Exception("Invalid Id", 1);
			}
			$this->getView()->setTemplate('customer/edit.phtml')->setData(['customer' => $customer,'billingAddress' => $billingAddress,'shippingAddress' => $shippingAddress]);
			$this->render();
			// $this->redirect('grid','customer',null,true);
		} catch (Exception $e) {
			
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request", 1);
			}

			$postData = $this->getRequest()->getPost('customer');
			if (!$postData)
			{
			 	throw new Exception("Customer data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) 
			{
			  	$customer = Ccc::getModel('Customer_Row')->load($id);
			  	if (!$customer) {
			  		throw new Exception("Customer not found.", 1);
			  	}
			  	$customer->updated_at = date("Y-m-d H-i-s");
			} 
			else
			{
			  	$customer = Ccc::getModel('Customer_Row');
			  	$customer->created_at = date("Y-m-d H-i-s");
			}

			$customer->setData($postData);
			if (!$customer->save()) {
				throw new Exception("Unable to save customer.", 1);
			}

			$postBilling = $this->getRequest()->getPost('billingAddress');
			if (!$postBilling) {
				throw new Exception("Billing address not found.", 1);
			}
			if ($id = $this->getRequest()->getParams('id')) {
			$billingId = $customer->billing_address_id;
			$billingAddress = $customer->getBillingAddress($billingId);
			
				if (!$billingAddress) 
				{
					throw new Exception("Billing address not found.", 1);
				}
			} 
			else
			{
			  	$billingAddress = Ccc::getModel('Customer_Address_Row');
			  	$billingAddress->customer_id = $customer->customer_id;
			}

			$billingAddress->setData($postBilling);
			if (!$billingAddress->save()) 
			{
				throw new Exception("Billing address not found.", 1);
			}

			$customer->billing_address_id = $billingAddress->address_id;

			$postShipping = $this->getRequest()->getPost('shippingAddress');
			if (!$postShipping) {
				throw new Exception("Billing address not found.", 1);
			}
			if ($id = $this->getRequest()->getParams('id')) 
			{
				$shippingId = $customer->shipping_address_id;
				$shippingAddress = $customer->getShippingAddress($shippingId);
				if (!$shippingAddress) {
					throw new Exception("Shipping address not found.", 1);
			}
			} 
			else{
				$shippingAddress = Ccc::getModel('Customer_Address_Row');
				$shippingAddress->customer_id = $customer->customer_id;
			}

			$shippingAddress->setData($postShipping);
			if (!$shippingAddress->save()) {
				throw new Exception("Shipping address not found.", 1);
			}
			$customer->shipping_address_id = $shippingAddress->address_id;
			$customer->setData($postData);
				if (!$customer->save()) {
				throw new Exception("Unable to save customer.", 1);
			}
			$this->redirect('grid','customer',null,true);
		} catch (Exception $e) {
			
		}
	}

	public function deleteAction()
	{
		try {
			if (!($id = (int)$this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$customer = Ccc::getModel('Customer_Row')->load($id);
			$billingId = $customer->billing_address_id;
			$billingAddress = Ccc::getModel('Customer_Address_Row')->load($billingId);
			$shippingId = $customer->shipping_address_id;
			$shippingAddress = Ccc::getModel('Customer_Address_Row')->load($shippingId);
			$customer->delete();
			$billingAddress->delete();
			$shippingAddress->delete();
			$this->redirect('grid','customer',null,true);
		} catch (Exception $e) {
			
		}
	}
}