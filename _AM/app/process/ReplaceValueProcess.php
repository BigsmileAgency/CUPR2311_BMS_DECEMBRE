<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class ReplaceValueProcess extends Process {
		
		protected $_template;
		protected $_replacements;
		
		public function __construct(Template $pTemplate) {
			parent::__construct();
			$this -> _template = $pTemplate;
			$this -> _replacements = array();
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
			
			foreach($this -> _replacements as $repl){
				$html = str_replace("<!-- ReplaceValueProcess:".$repl[0]." -->", $repl[1], $html);
				$i = 0;
				foreach($assets_array as $obj){
					$assets_array[$i][1] = str_replace("<!-- ReplaceValueProcess:".$repl[0]." -->", $repl[1], $assets_array[$i][1]);
					$i++;
				}
			}
			
			$html_file = fopen($this -> _template -> getHTML(), "w+");
			fwrite($html_file, $html);
			fclose($html_file);
			
			$i = 0;
			foreach($assets_array as $obj){
				$asset_file = fopen($assets_array[$i][0] -> getFile(), "w+");
				fwrite($asset_file, $assets_array[$i][1]);
				fclose($asset_file);
				$i++;
			}
			
		}
		
		public function replace($pVal1, $pVal2){
			array_push($this -> _replacements, array($pVal1, $pVal2));
		}
	}
	
?>