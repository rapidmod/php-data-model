<?php
/**
 * @author RapidMod.com
 * @author 813.330.0522
 */


namespace Rapidmod\Data;
use \Rapidmod\Traits\DataGettersSetters;
use \stdClass;

class Model
{
	const VERSION = "0.0.3";

	private $_DATAEXTRACT = NULL;
	private $_DATAFORMAT = NULL;
	private $_DATAOBJECT = NULL;
	private $_DATASANITIZE = NULL;
	private $_DATAVALIDATE = NULL;




	public function extract(){
		if(is_null($this->_DATAEXTRACT)){
			$this->_DATAEXTRACT = new \Rapidmod\Data\Extract();
		}
		return $this->_DATAEXTRACT;
	}

	public function format(){
		if(is_null($this->_DATAFORMAT)){
			$this->_DATAFORMAT = new \Rapidmod\Data\Format();
		}
		return $this->_DATAFORMAT;
	}



	public function sanitize(){
		if(is_null($this->_DATASANITIZE)){
			$this->_DATASANITIZE = new \Rapidmod\Data\Sanitize();
		}
		return $this->_DATASANITIZE;
	}



	public function validate(){
		if(is_null($this->_DATAVALIDATE)){
			$this->_DATAVALIDATE = new \Rapidmod\Data\Validate();
		}
		return $this->_DATAVALIDATE;
	}

	public static function model($name = NULL,$vars=array()){
		if(is_null($name)){ $name = get_called_class(); }
		return new $name($vars);
	}
}