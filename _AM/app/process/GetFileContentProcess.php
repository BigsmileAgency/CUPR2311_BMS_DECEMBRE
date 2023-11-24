<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class GetFileContentProcess extends Process {

		protected $_template;
		protected $_storage = array();
		protected $_storage_content = array();
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

		
		public function store($name, $file){
			$this -> _storage[$name] = $file;
		}


		public function apply(){
			$ret = array();
			foreach($this -> _storage as $k => $store){
				if(file_exists($store)){
					$v = $this -> prepareForCompilation($store ,FormatContent::formattedContent($store, $this -> _data_passed));
				}
				else
					$v = "";
				array_push($this -> _storage_content, $v);
				$ret[$k] = $v;
			}

			return $ret;
			
		}
		
		
	}
	
?>