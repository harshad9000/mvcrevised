<?php 

class Model_Core_Request
{
	public function getParams($key=null,$value=null)
	{
		
		if(array_key_exists($key, $_GET)){
			return $_GET[$key];
		}
		if($key == Null){
			return $_GET;
		}

		return $value;
	}

	public function getPost($key=null,$value=null)
	{
		if(array_key_exists($key,$_POST)){
			return $_POST[$key];
		}
		if($key=null){
			return $_POST;
		}

		return $value;
	}

	//to check data is posted or not
	public function isPost()
   {
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
         return true;
      }

      return False;
   }

   public function getControllerName()
   {
   	return $this->getParams('c','index');
   }
   //to get action name
   public function getActionName()
   {
   	return $this->getParams('a','index');
   }

}

?>