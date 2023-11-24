<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	final class JSONFileData extends JSONFormatData {

		/**
		 * @constructor
		 */
		 
		public function __construct($pFile, $pAssocValues = false){
			
			$this -> _name = "JSONFileData";
			$content =  file_get_contents($pFile);
			parent::__construct($content, $pAssocValues);
		}
		
		
	}
	
?>