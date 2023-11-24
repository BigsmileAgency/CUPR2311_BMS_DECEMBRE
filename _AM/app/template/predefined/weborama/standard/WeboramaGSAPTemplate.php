<?php

	/*
 	 * Version: 2.00.8
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class WeboramaGSAPTemplate extends Template {

		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/weborama/standard/assets/index.php");
			$this -> _extImport = "";

			if(GSAPEngine::getVersion() === '1.18.0' && self::cdnLibraries()){
				$this -> _imports = array('i1' => '<script src="//media.adrcdn.com/scripts/external/tweenlite/1.18.0/TweenLite.min.js"></script>
		<script src="	//media.adrcdn.com/scripts/external/tweenlite/1.18.1/TimelineLite.min.js"></script>
		<script src="//media.adrcdn.com/scripts/external/tweenlite/1.18.1/easing/EasePack.min.js"></script>
		<script src="//media.adrcdn.com/scripts/external/tweenlite/1.18.1/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="//media.adrcdn.com/scripts/external/tweenlite/1.18.0/TweenMax.min.js"></script>');
	} else if(GSAPEngine::getVersion() === '1.19.0' && self::cdnLibraries()){ 
		$this -> _imports = array('i1' => '<script src="//media.adrcdn.com/scripts/external/tweenlite/1.19.0/TweenLite.min.js"></script>
<script src="	//media.adrcdn.com/scripts/external/tweenlite/1.19.0/TimelineLite.min.js"></script>
<script src="//media.adrcdn.com/scripts/external/tweenlite/1.19.0/easing/EasePack.min.js"></script>
<script src="//media.adrcdn.com/scripts/external/tweenlite/1.19.0/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="//media.adrcdn.com/scripts/external/tweenlite/1.19.0/TweenMax.min.js"></script>');

		} else {
		$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');

	}

		}

	}

?>
