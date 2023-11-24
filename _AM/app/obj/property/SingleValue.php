<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	 class SingleValue {
		
		protected $_propertyValue;
		
		public function __construct(PropertyValue $pPropertyValue){
			$this -> setPropertyValue($pPropertyValue);
			
		}
		
		public function getPropertyValue(){
			return $this -> _propertyValue;	
		}
		
		
		public function setPropertyValue(PropertyValue $pPropertyValues){
			$this -> _propertyValue = $pPropertyValues;
		}
	}

?>