<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class AnimationBase {
		
		protected $_properties;
		
		public function __construct(){
			$this -> _properties = new PropertyCollection();
		}
		
		public function add($pValues) {
			if(is_array($pValues)){
				foreach($pValues as $value){
					$this -> _add($value);
				}
			} else {
				$this -> _add($pValues);
			}
		}
		
		protected function _add(Property $pValue){
			$this -> _properties -> add($pValue);
		}
		
		public function initVars(AnimationObject $pObject){
			

			$identifier1 = "init";
			$identifier2 = "exit";
			
			$data = $pObject -> getAnimationData();
			$props = $this -> getProperties();
			
			foreach($props as $prop){
				$values = $prop -> getValues();
				foreach($values as $value){
					if($value instanceof Attribut){
						$vals = $value -> getValues();
						foreach($vals as $v){
							$name = $v -> getName();
							$init = $v -> getInitValue();
							
							if(!isset($data[$identifier1 . $name]))
								$data[$identifier1 . $name] = $init;
							if(!isset($data[$identifier2 . $name]))
								$data[$identifier2 . $name] = $data[$identifier1 . $name] ;
						}
						
					} else if($value instanceof SingleValue){
						$name = $value -> getPropertyValue()-> getName();
						$init = $value -> getPropertyValue() -> getInitValue();
						
						if(!isset($data[$identifier1 . $name]))
							$data[$identifier1 . $name] = $init;
						if(!isset($data[$identifier2 . $name]))
							$data[$identifier2 . $name] = $data[$identifier1 . $name] ;
						
						}

				}
						
			}
			$pObject -> setAnimationData($data);
		
		}
		
		public function getProperties(){
			return $this -> _properties -> getProperties();
		}						
	}

?>