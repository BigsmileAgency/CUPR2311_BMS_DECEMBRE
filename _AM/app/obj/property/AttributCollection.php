<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	 class AttributCollection {
		
		protected $_attributs;
		
		public function __construct(){
			$this -> _attributs =array();
		}
		
		public function add(Attribut $pAttribut){
			array_push($this -> _attributs, $pAttribut);
			return $this;
		}
		
		public function remove(Attribut $pAttribut){
			foreach($this -> _attributs as $k => $v) {
            	if($v === $pAttribut) {
                	unset($this -> _attributs[$k]);
                	$this -> _attributs = array_values($this -> _attributs);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getAttributs(){
			return $this -> _attributs;
		}
		
		public function setAttributs($pAttributs){
			$this -> _attributs = $pAttributs;
		}
	}

?>