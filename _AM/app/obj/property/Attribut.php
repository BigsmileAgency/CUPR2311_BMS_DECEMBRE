<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	 class Attribut {
		
		protected $_attrName;
		protected $_propertyValues;
		protected $_prefixs;
		
		public function __construct($pAttrName, $pPrefixs = NULL){
			$this -> _propertyValues = new PropertyValueCollection();
			$this -> setName($pAttrName);
			
			if(!is_null($pPrefixs))
				$this -> setPrefixs($pPrefixs);
		}

		public function getName(){
			return $this -> _attrName;	
		}
		
		public function setName($pAttrName){
			$this -> _attrName = $pAttrName;	
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
		
		protected function _add(PropertyValue $pValue){
			$this -> _propertyValues -> add($pValue);
		}
		
		
		public function getValues(){
			return $this -> _propertyValues -> getValues();
		}
		
		
	}

?>