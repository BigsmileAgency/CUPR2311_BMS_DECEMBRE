<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	final class Animation {

		private $_name;
		private $_delay;
		private $_duration;
		private $_prefix;
		private $_ease;
		private $_end_key;
		private $_stagger;
		private $_stagger_delay;
		private $_first = false;
		private static $_n = 0;
		//private $_name;

		/**
		 * @constructor
		 */
		public function __construct($pPrefix = NULL, $pDelay = NULL, $pDuration = NULL, AnimationEase $pEase = NULL, $pStagger = false, $pStagger_delay = 0){
			$this -> setDelay($pDelay);
			$this -> setDuration($pDuration);
			$this -> setPrefix($pPrefix);
			if($pEase instanceof CustomEase || $pEase instanceof CustomWiggle || $pEase instanceof CustomBounce){
				$all = CustomEase::stored();
				foreach($all as $ease_stored){
					if($pEase->name() === $ease_stored->name()) {
						$ease_stored->used = true;
					}
				}
				$pEase -> used = true;
			}
			$this -> setEase($pEase);
			$this -> EnableStagger($pStagger);
			$this -> setStaggerDelay($pStagger_delay);
			$this -> _name = 'animation_'.(self::$_n++);
		}
		
		public function first(){
			$this -> _first = true;
		}
		
		public function isFirst(){
			return $this -> _first;
		}

		/*public function setName($pName){
			$this -> _name = $pName;
		}
*/
		public function getName(){
			return $this -> _name;
		}

		public function setDelay($pDelay){
			$this -> _delay = round(floatval($pDelay), 2);
		}

		public function getDelay(){
			return round(floatval($this -> _delay), 2);
		}

		public function setDuration($pDuration){
			$this -> _duration = round(floatval($pDuration), 2);
		}

		public function getDuration(){
			return round(floatval($this -> _duration), 2);
		}

		public function setPrefix($pPrefix){
			$this -> _prefix = $pPrefix;
		}

		public function getPrefix(){
			return $this -> _prefix;
		}

		public function setEndKey($pEndKey){
			$this -> _end_key = round(floatval($pEndKey), 2);
		}

		public function getEndKey(){
			return round(floatval($this -> _end_key), 2);
		}

		public function setEase(AnimationEase $pEase){
			$this -> _ease = $pEase;
		}

		public function getEase(){
			return $this -> _ease;
		}


		public function EnableStagger($pBool){
			$this -> _stagger = (bool)$pBool;
		}

		public function isStagger(){
			return $this -> _stagger;
		}

		public function setStaggerDelay($pDelay){
			$this -> _stagger_delay = $pDelay;
		}

		public function getStaggerDelay(){
			return $this -> _stagger_delay;
		}




	}

?>
