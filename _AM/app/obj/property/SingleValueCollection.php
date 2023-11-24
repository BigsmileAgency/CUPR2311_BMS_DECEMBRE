<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	 class SingleValueCollection {
		
		protected $_svalues;
		
		public function __construct(){
			$this -> _svalues =array();
		}
		
		public function add(SingleValue $pSingleValue){
			array_push($this -> _svalues, $pSingleValue);
			return $this;
		}
		
		public function remove(SingleValue $pSingleValue){
			foreach($this -> _svalues as $k => $v) {
            	if($v === $pSingleValue) {
                	unset($this -> _svalues[$k]);
                	$this -> _svalues = array_values($this -> _svalues);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getSingleValues(){
			return $this -> _svalues;
		}
		
		public function setSingleValues($pSingleValues){
			$this -> _svalues = $pSingleValues;
		}
		
	}

?>