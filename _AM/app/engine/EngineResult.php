<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class EngineResult {
		
		
		/**
		 * @constructor
		 */
		 
		protected $_result;
		
		
		public function __construct($r){
			$this -> _result = $r;
		}
		
		public function getResult(){
			return $this -> _result;
		}
		
	}
	
?>