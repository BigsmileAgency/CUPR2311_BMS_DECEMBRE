<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	abstract class Process {
		
		protected static $path;

		public function __construct(){
			self::$path = AppPath::getPath();
		}

		abstract public function apply();
		
		
	}
	
?>