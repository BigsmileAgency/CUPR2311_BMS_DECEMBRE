<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class Prefix {
		
		protected $_type;
		
		
		public function __construct($pType = PrefixType::NORMAL){
			if(!is_null($pType))
				$this -> setPrefix($pType);
			
		}
		
		public function getPrefix(){
			return $this -> _type;	
		}
		
		public function setPrefix($pType){
			$this -> _type = $pType;	
		}
		
		
	}

?>