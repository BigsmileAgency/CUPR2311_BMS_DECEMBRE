<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class SquashEase extends AnimationEase {
		protected $name;

		public function __construct($name){
			parent::__construct(AnimationEaseType::SQUASHBOUNCE);
			$this -> name = $name;
			
		}

		public function name(){
			return $this -> name;	
		}

	}

?>
