<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class GDNGSAPTemplate extends Template {

		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/gdn/standard/assets/index.php");

			if(self::cdnLibraries()){
				$this -> _imports = array('i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');
			} else {

        $this -> _assets_scheme = array('i2' => array(new Asset("TweenMax", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/TweenMax.min.js", AssetType::JS, true)));
    
        $this -> _imports = array('i2' => '<script src="TweenMax.min.js"></script>');
	
      }
      
			$this -> _extImport = "";
			

		}

	}

?>
