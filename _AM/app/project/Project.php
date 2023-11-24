<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class Project {

		protected $_processes;
		protected $_engines;
		protected $_assets;
		protected $_template;
		protected $_campaign;
		protected $_css_file;
		protected $_import;
		protected $_animation_manager;
		protected $_path_name;

		protected $_testComputedStyleForFirefox = false;

		protected $_default_path = '';
		protected $_default_clicktag = 'http://www.google.com';
		protected $_default_custom_js;
		protected $_data_template;
		protected $_default_custom_css;
		protected $_data_passed = array();

		protected $_cubic_bezier_src;
		protected $_cubic_bezier_asset;

		protected $_custom_ease_src;
		protected $_custom_ease_asset;

		protected $_abs_exp;

		protected $_author;
		protected $_description;
		protected $_keywords;
		protected $_language;
		protected $_folder;

		public static $minify = true;
		protected static $accept_meta = false;
		protected $_dev_mode = false;


		/**
		 * @constructor
		 */
		public function __construct(Campaign &$pCampaign, Template $pTemplate, AnimationManager &$pAm, $default_css = null, $default_js = null){

			$this -> _keywords = 'banner, animation, html5, display';
			$this -> _author = $pCampaign -> getName();
			$this -> _description = $pCampaign -> getName();
			$this -> _language = 'fr';


			$this -> _processes = array();
			$this -> _engine = array();
			$this -> _template = $pTemplate;
			$this -> _animation_manager = $pAm;
			$this -> _campaign = $pCampaign;
			$this -> _cubic_bezier_src = '<script src="bezier-easing.js"></script>';
			$this -> _cubic_bezier_asset = true;

			$this -> _custom_ease_src = '<script src="CustomEase.min.js"></script>';
			$this -> _custom_ease_asset = true;

			$this -> _custom_wiggle_src = '<script src="CustomWiggle.min.js"></script>';
			$this -> _custom_wiggle_asset = true;

			$this -> _custom_bounce_src = '<script src="CustomBounce.min.js"></script>';
			$this -> _custom_bounce_asset = true;

			
			$this -> _default_custom_css = !is_null($default_css) ? $default_css : $this -> _campaign -> getName()."-DATA/".$this -> _campaign -> getFullName().'/custom.css';
			$this -> _default_custom_js =  !is_null($default_js) ? $default_js : $this -> _campaign -> getName()."-DATA/".$this -> _campaign -> getFullName().'/custom.js';


		}

		public function getExport(){
			return "export/".$this -> _folder."/".$this -> _campaign -> getFullName()."/index.html";
		}

		public function getExportDir(){
			return "export/".$this -> _folder."/".$this -> _campaign -> getFullName();
		}

		public function getAbsExport(){
			return 	$_SERVER['DOCUMENT_ROOT'].dirname(substr($_SERVER['PHP_SELF'], 1))."/export/".$this -> _folder."/".$this -> _campaign -> getFullName()."/index.html";

;
		}

		public function getAbsExportDir(){
			return 	$_SERVER['DOCUMENT_ROOT'].dirname(substr($_SERVER['PHP_SELF'], 1))."/export/".$this -> _folder."/".$this -> _campaign -> getFullName();
		}

		public function getAbsExportZip(){
			return 	$_SERVER['DOCUMENT_ROOT'].dirname(substr($_SERVER['PHP_SELF'], 1))."/export/".$this -> _folder."/ziparchives/".$this -> _campaign -> getFullName();
		}


		public function importEngineLibraries(GSAPEngine $enginegsap, $pos){

			if($enginegsap -> hasCustomEase()){
				$this -> _template -> setImports($this -> _template -> getImports($pos).$this ->_custom_ease_src, $pos);
				if($this ->_custom_ease_asset === true){
					$this -> _template -> add(
						new Asset("CustomEase", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/easing/CustomEase.min.js", AssetType::JS));
				}
			}

			if($enginegsap -> hasCustomWiggle()){
				$this -> _template -> setImports($this -> _template -> getImports($pos).$this ->_custom_wiggle_src, $pos);
				if($this ->_custom_wiggle_asset === true){
					$this -> _template -> add(
						new Asset("CustomWiggle", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/easing/CustomWiggle.min.js", AssetType::JS));
				}
			}

			if($enginegsap -> hasCustomBounce()){
				$this -> _template -> setImports($this -> _template -> getImports($pos).$this ->_custom_bounce_src, $pos);
				if($this ->_custom_bounce_asset === true){
					$this -> _template -> add(
						new Asset("CustomBounce", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/easing/CustomBounce.min.js", AssetType::JS));
				}
			}

			if($enginegsap -> hasCubicBezier()){
				$this -> _template -> setImports($this -> _template -> getImports($pos).$this ->_cubic_bezier_src, $pos);
				if($this ->_cubic_bezier_asset === true){
					$this -> _template -> add(new Asset("BezierEasing", AppPath::getPath()."/libs/bezier-easing-master/bezier-easing.js", AssetType::JS));
				}
			}



		}


		public function addAssets(AssetCollection $pAssets){
			$this -> _template -> add($pAssets);
			$this -> _assets  = $pAssets;
			$this -> _data_passed['assets']  = $pAssets;
			Module::pass($this -> _data_passed);
		}



		public function setLanguage($language){
			$this -> _language = $language;
		}

		public function getLanguage(){
			return	$this -> _language;
		}

		public function setAuthor($author){
			$this -> _author = $author;
		}

		public function getAuthor(){
			return	$this -> _author;
		}

		public function setDescription($description){
			$this -> _description = $description;
		}

		public function getDescription(){
			return	$this -> _description;

		}

		public function setKeywords($keywords){
			$this -> _keywords = $keywords;
		}

		public function getKeywords(){
			return	$this -> _keywords;

		}

		
		public function passData($array){
			foreach($array as $a => $b){
				if( $a == 'data_template' ||
				    $a == 'assets' ||
				    $a == 'meta' ||
				    $a == 'allowEvents' ||
				    $a == 'devMode' ||
				    $a == 'testComputedStyleForFirefox'){

					throw new Exception('Cannnot pass \'$'.$a.'\' because it is an allocated data name');
					die();
				}
			}
			$this -> _data_passed = $array;
			Module::pass($array);

		}

		public function obtainData(){
			return $this -> _data_passed;
		}

		public function clicktag($pValue){
			$this -> _default_clicktag = $pValue;
		}


		public function getCampaign(){
			return $this -> _campaign;
		}
		public function getAnimationManager(){
			return $this -> _animation_manager;
		}
		public function getTemplate(){
			return $this -> _template;
		}
		public function getProcesses(){
			return $this -> _processes;
		}

		public function addProcess($pProcesses){
			if(is_array($pProcesses)){
				foreach($pProcesses as $process){
					if($process instanceof Process) {
						$this -> _addProcess($process);
					}
				}
			} else if($pProcesses instanceof Process) {
				$this -> _addProcess($pProcesses);
			}
		}

		protected function _addProcess(Process $pProcess){
			array_push($this -> _processes, $pProcess);
		}


		public function addEngine($pEngines){
			if(is_array($pEngines)){
				foreach($pEngines as $engine){
					if($engine instanceof AnimationEngine) {
						$this -> _addEngine($engine);
					}
				}
			} else if($pEngines instanceof AnimationEngine) {
				$this -> _addProcess($pEngines);
			}
		}

		protected function _addEngine(AnimationEngine $pEngine){
			array_push($this -> _engine, $pProcess);
		}

		public static function acceptMeta(){
			self::$accept_meta = true;
		}

		public function devMode($bool){
			$this -> _dev_mode = (bool)$bool ? true : false;
		}

		public function testComputedStyleForFirefox($bool){
			$this -> _testComputedStyleForFirefox = (bool)$bool ? true : false;
		}
	


	}

?>
