<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class JSONFormatData extends DataObject {
		
		protected $_assoc_values;
		
		/**
		 * @constructor
		 */
		public function __construct($pContent, $pAssocValues = false){
			$this -> _name = "JSONData";
			$this -> _assoc_values = $pAssocValues;
			parent::__construct($pContent);
		}
		
		protected function _applyDimension($name, $array, $a_mod, $dim){
			if($dim == 1){
				if(count($array)){
					foreach($array as $k => $v){
						$new_val = $k;
						
						if($count_value = count($v)){
							if($count_value == 1){
								if($v[0] !== null)
									$a_mod["init".$new_val] = $v[0];
							} else if($count_value == 2){
								if($v[0] !== null)
									$a_mod["init".$new_val] = $v[0];
								if($v[1] !== null)
									$a_mod["exit".$new_val] = $v[1];
							} else if($count_value == 3){
								if($v[0] !== null)
									$a_mod["init".$new_val] = $v[0];
								if($v[1] !== null)
									$a_mod["exit".$new_val] = $v[1];
								if($v[2] !== null)
									$a_mod["default".$new_val] = $v[2];
							} else {
								for($i = 0; $i < $count_value; $i++){
									if($i == 0)
										$new_prefix = "init";
									else if ($count_value - $i == 1)
										$new_prefix = "default";
									else if ($count_value - $i == 2)
										$new_prefix = "exit";
									else
										$new_prefix = "anim".$i;
									if($v[$i] !== null)
										$a_mod[$new_prefix.$new_val] = $v[$i];
								}
							}
						}
					}					
				}
			} else {
				if(count($array)){
					foreach($array as $k => $v){
						if($dim == 0){
							if($k !== $name)
								continue;
							$a_mod[$k] = array();
							if(is_array($v)){
								$a_mod[$k] = $this -> _applyDimension($name, $array[$k], $a_mod[$k], ($dim+1));
							} else {
								$a_mod[$k] = $v;
							}
						} else { 
							$a_mod[$k] = array();
							if(is_array($v)){
								$a_mod[$k] = $this -> _applyDimension($name, $array[$k], $a_mod[$k], ($dim+1));
							} else {
								$a_mod[$k] = $v;
							}
						}
					}
				}
			}
			return $a_mod;
		}
		
		
		
		protected function _applyDimensionAssoc($name, $array, $a_mod, $dim){
			if($dim == 1){
				if(count($array)){
					foreach($array as $k => $v){
						$new_val = $k;
						
						if($count_value = count($v)){
							foreach($v as $k2 => $v2){
								$a_mod[$k2.$new_val] = $v2;	
							}
						}
					}					
				}
			} else {
				if(count($array)){
					foreach($array as $k => $v){
						if($dim == 0){
							if($k !== $name)
								continue;
							$a_mod[$k] = array();
							if(is_array($v)){
								$a_mod[$k] = $this -> _applyDimensionAssoc($name, $array[$k], $a_mod[$k], ($dim+1));
							} else {
								$a_mod[$k] = $v;
							}
						} else { 
							$a_mod[$k] = array();
							if(is_array($v)){
								$a_mod[$k] = $this -> _applyDimensionAssoc($name, $array[$k], $a_mod[$k], ($dim+1));
							} else {
								$a_mod[$k] = $v;
							}
						}
					}
				}
			}
			return $a_mod;
		}
		
		
		public function parse(AnimationObject $pObject){
			$n_array = array();
			$name = $pObject -> getSelector();
			if(!$this -> _assoc_values){
				$n_array = $this -> _applyDimension($name, $this -> _content, $n_array, 0);
			} else {
				$n_array = $this -> _applyDimensionAssoc($name, $this -> _content, $n_array, 0);
			}
			if(isset($n_array[$name])){
				return $n_array[$name];
			} else {
				return $n_array;
			}
			
		}
		
		public function format($pValue){
			$tmp_array = json_decode($pValue, true);
			if(json_last_error() > 0){
				throw new Exception($this -> _name.": Invalid JSON format at parse().");
				die();
			} 
			return $tmp_array;
		}

	}
	
?>