<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class NormalGSAPTemplate extends Template {

		public function __construct(){
			parent::__construct(AppPath::getPath()."/template/predefined/normal/standard/assets/index.php");

			$this -> _assets -> add(new Asset(uniqid(rand()), AppPath::getPath()."/template/predefined/normal/standard/assets/style.css", AssetType::CSS, true));
			$this -> _assets -> add(new Asset(uniqid(rand()), AppPath::getPath()."/template/predefined/normal/standard/assets/animation.js", AssetType::JS, true));
			
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
