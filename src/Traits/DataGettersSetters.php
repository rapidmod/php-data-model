<?php
/**
 * @author RapidMod.com
 * @author 813.330.0522
 */


namespace Rapidmod\Traits;


trait DataGettersSetters {

	protected function _dataObject(){
		if(is_null($this->_DATAOBJECT)){
			$this->_DATAOBJECT = new \stdClass();
		}
		return $this->_DATAOBJECT;
	}

	public function _get($key){
		if(isset($this->_dataObject()->{$key})){
			return $this->_dataObject()->{$key};
		}
		return false;
	}

	public function __get ( $key ){
		if(isset($this->_dataObject()->{$key})){
			return $this->_dataObject()->{$key};
		}
		if (method_exists($this, "get_{$key}")){
			$x = "get_{$key}";
			$this->_dataObject()->{$key} = $this->{$x}();
		}elseif (method_exists($this, $key)){
			$this->_dataObject()->{$key} =  $this->{$key}();
		}elseif (property_exists($this,$key)){
			$this->_dataObject()->{$key} = $this->{$key};
		}
		if(!isset($this->_dataObject()->{$key})){
			$this->_dataObject()->{$key} = false;
		}
		return $this->_get($key);

	}

	/**
	 *
	 * Name _set
	 * @param $key
	 * @param $value
	 * @return $this
	 *
	 * @author RapidMod.com
	 * @author 813.330.0522
	 * @WTF magic methods blow balls.......
	 */
	public function _set($key,$value){
		if (method_exists($this, "set_{$key}")){
			$x = "set_{$key}";
			$value =  $this->{$x}($value);
		}elseif (method_exists($this, $key)){
			$value =  $this->{$key}($value);
		}
		$this->_dataObject()->{$key} = $value;
		return $this;
	}

	public function  __set($key,$value=""){
		return $this->_set($key,$value);
	}

	public function appendArray($key,$value){
		$data = $this->_get($key);
		if(!is_array($data)){$data = array();}
		$data[] = $value;
		return $this->_set($key,$data);
	}

	public function buildObject($dataArray){
		$this->reset();
		return $this->setData($dataArray);
	}

	public function setData($key,$value = ""){
		if(!is_array($key) && is_string($key)) {
			$this->_set($key,$value);
			return $this;
		}
		if(!empty($key) && empty($value)){
			foreach($key as $k=>$v){
				$this->_set($k,$v);
			}
		}
		return $this;
	}

	public function toArray($dataArray= array()){
		if(!$dataArray){
			$dataArray = $this->_dataObject();
		}
		if(empty($dataArray)){ return array();}

		return (array) $this->_dataObject();
		return json_decode(json_encode($dataArray),1);
	}

	public function getData($key=false){
		if(is_array($key) && !empty($key)){
			$data = array();
			foreach($key as $k){
				$data[$k] = $this->_get($k);
			}
			return $data;
		}elseif(!empty($key) && is_string($key)){
			return $this->_get($key);
		}else{
			return $this->toArray();
		}
	}

	public function reset(){
		$this->_DATAOBJECT = new \stdClass();
		return $this;
	}
}