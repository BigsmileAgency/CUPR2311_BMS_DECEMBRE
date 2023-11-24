<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class DCRMGSAPLightboxTemplate extends Template {
				
		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/dcrm/lightbox/assets/index.php");
			
			if(GSAPEngine::getVersion() === '1.18.0' && self::cdnLibraries()){
				$this -> _imports = array('i1' => '<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	tweenlite_1.18.0_56fa823cfbbef1c2f4d4346f0f0e6c3c_min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
		<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	easepack_1.18.0_ed5816e732515f56d96a67f6a2a15ccb_min.js"></script>
		<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	cssplugin_1.18.0_71489205621d46cbe88348eeb8fe493f_min.js"></script>', 'i2' => '<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	tweenmax_1.18.0_499ba64a23378545748ff12d372e59e9_min.js"></script>');
			} else {
			$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');

		}
		}
		
	}
	
?>