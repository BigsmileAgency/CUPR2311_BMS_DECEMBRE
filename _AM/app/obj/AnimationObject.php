<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	final class AnimationObject {
		
		private $_name;
		private $_selector;
		private $_animation_selector;
		private $_animation_name;
		private $_first_delay;
		private $_total_duration;
		private $_iteration_count;
		private $_fill_mode;
		private $_direction;
		private $_animations;
		private $_animation_type;
		private $_animation_data;
		private $_suffix_values;
		private $_allowed_types;
		private $_bases;
		private $_played_labels;
		private $_has_anims = false;
		
		private $_tmp;
		private $_default_selector = ".";
		private $_default_animation_suffix = "animation";
		
		/**
		 * @constructor
		 */
		public function __construct($pName, $pSelector = NULL, $pAnimationSelector = NULL, $pAnimationName = NULL){
			
			$this -> _animations = array();
			$this -> _suffix_values = array();
			$this -> _allowed_types = array();
			$this -> _tmp = array();
			$this -> _played_labels = array();
			$this -> _bases = new BaseCollection();
			
			$this -> _cursor_animation = 0;
			$this -> _animation_type = 0;
			$this -> _iteration_count = 1;
			$this -> _fill_mode = "forwards";
			$this -> _direction = "normal";
			
			$this -> setName($pName);
			if($pSelector === NULL){
				$this -> setSelector($this -> _default_selector.$pName);
			} else
				$this -> setSelector($pSelector);
			if($pAnimationSelector === NULL){
				$this -> setAnimationSelector($this -> _default_selector.$pName);
			} else
				$this -> setAnimationSelector($pAnimationSelector);
			if($pAnimationName === NULL){
				$this -> setAnimationName($pName."_".$this -> _default_animation_suffix);
			} else
				$this -> setAnimationName($pAnimationName);
		}
		public function hasAnim($bool){
			$this -> _has_anims = (bool)$bool;
		}

		public function containsAnims(){
			return $this -> _has_anims;
		}

		public function addLabelPlayed($pLabel){
			array_push($this -> _played_labels, $pLabel);
		}
		
		public function getLabelsPlayed(){
			return $this -> _played_labels;
		}
		
		public function resetLabelPlayed(){
			$this -> _played_labels = array();
		}
		
		
		public function setAnimations($pAnimations){
			$this -> _animations = $pAnimations;
		}
		
		public function getAnimations(){
			 return $this -> _animations;
		}
		
		public function setName($pName){
			$this -> _name = $pName;
		}
		
		public function getName(){
			return $this -> _name;
		}
		
		public function setAnimationName($pAnimationName){
			$this -> _animation_name = $pAnimationName;
		}
		
		public function getAnimationName(){
			return $this -> _animation_name;
		}
		
		public function setSelector($pSelector){
			$this -> _selector = $pSelector;
		}
		
		public function getSelector(){
			return $this -> _selector;
		}
		
		public function setSuffixValue($pProp, $pSuffix){
			$this -> _suffix_values[$pProp] = $pSuffix;
		}
		
		public function getSuffixValue($pProp){
			return $this -> _suffix_values[$pProp];
		}
		
		public function setAllowedTypes($pAllowedTypes){
			$this -> _allowed_types = $pAllowedTypes;
		}
		
		public function getAllowedTypes(){
			return $this -> _allowed_types;
		}
		
		public function setTemporary($pAnimProp, $Value){
			$this -> _tmp[$pAnimProp] = $Value;
		}
		
		public function getTemporary($pAnimProp){
			return $this -> _tmp[$pAnimProp];
		}
		
		public function setAnimationSelector($pSelector){
			$this -> _animation_selector = $pSelector;
		}
		
		public function getAnimationSelector(){
			return $this -> _animation_selector;
		}
		
		public function setIterationCount($pIterationCount){
			$this -> _iteration_count = $pIterationCount;
		}
		
		public function getIterationCount(){
			return $this -> _iteration_count;
		}
		
		public function setFillMode($pFillMode){
			$this -> _fill_mode = $pFillMode;
		}
		
		public function getFillMode(){
			return $this -> _fill_mode;
		}
		
		public function setDirection($pDirection){
			$this -> _direction = $pDirection;
		}
		
		public function getDirection(){
			return $this -> _direction;
		}
		
		public function setFirstDelay($pDelay){
			$this -> _first_delay = round(floatval($pDelay),2);
		}
		
		public function getFirstDelay(){
			return round(floatval($this -> _first_delay),2);
		}
		
		public function setTotalDuration($pDuration){
			$this -> _total_duration = round(floatval($pDuration),2);
		}
		
		public function getTotalDuration(){
			return round(floatval($this -> _total_duration),2);
		}
		
		public function setAnimationType($pAnimationType){
			$this -> _animation_type = $pAnimationType;
		}
		
		public function getAnimationType(){
			return $this -> _animation_type;
		}
		
		public function setAnimationData($pAnimationData){
			$this -> _animation_data = $pAnimationData;
		}
		
		public function getAnimationData(){
			return $this -> _animation_data;
		}
		
		public function getBases(){
			return $this -> _bases;	
		}
		
		public function setBases($pBases){
			$this -> _bases = $pBases;	
		}
		
		/**
		 * @setter
		 *
		 * Permet d'attribuer une valeur à une propriété 'private'.
		 *
		 * @param 'string' La propriété à changer.
		 * @param '*' Attribue une valeur à certaines propriétés 'private'.
		 */
		public function __set($pProp, $pValue){
			switch($pProp){
				case "data_animation" : 
					$this -> _animation_data = $pValue;
					break;
				default : 
					break;
			}
		}
		
		/**
		 * @getter
		 *
		 * Permet de récupéré une valeur d'une propriété 'private'.
		 *
		 * @param '*' Récupère la valeur de certaines propriétés 'private'.
		 */
		public function __get($pProp){
			$ret = NULL;
			switch($pProp){
				case "data_animation" : 
					$ret = $this -> _animation_data;
					break;
				default : 
					break;
			}
		 	return $ret;
		}
		
	}
	
?>