<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class CustomEase extends AnimationEase {

		protected $name;
		protected $path;
		

		public function __construct($path){
			parent::__construct(AnimationEaseType::CUSTOMEASE, null);
			$e = array_filter(self::$_builds, function($e) use ($path) {
				return $e instanceof self && trim($path) === $e->path();
			});
			if(count($e)) {
				$clone = array_values($e)[0];
				$this -> name = $clone->name();
				$this -> path = $clone->path();
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
				$this -> path = trim($path);
				array_push(self::$_builds, $this);
			}
		}
		
		public function path(){
			return $this -> path;	
		}

		public function name(){
			return $this -> name;	
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
