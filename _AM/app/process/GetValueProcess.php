<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class GetValueProcess extends Process {
		
		protected $_template;
		protected $_values;
		protected $_data_passed = array();

		
		public function __construct(Template $pTemplate) {
			parent::__construct();
			$this -> _template = $pTemplate;
			$this -> _values = array();
		}
		
		

		protected function prepareForCompilation($p, $m){
			$ext = substr($p , strrpos($p , '.') + 1);
			$other = substr($p ,0, strrpos($p , '.'));
			
			if($ext == "php"){
				if(strrpos($other, '.')){
					$ext =  $ext = substr($other , strrpos($other , '.') + 1);
				}
			}

			if($ext == "less"){
				$html = "<!-- CompileProcess:beginCompileToLESS -->".$m."<!-- CompileProcess:endCompileToLESS -->";
			}
			else if($ext == "scss") {
				$html = "<!-- CompileProcess:beginCompileToSCSS -->".$m."<!-- CompileProcess:endCompileToSCSS -->";
			} else {
				$html = $m;	
			}
			
			return $html;
		}


		public function passData($array){
			$this -> _data_passed = $array;
		}

		protected function freeze($content){
			return preg_replace('/(<\!--(.*?)-->)/', '/*$1*/', $content);

		}

		protected function unfreeze($content){
			return preg_replace('/(?:\/\*(<\!--(.*?)-->)\*\/)/', '$1', $content);
		}

		
		public function apply(){
			
			$html_path = $this -> _template -> getHTML();
			$html = FormatContent::formattedContent($html_path, $this -> _data_passed);
			$ret = array();
			$assets_array  = array();
			$assets = $this -> _template -> getAssets() -> getAssets();
			
			foreach($assets as $asset){
				$type = $asset -> getType();

				if($type == AssetType::HTML || $type == AssetType::CSS || $type == AssetType::JS || $type == AssetType::SVG || $type == AssetType::XML || $type == AssetType::JSON){
					$asset_path = $asset -> getFile();
					$asset_obj = FormatContent::formattedContent($asset_path, $this -> _data_passed);
					array_push($assets_array, array($asset, $asset_obj));
				} else {
					array_push($assets_array, array($asset, file_get_contents($asset -> getFile())));
				}	
			}
			
			
			
			foreach($this -> _values as $v){

				if(preg_match("/<!-- GetValueProcess:begin".$v." -->(.*)<!-- GetValueProcess:end".$v." -->/isU", $html, $matches)){
					$ret[$v] = $matches[1];
				}
				$i = 0;
				foreach($assets_array as $obj){
					if(preg_match("/<!-- GetValueProcess:begin".$v." -->(.*)<!-- GetValueProcess:end".$v." -->/isU", $assets_array[$i][1], $matches)){
						$ret[$v] = $this -> prepareForCompilation($assets_array[$i][0] -> getFile(), $matches[1]);
					}
					$i++;
				}
			}
			return $ret;

			
		}
		
		public function get($value){
			array_push($this -> _values, $value);
		}
	}
	
?>