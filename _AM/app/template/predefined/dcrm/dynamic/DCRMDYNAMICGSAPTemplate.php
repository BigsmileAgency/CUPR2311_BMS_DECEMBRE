<?php

	/*
 	 * Version: 2.00.8
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class DCRMDYNAMICGSAPTemplate extends Template {

	// 	public function __construct(){
	// 		parent::__construct(AppPath::getPath()."/template/predefined/dcrm/dynamic/assets/index.php");

	// 		if(GSAPEngine::getVersion() === '1.18.0' && self::cdnLibraries()){
	// 			$this -> _imports = array('i1' => '<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	// tweenlite_1.18.0_56fa823cfbbef1c2f4d4346f0f0e6c3c_min.js"></script>
	// 	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
	// 	<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	// easepack_1.18.0_ed5816e732515f56d96a67f6a2a15ccb_min.js"></script>
	// 	<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	// cssplugin_1.18.0_71489205621d46cbe88348eeb8fe493f_min.js"></script>', 'i2' => '<script src="https://s0.2mdn.net/ads/studio/cached_libs/
	// tweenmax_1.18.0_499ba64a23378545748ff12d372e59e9_min.js"></script>');
	// 		} else {
	// 		$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
	// <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
	// <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
	// <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');
	// 	}
	// 	}

	public function __construct(){
		parent::__construct(AppPath::getPath()."/template/predefined/dcrm/dynamic/assets/index.php");

		$this -> _assets -> add(new Asset(uniqid(rand()), AppPath::getPath()."/template/predefined/normal/standard/assets/style.css", AssetType::CSS, true));
		// $this -> _assets -> add(new Asset(uniqid(rand()), AppPath::getPath()."/template/predefined/normal/standard/assets/animation.js", AssetType::JS, true));

		/*$this -> _assets_scheme = array(
		'i1' =>
		 array(
			new Asset("TimelineLite", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/TimelineLite.min.js", AssetType::JS, true),
			new Asset("TweenLite", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/TweenLite.min.js", AssetType::JS, true),
			new Asset("CSSPlugin", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/plugins/CSSPlugin.min.js", AssetType::JS, true),
			new Asset("EasePack", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/easing/EasePack.min.js", AssetType::JS, true)),
			'i2' => array(new Asset("TweenMax", AppPath::getPath()."/engine/gsap/src/".GSAPEngine::getVersion()."/minified/TweenMax.min.js", AssetType::JS, true)));
		$this -> _imports = array('i1' => '<script src="TweenLite.min.js"></script>
<script src="TimelineLite.min.js"></script>
<script src="EasePack.min.js"></script>
<script src="CSSPlugin.min.js"></script>', 'i2' => '<script src="TweenMax.min.js"></script>');*/

		$this -> _imports = array('i1' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TimelineLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/easing/EasePack.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/plugins/CSSPlugin.min.js"></script>', 'i2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/'.GSAPEngine::getVersion().'/TweenMax.min.js"></script>');


		$this -> _extImport = "";


	}

	}

?>
