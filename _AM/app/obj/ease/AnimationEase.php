<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class AnimationEase {

		protected $_type;
		protected $_cubic_array;
		protected $_config;
		protected $_config_p2;
		protected $_config_p3;
		public $used = false;
		protected static $_builds = [];

		public function __construct($pType,$pBezier = NULL){
			$this -> _type = $pType;
			$this -> _cubic_array = array();
			if($pBezier){
				$this -> bezier($pBezier);
			}
			else {
				$this -> bezier(array(0,0,0,0));
			}
		}

		public function bezier($pParams){
			$this -> _cubic_array[0] = strval((strpos($pParams[0],".") !== false) ? $pParams[0] : $pParams[0].".00");
			$this -> _cubic_array[1] = strval((strpos($pParams[1],".") !== false) ? $pParams[1] : $pParams[1].".00");
			$this -> _cubic_array[2] = strval((strpos($pParams[2],".") !== false) ? $pParams[2] : $pParams[2].".00");
			$this -> _cubic_array[3] = strval((strpos($pParams[3],".") !== false) ? $pParams[3] : $pParams[3].".00");
		}

		public function getType(){
			return $this -> _type;
		}

		public function config($pParam, $pParams2 = null, $pParams3 = null){
			$this -> _config = $pParam;

			if(!is_null($pParams2))
				$this -> _config_p2 = 	$pParams2;

			if(!is_null($pParams3))
				$this -> _config_p3 = 	$pParams3;
		}

		public function getConfig(){
			if(!is_null($this -> _config))
				$config = $this -> _config;
			else
				return null;

			if(!is_null($this -> _config_p2)){
				$config .= ', '.strval($this -> _config_p2);

				if(!is_null($this -> _config_p3)){
					$config .= ', '.strval($this -> _config_p3);
				}
			} else if(!is_null($this -> _config_p3)){
				$config .= ', null, '.strval($this -> _config_p3);
			}
			return $config;
		}


		public function getCubicArray(){
			return $this -> _cubic_array;
		}

		public static function stored(){
			return self::$_builds;
		}


	}

?>
