<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class SizmekExpandableGSAPTemplate extends Template {
		
		
		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/sizmek/expandable/assets/index.php");
			$this -> _assets_scheme = array(
			'i1' =>
			 array(new Asset('expandable_banner', AppPath::getPath()."/template/predefined/sizmek/expandable/assets/expandable_banner.js", AssetType::JS, true)),
			'i2' => 
			array(new Asset('single_expandable', AppPath::getPath()."/template/predefined/sizmek/expandable/assets/single_expandable.js", AssetType::JS, true)));

			if(GSAPEngine::getVersion() === '1.17.0' && self::cdnLibraries()){
				$this -> _imports = array('i1' => '<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_17_0/TweenLite.min.js"></script>
		<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_17_0/TimelineLite.min.js"></script>
		<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_17_0/easing/easepack.min.js"></script>
		<script src="
https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_17_0/plugins/cssplugin.min.js "></script>', 'i2' => '<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_17_0/TweenMax.min.js"></script>');
				


			} else if(GSAPEngine::getVersion() === '1.18.0' && self::cdnLibraries()){
				$this -> _imports = array('i1' => '<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_18_0/TweenLite.min.js"></script>
		<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_18_0/TimelineLite.min.js"></script>
		<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_18_0/easing/easepack.min.js"></script>
		<script src="
https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_18_0/plugins/cssplugin.min.js "></script>', 'i2' => '<script src="https://secure-ds.serving-sys.com/BurstingcachedScripts/libraries/greensock/1_18_0/TweenMax.min.js"></script>');
				


			} else {
				$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');
			}
		
		}
	}
	
?>