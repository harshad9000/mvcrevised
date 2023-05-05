<?php 

class Controller_Product extends Controller_Core_Action 
{
	
	public function gridAction()
	{
		try {
			$query = "SELECT * FROM `product`";
			$products = Ccc::getModel('Product_Row')->fetchAll($query);
			if (!$products) {
				throw new Exception("Product not found.", 1);
			}
			$this->getView()->setTemplate('product/grid.phtml')->setData(['products'=>$products]);
			$this->render();
		} catch (Exception $e) {
			
		}
	}

	public function addAction()
	{
		$this->getView()->setTemplate('product/add.phtml');
		$this->render();
	}

	public function editAction()
	{
		try {
			$id = $this->getRequest()->getParams('id');
			$product = Ccc::getModel('Product_Row')->load($id);
			$this->getView()->setTemplate('product/edit.phtml')->setData(['product' =>$product]);
			$this->render();
		} catch (Exception $e) {
			
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request.", 1);
			}
			$postData = $this->getRequest()->getPost('product');

			if ($id = $this->getRequest()->getParams('id')) {
				$product = Ccc::getModel('Product_Row')->load($id);
				if (!$product) {
					throw new Exception("Product not found.", 1);
				}
				$product->updated_at = date('Y-m-d H:i:s');
			}
			else{
				$product = Ccc::getModel('product_Row');
				if (!$product) {
					throw new Exception("Product not found", 1);
				}
				$product->created_at = date("Y-m-d H-i-s");
			}
			$product->setData($postData);
			if (!$product->save()) {
				throw new Exception("Product not saved.", 1);
			}
			$this->redirect('grid','product',null,true);
		} catch (Exception $e) {
				
		}
	}


	public function deleteAction()
	{
		try {
			if (!($id = (int)$this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$product = Ccc::getModel('Product_Row')->load($id);
			if (!$product) {
				throw new Exception("Product not found", 1);
			}
			$product->delete();
			
		} catch (Exception $e) {
			
		}
	$this->redirect('grid','product',null,true);
	}

}
?>