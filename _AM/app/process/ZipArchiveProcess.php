<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class ZipArchiveProcess extends Process {
		
		protected $_template;
		protected $_destination;
		protected $_location;
		
		public function __construct(Template $pTemplate = null, $pLoc = "", $pDest = "") {
			parent::__construct();
			$this -> _template = $pTemplate;
			$this -> _destination = $pDest;
			$this -> _location = $pLoc;
		}
		
		
		
		public function apply(){

			
			$dir_line = explode("/", $this -> _destination);
			$c = count($dir_line);

			$next_dir = "";
			$i = 0;
			foreach($dir_line as $d){
				if($i >= ($c -1)){
					$ef = $d;
					continue;
				}
				
				if($d !== ""){
					$next_dir .= $d;
					if(!is_dir($next_dir))
						mkdir($next_dir, 0777);
					$next_dir .= "/";
					
				}

				$i++;	
				
			}

			if(file_exists($next_dir.$ef.'.zip')){
				unlink($next_dir.$ef.'.zip');
			}

			$new_zip = new ZipArchive();
			$new_zip -> open(  $next_dir.$ef.'.zip' ,ZipArchive::CREATE );

			$sd = scandir( $this -> _location );

			$i = 0;

			foreach($sd as $s){
				if(!($s == '.' || $s === '..')){
					$new_zip -> addFile($this -> _location.'/'.$s);
					$new_zip->renameIndex($i, $s);

					$i++;
				}
			}

			$new_zip -> close();

		}
		
		
		
	
	}
	
?>