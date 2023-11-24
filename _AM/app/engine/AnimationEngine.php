<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	abstract class AnimationEngine {

		protected $_am;
		protected $_formatter;

		/**
		 * @constructor
		 */
		public function __construct(AnimationManager $am, FormatEngine $formatter) {
			$this -> _am = $am;
			$this -> _am -> gen();
			$this -> _formatter = $formatter;
		}

		abstract public function initResult();
		abstract public function animationResult();
		abstract public function completeResult();

		

	}

?>
