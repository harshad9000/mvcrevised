<?php 

/**
 * 
 */
class Model_Core_View
{
	
	protected $data =[];
	protected $template=null;


	public function setTemplate($template)
	{
		$this->template=$template;
		
		return $this;
	}

	public  function getTemplate(){
		if(!$this->template){
			return false;
		}

		return $this->template;
	} 

	public function setData($data){
		$this->data=array_merge($this->data,$data);
		
		return $this;
	}

	public function getData(){
		if(!$this->data){
			return false;
		}
		return $this->data;
	}

	public function __get($key)
	{
		if (!array_key_exists($key,$this->data)) {
			return null;
		}
		return $this->data[$key];
	}

	public function __set($key,$value)
	{
		$this->data[$key]=$value;	
	}

	public function __unset($key)
	{
		unset($this->data[$key]);
	}

	public function getUrl($a = Null, $c = Null, $params = [], $resetParams = false)
	{
		$url = Ccc::getModel('Core_Url');
		return $url->getUrl($a,$c,$params,$resetParams);
	}

	public function render(){
		require_once "view".DS.$this->getTemplate();
	}
}


?>