<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class Template {
		
		protected $_html;
		protected $_assets;
		protected $_assets_scheme;
		protected $_extImport;
		protected $_imports;
		protected static $path;
		protected static $sharedLib = false;
		
		public function __construct($pHTMLfile = 'index.html'){
			$this -> _assets = new AssetCollection();
			$this -> _html = $pHTMLfile;
			self::$path = AppPath::getPath();
		}
		
		public static function usecdnLibraries($pBool){
			self::$sharedLib = (bool)$pBool;
		}
		
		public static function cdnLibraries(){
			return self::$sharedLib;
		}
		
		public function getAssetsScheme($p = 'i1'){
			return $this -> _assets_scheme[$p];
		}
		
		
		public function getAssets(){
			return $this -> _assets;
		}
		
		public function getHTML(){
			return $this -> _html;
		}
		
		
		public function add($pAssets){
		
			if(is_array($pAssets)){
				foreach($pAssets as $obj){
					if($obj instanceof AssetCollection){
						$this -> _addAssetCollection($obj);
					} else if($obj instanceof Asset) {
						$this -> _addAsset($obj);
					}
				}
			} else if($pAssets instanceof AssetCollection) {
				$this -> _addAssetCollection($pAssets);
			} else if($pAssets instanceof Asset) {
				$this -> _addAsset($pAssets);
			} 
			return $this;
		}
		
		protected function _addAsset(Asset $pAsset){
			$this -> _assets -> add($pAsset);
		}
		
		protected function _addAssetCollection(AssetCollection $pAssetsCollection){
			$objs = $pAssetsCollection -> getAssets();
			if(count($objs)){
				foreach($objs as $objs){
					$this -> _addAsset($objs);
				}
			
			}
		}
		
		public function setExternalImport($value){
			$this -> _extImport = $value;
		}
		
		public function getExternalImport(){
			return $this -> _extImport;
		}
		
		public function setImports($value, $p = 'i1'){
			$this -> _imports[$p] = $value;
		}
		
		public function getImports($p = 'i1'){
			return $this -> _imports[$p];
		}
		

		
	}
	
?>