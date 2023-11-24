<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class PropertyValueCollection {
		
		protected $_propertyValues;
		
		public function __construct(){
			$this -> _propertyValues =array();
		}
		
		public function add(PropertyValue $pPropertyValue){
			array_push($this -> _propertyValues, $pPropertyValue);
			return $this;
		}
		
		public function remove(PropertyValue $pPropertyValue){
			foreach($this -> _propertyValues as $k => $v) {
            	if($v === $pPropertyValue) {
                	unset($this -> _propertyValues[$k]);
                	$this -> _propertyValues = array_values($this -> _propertyValues);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getValues(){
			return $this -> _propertyValues;
		}
		
		public function setValues($pPropertyValues){
			$this -> _propertyValues = $pPropertyValue;
		}
		
	}

?>