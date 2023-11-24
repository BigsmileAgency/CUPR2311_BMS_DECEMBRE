<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class CustomWiggle extends AnimationEase {

		protected $wiggles;
		protected $type;
		protected $name;
		protected $path;
		protected $amplitudeEasing;
		protected $timingEasing;
		protected $accepted = array('easeOut', 'easeInOut', 'anticipate', 'uniform', 'random');

		public function __construct($wiggles = 6, $type = 'uniform', AnimationEase $timing = null, AnimationEase $amplitude = null){
			parent::__construct(AnimationEaseType::CUSTOMWIGGLE);

			$path = null;
			$e = array_filter(self::$_builds, function($e) use ($wiggles, $type, $path, $timing, $amplitude) {
				return $e instanceof self && intval($wiggles) === $e->wiggles() && trim($type) === $e->type() && $path === $e->path() && $timing === $e->timing() && $amplitude === $e->amplitude();
			});
			if(count($e)) {
				$clone = array_values($e)[0];
				$this -> name = $clone->name();
				$this -> path = $clone->path();
				$this -> wiggles = $clone->wiggles();
				$this -> type = $clone->type();
				$this -> amplitudeEasing = $clone->amplitude();
				$this -> timingEasing = $clone->timing();
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
				$this -> wiggles = intval($wiggles);
				$this -> amplitudeEasing = $amplitude;
				$this -> timingEasing = $timing;
				$path = !is_null($path)? trim($path) : null; 

				if(!in_array($type, $this -> accepted) && !is_null($type)) {
					throw new Exception('type is not accepted for CustomWiggle ease');
				}
				$this -> type = !is_null($type) ? trim($type) : null;
				array_push(self::$_builds, $this);
			}
		}

		public function path(){
			return $this -> path;	
		}

		public function amplitude(){
			return $this -> amplitudeEasing;	
		}

		public function timing(){
			return $this -> timingEasing;	
		}


		public function wiggles(){
			return $this -> wiggles;
		}

		public function type(){
			return $this -> type;
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
