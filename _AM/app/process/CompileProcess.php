<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class CompileProcess extends Process {

		protected $_template;
		protected $_values;
		protected $_data_passed = array();
		protected $_compiler;
		protected $_paths;
		protected $_valid_path;


		public function __construct(Template $pTemplate) {
			parent::__construct();
			$this -> _paths = array("imports", "common/imports", "master/imports", self::$path."/libs/[:class:]php/imports");
			$this -> _template = $pTemplate;
			$this -> _values = array();
		}


		protected function compileContent($m){


			if(preg_match('/<!-- CompileProcess:beginCompileToLESS -->(.*)<!-- CompileProcess:endCompileToLESS -->/isU', $m, $matches)){
				require_once AppPath::getPath().'/libs/lessphp/lessc.inc.php';
				$this -> _compiler = new lessc();
				$this -> _validPath($this -> _compiler);
				if($this -> _valid_path)
					$this -> _compiler -> importDir = array($this -> _valid_path);
				$html = preg_replace_callback('/<!-- CompileProcess:beginCompileToLESS -->(.*)<!-- CompileProcess:endCompileToLESS -->/isU', array($this, '_compile'), $m);
			}
			else if(preg_match('/<!-- CompileProcess:beginCompileToSCSS -->(.*)<!-- CompileProcess:endCompileToSCSS -->/isU', $m, $matches)){
				require_once AppPath::getPath().'/libs/scssphp/scss.inc.php';
				$this -> _compiler = new scssc();
				$this -> _validPath($this -> _compiler);
				if($this -> _valid_path)
					$this -> _compiler -> addImportPath($this -> _valid_path);
				$html = preg_replace_callback('/<!-- CompileProcess:beginCompileToSCSS -->(.*)<!-- CompileProcess:endCompileToSCSS -->/isU',  array($this, '_compile') , $m);
			} else {
				$html = $m;
			}

			return $html;
		}


		protected function _compile($m){
			return $this -> _compiler -> compile($m[1]);
		}


		public function apply(){

			$html = file_get_contents($this -> _template -> getHTML());

			$assets_array  = array();
			$assets = $this -> _template -> getAssets() -> getAssets();

			foreach($assets as $asset){
				$type = $asset -> getType();
				if($type == AssetType::HTML || $type == AssetType::CSS || $type == AssetType::JS || $type == AssetType::SVG || $type == AssetType::XML || $type == AssetType::JSON)
					array_push($assets_array, array($asset, file_get_contents($asset -> getFile())));

			}


			$html = $this -> compileContent($html);


			$html_file = fopen($this -> _template -> getHTML(), "w+");
			fwrite($html_file, $html);
			fclose($html_file);


			$i = 0;
			foreach($assets_array as $obj){
				$asset_file = fopen($assets_array[$i][0] -> getFile(), "w+");
				$assets_array[$i][1] = $this -> compileContent($assets_array[$i][1]);
				fwrite($asset_file, $assets_array[$i][1]);
				fclose($asset_file);
				$i++;
			}

		}

		protected function _validPath($obj){
			$this -> _valid_path = null;
			foreach($this -> _paths as $p){
				if(strpos($p, '[:class:]')){
					$c = get_class($obj);
					$c = $c == 'lessc' ? 'less' : ($c == 'scssc' ? 'scss' : $c);
					$p = str_replace('[:class:]', $c , $p);
					if(is_dir($p)){
						$this -> _valid_path = $p;
						break;
					}
				} else{
					if(is_dir($p)){
						$this -> _valid_path = $p;
						break;
					}
				}
			}
		}

	}

?>
