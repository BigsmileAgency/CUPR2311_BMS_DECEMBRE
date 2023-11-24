<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class Property {
		
		protected $_propertyName;
		protected $_attributs;
		protected $_singles;
		protected $_propertyType;
		protected $_prefixs;
		protected $_is_animation_property;
		protected $_is_transform_property;
		
		
		public function __construct($pPropertyName = NULL, $pPrefixs = NULL, $pPropertyType = PropertyType::SINGLE){
			
			$this -> _is_animation_property = true;
			$this -> _is_transform_property = false;
			$this -> _attributs = new AttributCollection();
			$this -> _singles = new SingleValueCollection();
			
			if(!is_null($pPropertyName))
				$this -> setPropertyName($pPropertyName);
			if(!is_null($pPrefixs))
				$this -> setPrefixs($pPrefixs);
			if(!is_null($pPropertyType))
				$this -> setType($pPropertyType);
		}
		
		
		public function add($pValues){
			if(is_array($pValues)){
				foreach($pValues as $value){
					$this -> _add($value);
				}
			} else {
				$this -> _add($pValues);
			}
		}
		
		protected function _add($pValue){
			if($pValue instanceof Attribut){
				$this -> _attributs -> add($pValue);
			} else if($pValue instanceof SingleValue){
				$this -> _singles -> add($pValue);
			}
		}
		
		
		public function getValues(){
			if($this -> _propertyType === PropertyType::SINGLE)
				return $this -> _singles -> getSingleValues();
			else if($this -> _propertyType === PropertyType::ATTRIBUT)
				return $this -> _attributs -> getAttributs();	
		}
		
		public function getPropertyName(){
			return $this -> _propertyName;	
		}
		
		public function setPropertyName($pPropertyName){
			$this -> _propertyName = $pPropertyName;	
		}

		public function getPrefixs(){
			return $this -> _prefixs;	
		}
		
		
		public function setPrefixs($pPrefixs){
			if(is_array($pPrefixs)){
				$prefixs = new PrefixCollection();
				foreach($pPrefixs as $prefix){
					//if($prefix instanceof Prefix){
						$prefixs -> add($prefix);
					//}
				}
				$this -> _prefixs = $prefixs;
			} else {
				$prefix = new PrefixCollection();
				//if($pPrefixs instanceof Prefix){
					$prefix -> add($pPrefixs);
				//}
				$this -> _prefixs = $prefix;
			}
		}
		
		public function getType(){
			return $this -> _propertyType;	
		}
		
		public function setType($pPropertyType){
			$this -> _propertyType = intval($pPropertyType);
		}
		
		public function __get($name){
			$ret = NULL;
			switch($name){
				case "isAnimationProperty" : 
					$ret = $this -> _is_animation_property;
					break;
				case "isTransformProperty" : 
					$ret = $this -> _is_transform_property;
					break;
				default : 
					break;
			}
		 	return $ret;
		}
		
		public function __set($name, $value){
			$ret = NULL;
			switch($name){
				case "isAnimationProperty" : 
					$this -> _is_animation_property = $value ? true : false;
					break;
				case "isTransformProperty" : 
					$this -> _is_transform_property = $value ? true : false;
					break;
				default : 
					break;
			}
		}
	}

?>