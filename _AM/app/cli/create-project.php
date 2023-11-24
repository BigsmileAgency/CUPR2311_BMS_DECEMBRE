<?php 

	class CreateProject {

		public $name;
		public $type;
		public $version;
		public $gfont;
		public $splitText;
		public $drawSVG;
		public $morphSVG;
		public $exemple;
		public $formats = array();
		public $langs = array();
		public $base;
		public $floc;

		
		public function __construct($name, $formats = "300x250", $langs = "FR", $type = 'dcm', $gfont = false, $splitText = false, $drawSVG = false, $morphSVG = false, $exemple = false, $version = '1.19.1'){
			$this -> name = $name;
			$this -> type = $type;
			$this -> version = $version;
			$this -> gfont = $gfont;
			$this -> splitText = $splitText;
			$this -> drawSVG = $drawSVG;
			$this -> morphSVG = $morphSVG;
			$this -> exemple = $exemple;
			$this -> base = realpath(dirname(__FILE__)).'/../../';
			$this -> floc = realpath(dirname(__FILE__)).'/'.$this -> type.'/';

			//check type existence 
			if(!is_dir($this -> floc)){
				throw new Exception('Type does not exists!');
				die();
			}

			if(is_array($formats)){
				$this -> formats = $formats;
			} else {
				array_push($this -> formats, $formats);
			}
			if(is_array($langs)){
				$this -> langs = $langs;
			} else {
				array_push($this -> langs, $langs);
			}
		}

		public function create(){


			//create dir 
			if(is_dir($this -> base.strtoupper($this->name))){
				throw new Exception('Dir exists!');
				die();
			}

			mkdir($this -> base.strtoupper($this->name), 0777);
			copy($this -> floc.'index.php', $this -> base.$this -> name.'/index.php'); 
			$this -> recurse_copy($this -> floc.'common', $this -> base.$this -> name.'/common');

			rename($this -> base.$this -> name.'/common/project_settings.php', $this -> base.$this -> name.'/common/project.php');

			$settings = file_get_contents($this -> base.$this -> name.'/common/settings.php');
			$settings = str_replace('[[name]]', '\''.strtoupper($this->name).'\'', $settings);
			$settings = str_replace('[[version]]', '\''.$this->version.'\'', $settings);
			$settings = str_replace('[[type]]', '\''.$this->type.'\'', $settings);

			$index = file_get_contents($this -> base.$this -> name.'/index.php');
			$index = str_replace('[[lang]]', '\''.$this-> langs[0].'\'', $index);

			file_put_contents($this -> base.$this -> name.'/common/settings.php', $settings);
			file_put_contents($this -> base.$this -> name.'/index.php', $index);

			$this -> recurse_copy($this -> floc.'[[name]]-DATA', $this -> base.$this -> name.'/'.strtoupper($this->name).'-DATA');
			
			$index = $this -> base.$this -> name.'/'.strtoupper($this->name).'-DATA/index.php';
			$commonjs = $this -> base.$this -> name.'/common/common.js.php';
			
			$timeline = $this -> base.$this -> name.'/common/timeline.php';
			$assets = $this -> base.$this -> name.'/common/assets.php';
			$settings = $this -> base.$this -> name.'/common/settings.php';

			if($this -> gfont){
				$this -> exec_directives('GFont', array($index, $commonjs));
				$this -> suppress_directives('noGFont', array($index, $commonjs));
			} else {
				$this -> exec_directives('noGFont', array($index, $commonjs));
				$this -> suppress_directives('GFont', array($index, $commonjs));
			}

			if($this -> splitText){
				$this -> exec_directives('splitText', array($timeline, $assets, $index, $commonjs));
			} else {
				$this -> suppress_directives('splitText', array($timeline, $assets, $index, $commonjs));
			}

			if($this -> drawSVG){
				$this -> exec_directives('drawSVG', array($timeline, $assets, $index, $commonjs));
			} else {
				$this -> suppress_directives('drawSVG', array($timeline, $assets, $index, $commonjs));
			}

			if($this -> morphSVG){
				$this -> exec_directives('morphSVG', array($timeline, $assets, $index, $commonjs));
			} else {
				$this -> suppress_directives('morphSVG', array($timeline, $assets, $index, $commonjs));
			}

			if($this -> exemple){
				$this -> exec_directives('exemple', array($timeline, $assets, $index, $commonjs, $settings));
			} else {
				$this -> suppress_directives('exemple', array($timeline, $assets, $index, $commonjs, $settings));
			}
		
			foreach($this -> formats as $format) {
				$this -> recurse_copy($this -> floc.'[[name]]-[[format]]', $this -> base.$this -> name.'/'.strtoupper($this->name).'-DATA/'.strtoupper($this->name).'-'.$format);

				$data = $this -> base.$this -> name.'/'.strtoupper($this->name).'-DATA/'.strtoupper($this->name).'-'.$format.'/data.php';

				if($this -> splitText){
					$this -> exec_directives('splitText', $data);
				} else {
					$this -> suppress_directives('splitText', $data);
				}

				if($this -> drawSVG){
					$this -> exec_directives('drawSVG', $data);
				} else {
					$this -> suppress_directives('drawSVG', $data);
				}

				if($this -> morphSVG){
					$this -> exec_directives('morphSVG', $data);
				} else {
					$this -> suppress_directives('morphSVG', $data);
				}

				if($this -> exemple){
					$this -> exec_directives('exemple', $data);
				} else {
					$this -> suppress_directives('exemple', $data);
				}

			}
		}

		protected function recurse_copy($src,$dst) { 
		    $dir = opendir($src); 
		    @mkdir($dst); 
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		               $this -> recurse_copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		            else { 
		                copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		        } 
		    } 
		    closedir($dir); 
		} 

		protected function suppress_directives($directive,$src) { 
			if(is_array($src)){
				foreach($src as $s){
					$f = file_get_contents($s);
				    $f = preg_replace('/\[\['.$directive.'\]\](.*?)\[\[!'.$directive.'\]\]/s', '', $f);
				    file_put_contents($s, $f);
				}
			} else {
				$f = file_get_contents($src);
			    $f = preg_replace('/\[\['.$directive.'\]\](.*?)\[\[!'.$directive.'\]\]/s', '', $f);
			    file_put_contents($src, $f);
			}
		   
		} 

		protected function exec_directives($directive,$src) {
			if(is_array($src)){
				foreach($src as $s){
					$f = file_get_contents($s);
				    $f = preg_replace('/(?:(?:\[\['.$directive.'\]\])|(?:\[\[!'.$directive.'\]\]))/', '', $f);
				    file_put_contents($s, $f);
				}
			} else {
				$f = file_get_contents($src);
			    $f = preg_replace('/(?:(?:\[\['.$directive.'\]\])|(?:\[\[!'.$directive.'\]\]))/', '', $f);
			    file_put_contents($src, $f);
			} 
		   
		} 

	} 

	print("Campaign Name (default new-project): ");
	$handle = fopen ("php://stdin","r");
	$name = fgets($handle);
	$name = trim($name) != "" ? trim($name) :  "new-project";
	fclose($handle);

	print("Campaign Technology (default dcm): ");
	$handle = fopen ("php://stdin","r");
	$type = fgets($handle);
	$type = trim($type) != "" ? strtolower(trim($type)) :  "dcm";
	fclose($handle);
	//$type = "dcm";

	print("Lang Master (default FR): ");
	$handle = fopen ("php://stdin","r");
	$langs = fgets($handle);
	$langs = trim($langs) != "" ? trim($langs) :  "FR";
	fclose($handle);

	print("Format Master (default 300x250): ");
	$handle = fopen ("php://stdin","r");
	$formats = fgets($handle);
	$formats = trim($formats) != "" ? trim($formats) :  "300x250";
	fclose($handle);

	print("GSAP Version (default 1.19.1): ");
	$handle = fopen ("php://stdin","r");
	$version = fgets($handle);
	$version = trim($version) != "" ? trim($version) :  "1.19.1";
	fclose($handle);


	do {
		print("Do you want to use Google Fonts (Y/N) (default N): ");
		$handle = fopen ("php://stdin","r");
		$v = fgets($handle);
		$v = trim(strtoupper($v)) == '' ? 'N' : $v;
		$gfont = trim(strtoupper($v)) == 'Y' ? true : (trim(strtoupper($v)) == 'N' ? false : false);
		fclose($handle);
	} while(!(trim(strtoupper($v)) == 'Y' || trim(strtoupper($v)) == 'N'));

	do {
		print("Do you want to use SplitText from GSAP (Y/N) (default N): ");
		$handle = fopen ("php://stdin","r");
		$v = fgets($handle);
		$v = trim(strtoupper($v)) == '' ? 'N' : $v;
		$splitText = trim(strtoupper($v)) == 'Y' ? true : (trim(strtoupper($v)) == 'N' ? false : false);
		fclose($handle);
	} while(!(trim(strtoupper($v)) == 'Y' || trim(strtoupper($v)) == 'N'));


	do {
		print("Do you want to use DrawSVG from GSAP (Y/N) (default N): ");
		$handle = fopen ("php://stdin","r");
		$v = fgets($handle);
		$v = trim(strtoupper($v)) == '' ? 'N' : $v;
		$drawSvg = trim(strtoupper($v)) == 'Y' ? true : (trim(strtoupper($v)) == 'N' ? false : false);
		fclose($handle);
	} while(!(trim(strtoupper($v)) == 'Y' || trim(strtoupper($v)) == 'N'));

	do {
		print("Do you want to use MorphSVG from GSAP (Y/N) (default N): ");
		$handle = fopen ("php://stdin","r");
		$v = fgets($handle);
		$v = trim(strtoupper($v)) == '' ? 'N' : $v;
		$morphSVG = trim(strtoupper($v)) == 'Y' ? true : (trim(strtoupper($v)) == 'N' ? false : false);
		fclose($handle);
	} while(!(trim(strtoupper($v)) == 'Y' || trim(strtoupper($v)) == 'N'));

	do {
		print("Do you want to display exemples (Y/N) (default Y): ");
		$handle = fopen ("php://stdin","r");
		$v = fgets($handle);
		$v = trim(strtoupper($v)) == '' ? 'Y' : $v;
		$exemple = trim(strtoupper($v)) == 'Y' ? true : (trim(strtoupper($v)) == 'N' ? false : false);
		fclose($handle);
	} while(!(trim(strtoupper($v)) == 'Y' || trim(strtoupper($v)) == 'N'));


	try{
		$o = new CreateProject($name, $formats, $langs, $type, $gfont, $splitText, $drawSvg, $morphSVG, $exemple, $version);
		$o -> create();
	} catch(Exception $e) {
		die('ERROR => '.$e->getMessage());
	}

	
?>