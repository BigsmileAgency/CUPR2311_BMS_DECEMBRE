<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class CustomBounce extends AnimationEase {

		protected $strength;
		protected $squash;
		protected $name;
		protected $squash_name;
		protected $path;
		

		public function __construct($strength = 1, $squash = 0){
			parent::__construct(AnimationEaseType::CUSTOMBOUNCE);

			$path = null;
			$e = array_filter(self::$_builds, function($e) use ($strength, $squash, $path) {
				return $e instanceof self && intval($strength) === $e->strength() && trim($squash) === $e->squash() && $path === $e->path();
			});
			if(count($e)) {
				$clone = array_values($e)[0];
				$this -> name = $clone->name();
				$this -> path = $clone->path();
				$this -> squash_name = $clone->squashName();
				$this -> strength = $clone->strength();
			} else {
				$new_name  =  $this -> new_name();
				$validName = false;
			
				while($validName == false){
					$e = array_filter(self::$_builds, function($e) use ($new_name) {
						return $new_name === $e->name();
					});

					if(!count($e)){
						$validName = true;
					} else {
						$new_name =  $this -> new_name();
					}
				}
				
				$this -> name = $new_name;
				$this -> squash_name = $this -> name.'-squash';
				$this -> strength = floatval($strength);
				$this -> squash = floatval($squash);
				$path = !is_null($path)? trim($path) : null; 
				array_push(self::$_builds, $this);
			}
		}

		public function path(){
			return $this -> path;	
		}

		public function strength(){
			return $this -> strength;	
		}

		public function squash(){
			return $this -> squash;	
		}


		
		public function name(){
			return $this -> name;	
		}

		public function squashName(){
			return $this -> squash_name;	
		}

		public function squashEase(){
			return new SquashEase($this -> squash_name);	
		}

		public function new_name(){
			$list = 'abcdefghijklmnopqrstuvwxyz';
			$l = strlen($list);
			$name = "";
			for($i = 0; $i < 20; $i++){
				$c = rand(0, $l -1);
				$e = substr($list, $c, 1);
				$e = (rand(1,2) % 2) ? strtoupper($e) : $e;
				$name .= $e;

			}
			return 'custom-ease-'.$name;
		}
	}

?>
