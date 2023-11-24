<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	final class Format {
		
		private $_width;
		private $_height;
		
		/**
		 * @constructor
		 */
		public function __construct($pWidth, $pHeight){

			$this -> _width = $pWidth;
			$this -> _height = $pHeight;
		}
		
		public function getWidth(){
			return $this -> _width;
		}
		
		public function getHeight(){
			return $this -> _height;
		}
		
	}
	
?>