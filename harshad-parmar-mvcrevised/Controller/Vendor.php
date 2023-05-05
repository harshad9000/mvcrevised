<?php

class Controller_Vendor extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$query = "SELECT * FROM `vendor`";
			$vendors = Ccc::getModel('Vendor_Row')->fetchAll($query);
			if (!$vendors) {
				throw new Exception("Vendors not found", 1);
			}
			$this->getView()->setTemplate('vendor/grid.phtml')->setData(['vendors'=>$vendors]);
			$this->render();
		} catch (Exception $e) {
	
		}

	}

	public function addAction()
	{
		$this->getView()->setTemplate('vendor/add.phtml');
		$this->render();
	}

	public function editAction()
	{
		try {
			$id = $this->getRequest()->getParams('id');
			$vendor = Ccc::getModel('Vendor_Row')->load($id);
			$vendorAddress = Ccc::getModel('Vendor_Address_Row')->load($id);
			$this->getView()->setTemplate('vendor/edit.phtml')->setData(['vendor' => $vendor,'vendorAddress' => $vendorAddress]);
			$this->render();
		} catch (Exception $e) {
			
		}

	}

	public function saveAction()
	{
		try {
			
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid request.", 1);
			}

			$postData = $this->getRequest()->getPost('vendor');
			if (!$postData) {
				throw new Exception("Invalid data posted.", 1);
			}
			if ($id = (int)$this->getRequest()->getParams('id')) {
				$vendor = Ccc::getModel('Vendor_Row')->load($id);
				if (!$vendor) {
					throw new Exception("Invalid id.", 1);
				}
			$vendor->updated_at = date("Y-m-d H:i:s");
			}
			else{
				$vendor = Ccc::getModel('Vendor_Row');
				$vendor->created_at = date("Y-m-d H:i:s");
			}
			$vendor->setData($postData);
			if (!$vendor->save()) {
				throw new Exception("Unable to save vendor.", 1);
			}

			$postDataAddress = $this->getRequest()->getpost('address');
			if (!$postDataAddress) {
				throw new Exception("Invalid data posted.", 1);
			}
			if ($id = (int)$this->getRequest()->getParams('id')) {
				$vendorAddress = Ccc::getModel('Vendor_Address_Row')->load($id);
				if (!$vendorAddress) {
					throw new Exception("Invalid id.", 1);
				}
			}
			else{
				$vendorAddress = Ccc::getModel('Vendor_Address_Row');
				$vendorAddress->vendor_id = $vendor->vendor_id;
			}
			$vendorAddress->setData($postDataAddress);
			if (!$vendorAddress->save()) {
				throw new Exception("Unable to save vendor.", 1);
			}
		} catch (Exception $e) {
			
		}
			$this->redirect('grid','vendor',null,true);

	}

	public function deleteAction()
	{
		if (!($id = (int) $this->getRequest()->getParams('id'))) {
		throw new Exception("Error Processing Request", 1);
		}
		$vendor = Ccc::getModel('Vendor_Row')->load($id);

		if (!$vendor) {
			throw new Exception("Error Processing Request", 1);
		}
		$vendorAddress = Ccc::getModel('Vendor_Address_Row')->load($id);

		$vendor->delete();
		$vendorAddress->delete();
		$this->redirect('grid','vendor',null,true);
	}
}