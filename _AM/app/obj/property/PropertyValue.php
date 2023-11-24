<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class PropertyValue {
		
		protected $_name;
		protected $_value;
		protected $_unit;
		protected $_initValue;
		protected $_number_round;
		
		
		public function __construct($pName = NULL, $pValue = NULL, $pUnit = UnitType::NO_UNIT, $pInitValue = 0, $pRound = 0){
			if(!is_null($pName))
				$this -> setName($pName);
			if(!is_null($pUnit))
				$this -> setUnit($pUnit);
			if(!is_null($pValue))
				$this -> setValue($pValue);
			if(!is_null($pInitValue))
				$this -> setInitValue($pInitValue);
			if(!is_null($pRound))
				$this -> setRound($pRound);

		}
		
		public function getName(){
			return $this -> _name;	
		}
		
		public function setName($pName){
			$this -> _name = $pName;	
		}
		
		public function getUnit(){
			return $this -> _unit;	
		}
		
		public function setUnit($pUnit){
			$this -> _unit = $pUnit;	
		}
		
		public function getInitValue(){
			return $this -> _initValue;	
		}
		
		public function setInitValue($pInitValue){
			$this -> _initValue = $pInitValue;	
		}
		
		public function getRound(){
			return $this -> _number_round;	
		}
		
		public function setRound($pRound){
			$this -> _number_round = $pRound;	
		}
		
		public function getValue(){
			return $this -> _value;	
		}
		
		public function setValue($pValue){
			$this -> _value = $pValue;	
		}
		
	}

?>