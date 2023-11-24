<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class PrefixCollection {
		
		protected $_prefixs;
		
		public function __construct(){
			$this -> _prefixs =array();
		}
		
		public function add(Prefix $pPrefix){
			array_push($this -> _prefixs, $pPrefix);
			return $this;
		}
		
		public function remove(Prefix $pPrefix){
			foreach($this -> _prefixs as $k => $v) {
            	if($v === $pPrefix) {
                	unset($this -> _prefixs[$k]);
                	$this -> _prefixs = array_values($this -> _prefixs);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getPrefixs(){
			return $this -> _prefixs;
		}
		
		public function setPrefixs($pPrefix){
			$this -> _prefixs = $pPrefix;
		}
		
	}

?>