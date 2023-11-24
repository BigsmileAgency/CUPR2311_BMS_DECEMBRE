<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class BaseCollection {
		
		/**
		 * @constructor
		 */
		 
		protected $_bases;
		
		
		public function __construct(){
			$this -> _bases = array();
		}
		
		public function add(AnimationBase $pBase){
			array_push($this -> _bases, $pBase);
			return $this;
		}
		
		public function remove(AnimationBase $pBase){
			foreach($this -> _bases as $k => $v) {
            	if($v === $pBase) {
                	unset($this -> _bases[$k]);
                	$this -> _bases = array_values($this -> _bases);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getObjects(){
        	return $this -> _bases;
		}

	}
	
	
?>