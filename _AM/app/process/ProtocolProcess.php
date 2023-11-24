<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class ProtocolProcess extends Process {
		
		protected $_template;
		protected $_location;
		
		public function __construct(Template $pTemplate, $pLoc = "") {
			parent::__construct();
			$this -> _template = $pTemplate;
			$this -> _location = $pLoc;
		}
				
		public function apply(){
			
			if(file_exists($this -> _location)){
				$contents = file_get_contents($this -> _location);
				if(preg_match('/url\s*\(\s*(\'|")?\s*http:(?:.*?)\)/isU',$contents)){
					throw new Exception("Bad protocol found! Not an https");
				}
				if(preg_match('/(src|href)\s*\=\s*(\'|")\s*http:(?:.*?)(\'|")/isU',$contents)){
					throw new Exception("Bad protocol found! Not an https");
				}
			}

		}
		

	}
	
?>