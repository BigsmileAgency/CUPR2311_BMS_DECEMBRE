<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	abstract class DataObject {
		
		protected $_content;
		protected $_name;
		
		/**
		 * @constructor
		 */
		public function __construct($pContent){
			$this -> _content = $this -> format($pContent);
		}

		public function getContent(){
			return $this -> _content;
		}
		
		abstract protected function format($pValue);
	}
	
?>