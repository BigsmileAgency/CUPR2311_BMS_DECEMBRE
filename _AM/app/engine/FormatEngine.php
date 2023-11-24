<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	abstract class FormatEngine {
		
		/**
		 * @constructor
		 */
		 
		protected $_name;
		

		abstract public function format($value);
		
		
		
	}
	
?>