<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	final class AnimationObjectCollection {
		
		private $_objs;
		
		/**
		 * @constructor
		 */
		public function __construct(){
			$this -> _objs = array();
		}
		
		public function add(AnimationObject $pObject){
			array_push($this -> _objs, $pObject);
			return $this;
		}
		
		public function remove(AnimationObject $pObject){
			foreach($this -> _objs as $k => $v) {
            	if($v === $pObject) {
                	unset($this -> _objs[$k]);
                	$this -> _objs = array_values($this -> _objs);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getObjects(){
			return $this -> _objs;
		}
		
		public function setObjects($pObjs){
			$this -> _objs = $pObjs;
		}
		
	}
	
?>