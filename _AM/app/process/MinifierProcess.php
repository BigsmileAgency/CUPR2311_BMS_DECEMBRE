<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class MinifierProcess extends Process {
		
		protected $_template;
		
		public function __construct(Template $pTemplate) {
			parent::__construct();
			$this -> _template = $pTemplate;
		}
		
		
		
		public function apply(){
			
			$html = file_get_contents($this -> _template -> getHTML());

			$html = BasicMinifier::minify_all(BasicMinifier::minify_html($html));
			
			$assets_array  = array();
			$assets = $this -> _template -> getAssets() -> getAssets();
			
			foreach($assets as $asset){
				$type = $asset -> getType();
				if($type == AssetType::HTML || $type == AssetType::CSS || $type == AssetType::JS || $type == AssetType::SVG || $type == AssetType::XML){
					if($type == AssetType::HTML || $type == AssetType::SVG)
						array_push($assets_array, array($asset, BasicMinifier::minify_all(BasicMinifier::minify_html(file_get_contents($asset -> getFile())))));
					if($type == AssetType::CSS)
						array_push($assets_array, array($asset, BasicMinifier::minify_css(file_get_contents($asset -> getFile()))));
					if($type == AssetType::JS)
						array_push($assets_array, array($asset, BasicMinifier::minify_js(file_get_contents($asset -> getFile()))));
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
		
	}
	
?>