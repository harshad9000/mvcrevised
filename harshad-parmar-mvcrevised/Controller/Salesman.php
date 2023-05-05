<?php

class Controller_Salesman extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$sql = "SELECT * FROM `salesman`";
			$salesmen = Ccc::getModel('Salesman_Row')->fetchAll($sql);
			$this->getView()->setTemplate('salesman/grid.phtml')->setData(['salesmen' => $salesmen]);
			$this->render();
		} catch (Exception $e) {
			
		}
	}

	public function addAction()
	{
		$this->getView()->setTemplate('salesman/add.phtml');
		$this->render();
	}

	public function editAction()
	{
		try {
			$id = $this->getRequest()->getParams('id');
			$salesman = Ccc::getModel('Salesman_Row')->load($id);
			if (!$salesman) {
				throw new Exception("Salesman not found.", 1);
			}
			$salesmanAddress = Ccc::getModel('Salesman_Address_Row')->load($id);
			if (!$salesmanAddress) {
				throw new Exception("Salesman address not found", 1);
			}
			$this->getView()->setTemplate('salesman/edit.phtml')->setData(['salesman'=>$salesman,'salesmanAddress'=>$salesmanAddress]);
			$this->render();
		} catch (Exception $e) {
			
		}
	}

	public function saveAction()
	{
		try {
			
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invaloid Request", 1);
			}

			$postData = $this->getRequest()->getPost('salesman');
			if (!$postData) {
				throw new Exception("Salesman data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) {
				$salesman = Ccc::getModel('Salesman_Row')->load($id);
				$salesman->updated_at = date("Y-m-d H-i-s");
			}
			else{
				$salesman = Ccc::getModel('Salesman_Row');
				$salesman->created_at = date("Y-m-d H-i-s"); 
			}

			$salesman->setData($postData);
			if (!$salesman->save()) {
				throw new Exception("Salesman not saved.", 1);
			}

			$postAddressData = $this->getRequest()->getPost('address');
			if (!$postAddressData) {
				throw new Exception("Salesman address data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) {
				$salesmanAddress = Ccc::getModel('Salesman_Address_Row')->load($id);
			}
			else{
				$salesmanAddress = Ccc::getModel('Salesman_Address_Row');
				$salesmanAddress->salesman_id = $salesman->salesman_id; 
			}

			$salesmanAddress->setData($postAddressData);
			if (!$salesmanAddress->save()) {
				throw new Exception("Salesman addresss not saved.", 1);
			}

		} catch (Exception $e) {
			
		}
		$this->redirect('grid','salesman',null,true);
	}
	public function deleteAction()
	{
		try {
			if (!($id = $this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$salesman = Ccc::getModel('Salesman_Row')->load($id);
			if (!$salesman) {
				throw new Exception("Error Processing Request", 1);
			}
			$salesman->delete();

			$salesmanAddress = Ccc::getModel('Salesman_Address_Row');
			if (!$salesmanAddress) {
				throw new Exception("Salesman Address not saved", 1);
			}
			$salesmanAddress->delete();
		} catch (Exception $e) {
			
		}
	$this->redirect('grid','salesman',null,true);
	} 
}