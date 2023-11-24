<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class HiMediaGSAPTemplate extends Template {
				
		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/himedia/standard/assets/index.php");
			$this -> _extImport = "";
			$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');

		}
		
	}
	
?>