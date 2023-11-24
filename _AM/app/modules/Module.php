<?php 

	
	class Module {

		protected static $_m = array();
		protected static $_data = array();
		public $project;


		public static function install($m){

			if(file_exists(AppPath::getPath().'/modules/'.$m.'/'.$m.'Module.php')){
				require_once(AppPath::getPath().'/modules/'.$m.'/'.$m.'Module.php');
				$c = $m.'Module';
				$a = array_filter(self::$_m, function($e) use($c) {
					return $e instanceof $c;
				});

				if(!count($a)) {
					array_push(self::$_m, new $c);
				}
			}
		}

		public static function get($m){
			if(file_exists(AppPath::getPath().'/modules/'.$m.'/'.$m.'Module.php')){
				require_once(AppPath::getPath().'/modules/'.$m.'/'.$m.'Module.php');
				$c = $m.'Module';
				$a = array_filter(self::$_m, function($e) use($c) {
					return $e instanceof $c;
				});

				if(count($a)) {
					return $a[0];
				}
			}
		}

		public static function all(){
			return self::$_m;
		}

		public static function pass($data){
			self::$_data = $data;
		}

		public static function data(){
			return self::$_data;
		}



	}


?>