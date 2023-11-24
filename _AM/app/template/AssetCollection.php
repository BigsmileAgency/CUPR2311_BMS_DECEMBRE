<?php

	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/

	class AssetCollection {

		private $_assets;
		private $_dc;

		/**
		 * @constructor
		 */
		public function __construct(){
			$this -> _assets = array();
		}

		public function add(Asset $pAssets){
			$n = $this -> findByName($pAssets -> getName());
			$f = $this -> findByFile($pAssets -> getFile());

			if(!is_null($n)){
				throw new Exception('An asset with the name \''.$pAssets -> getName().'\' exist');
				die();
			} else if(!is_null($f)){
				throw new Exception('An asset with the path \''.$pAssets -> getFile().'\' exist');
				die();
			}

			$val = DimensionsCatch::dim($pAssets -> getFile());

			if(count($val)) {
				$this -> _dc[$pAssets -> getName()]  = $val[0];
			}

			array_push($this -> _assets, $pAssets);
			return $this;
		}

		public function remove(Asset $pAssets){
			foreach($this -> _assets as $k => $v) {
            	if($v === $pAssets) {
                	unset($this -> _assets[$k]);
                	unset($this -> _dc[$pAssets -> getName()]);
                	$this -> _assets = array_values($this -> _assets);
                	break;
            	}
        	}
        	return $this;
		}

		public function getAssets(){
			return $this -> _assets;
		}

		public function setAssets($pAssets){
			$this -> _assets = $pAssets;
		}

		public function findByName($pAsset){
			$ret = NULL;
			for($i = 0; $i < count($this -> _assets); $i++){
				$n = $this -> _assets[$i] -> getName();
				if($n === $pAsset){
					$ret = $this -> _assets[$i];
					break;
				}
			}
			return $ret;
		}

		public function findByFile($pAsset){
			$ret = NULL;
			for($i = 0; $i < count($this -> _assets); $i++){
				$n = $this -> _assets[$i] -> getFile();
				if($n === $pAsset){
					$ret = $this -> _assets[$i];
					break;
				}
			}
			return $ret;
		}


		protected function download($pAsset){
			$ret = NULL;
			for($i = 0; $i < count($this -> _assets); $i++){
				$n = $this -> _assets[$i] -> getName();
				if($n === $pAsset){
					$this -> _assets[$i] -> download();
					break;
				}
			}
		}

		protected function ready($pAsset){
			$ret = NULL;
			for($i = 0; $i < count($this -> _assets); $i++){
				$n = $this -> _assets[$i] -> getName();
				if($n === $pAsset){
					$ret = $this -> _assets[$i] -> ready();
					break;
				}
			}
			return $ret;
		}



		public function path($pAsset){
			$n = $this -> findByName($pAsset);

			if(is_null($n)){
				throw new Exception('An asset with the name \''.$pAsset.'\' does not exist');
				die();
			}
			$this -> download($pAsset);
			return substr($n -> getFile(), strrpos($n -> getFile(), '/') + 1);
		}

		public function width($pAsset){
			$n = $this -> findByName($pAsset);

			if(is_null($n)){
				throw new Exception('An asset with the name \''.$pAsset.'\' does not exist');
				die();
			}

			return isset($this -> _dc[$n->getName()]['width']) ? $this -> _dc[$n->getName()]['width'] : null ;
		}

		public function height($pAsset){
			$n = $this -> findByName($pAsset);

			if(is_null($n)){
				throw new Exception('An asset with the name \''.$pAsset.'\' does not exist');
				die();
			}

			return isset($this -> _dc[$n->getName()]['height']) ? $this -> _dc[$n->getName()]['height'] : null ;
		}



	}

?>