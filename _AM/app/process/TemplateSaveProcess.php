<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class TemplateSaveProcess extends Process {
		
		protected $_template;
		protected $_destination;
		protected $_tmp_destination;
		protected $_duplicTemplate;
		protected $_data_passed = array();
		protected static $_remove_before = true;
		
		public function __construct(Template $pTemplate, $pDest = "", $uiViewDest = null) {
			parent::__construct();
			 $uiViewDest = is_null($uiViewDest) ? AppPath::getPath()."/temporary/uiview/" : $uiViewDest;
			$this -> _template = $pTemplate;
			//$this -> _duplicTemplate = new Template($pDest."/".basename($this -> _template -> getHTML()));
			$this -> _duplicTemplate = new Template($pDest."/".basename('index.html'));
			$this -> _duplicTemplate -> setExternalImport($this -> _template -> getExternalImport());
			// $this -> _duplicTemplate -> setImports($this -> _template -> getImports('i1'), 'i1');
			$this -> _duplicTemplate -> setImports($this -> _template -> getImports('i2'), 'i2');
			$this -> _destination = $pDest;
			$this -> _tmp_destination = $uiViewDest;
		}
		
		protected function _remove_directory($pDir) {
			if(!is_dir($pDir)) {
				throw new InvalidArgumentException("parameter must be a directory");
				die();
			}
			if(substr($pDir, strlen($pDir) - 1, 1) != '/') {
				$pDir .= '/';
			}
			$files = glob($pDir . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					$this -> _remove_directory($file);
				} else {
					unlink($file);
				}
			}
			rmdir($pDir);
		}
		
		public function apply(){

			if(self::$_remove_before){
				if(is_dir($this -> _destination)){
					$this -> _remove_directory($this -> _destination);
				}
				if(is_dir($this -> _tmp_destination)){
					$this -> _remove_directory($this -> _tmp_destination);
				}
			}
			
			$dir_line = explode("/", $this -> _destination);
			$next_dir = "";
			foreach($dir_line as $d){
				if($d !== ""){
					$next_dir .= $d;
					if(!is_dir($next_dir))
						mkdir($next_dir, 0755); // Windows Chmod debug
					$next_dir .= "/";
					
				}
			}

			if(count(Module::all())){

				$dir_line_tmp = explode("/", $this -> _tmp_destination);
				$next_dir_tmp = "";
				foreach($dir_line_tmp as $d){
					if($d !== ""){
						$next_dir_tmp .= $d;
						if(!is_dir($next_dir_tmp))
							mkdir($next_dir_tmp, 0755); // Windows Chmod debug
						$next_dir_tmp .= "/";
						
					}
				}

			}
			
			$new_file = FormatContent::formattedContent($this -> _template -> getHTML(),$this -> _data_passed);
			$f = fopen($next_dir.basename('index.html'), 'w+');
			fwrite($f, $new_file);
			fclose($f);


			FormatContent::formattedContent($this -> _data_passed['data_template'] -> getHTML(),$this -> _data_passed);

			$assets_origins = $this -> _data_passed['data_template']-> getAssets() -> getAssets();

			foreach($assets_origins as $asset){
				FormatContent::formattedContent($asset -> getFile(),$this -> _data_passed);
			}


			$valids = array();
			$valid_count = 0;

			//copy($html = $this -> _template -> getHTML(), $next_dir.basename('index.html'));
			$assets = $this -> _template -> getAssets() -> getAssets();
			
			do {
				$valid_count = count($valids);
				foreach($assets as $asset){
					if($asset -> ready()){
						if(!in_array($asset, $valids)){
							//Active php of obj 
							FormatContent::formattedContent($asset -> getFile(),$this -> _data_passed ,$this -> _data_passed, $assets, $this);
							$valids[] = $asset;
						}
					}
				}
			} while ($valid_count !== count($valids));

			foreach($valids as $asset){
				copy($asset_name = $asset -> getFile(), $next_dir.basename($asset_name));
				$asset_dup = new Asset($asset -> getName(), $next_dir.basename($asset_name), $asset -> getType());
				$this -> _duplicTemplate -> add($asset_dup);
			}
			
		}
		
		public function getNewTemplate(){
			return $this -> _duplicTemplate;
		}
		
		public function passData($array){
			$this -> _data_passed = $array;
		}

		public function copy($source = null, $dest = null){

			$source = is_null($source) ? $this -> _destination : $source ;
			$dest = is_null($dest) ? $this -> _tmp_destination : $dest ;

		    if (is_link($source)) {
		        return symlink(readlink($source), $dest);
		    }

		    if (is_file($source)) {
		        return copy($source, $dest);
		    }

		    if (!is_dir($dest)) {
		        mkdir($dest, '0755');
		    }

		    $dir = dir($source);
		    while (false !== $entry = $dir->read()) {
		        if ($entry == '.' || $entry == '..') {
		            continue;
		        }

		        $this->copy("$source/$entry", "$dest/$entry");
		    }

		    $dir->close();
		    return true;
		}

		public static function deleteOldFolder($bool){
			self::$_remove_before = (bool)$bool;
		}

	
	}
	
?>