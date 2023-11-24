<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class PropertyCollection {
		
		protected $_properties;
		
		public function __construct(){
			$this -> _properties =array();
		}
		
		public function add(Property $pProperty){
			array_push($this -> _properties, $pProperty);
			return $this;
		}
		
		public function remove(Property $pProperty){
			foreach($this -> _properties as $k => $v) {
            	if($v === $pProperty) {
                	unset($this -> _properties[$k]);
                	$this -> _properties = array_values($this -> _properties);
                	break;
            	}
        	}
        	return $this;
		}
		
		public function getProperties(){
			return $this -> _properties;
		}
		
		public function setProperties($pProperties){
			$this -> _properties = $pProperties;
		}
		
		
	}

?>