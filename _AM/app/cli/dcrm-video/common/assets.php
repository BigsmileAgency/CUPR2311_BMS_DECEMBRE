<?php
	
	$assetCollection = new AssetCollection();

	[[splitText]]$assetCollection -> add(new Asset('splitText', AppPath::getPath().'/engine/gsap/src/'.GSAPEngine::getVersion().'/minified/utils/SplitText.min.js', AssetType::JS, false));
	[[!splitText]][[drawSVG]]$assetCollection -> add(new Asset('drawSvg', AppPath::getPath().'/engine/gsap/src/'.GSAPEngine::getVersion().'/minified/plugins/drawSVGPlugin.min.js', AssetType::JS, false));
	[[!drawSVG]][[morphSVG]]$assetCollection -> add(new Asset('morphSvg', AppPath::getPath().'/engine/gsap/src/'.GSAPEngine::getVersion().'/minified/plugins/morphSVGPlugin.min.js', AssetType::JS, false));[[!morphSVG]]

	$assetCollection -> add(new Asset('controls', 'common/assets/controls.svg', AssetType::SVG, true));

	//VIDEO INCLUDE
	$assetCollection -> add(new Asset('video_webm', 'common/assets/video.webm', AssetType::VIDEO, true));
	$assetCollection -> add(new Asset('video_mp4', 'common/assets/video.mp4', AssetType::VIDEO, true));
	$assetCollection -> add(new Asset('video_poster', 'common/assets/video.jpg', AssetType::VIDEO, true));

	[[exemple]]//EXEMPLE
		//$assetCollection -> add(new Asset('obj', 'common/assets/obj.svg', AssetType::SVG, false));
		
	//EXEMPLE IN LANGUAGE FOLDER
		//$assetCollection -> add(new Asset('obj1', 'common/assets/'.strtolower($language).'/obj1.svg', AssetType::SVG, false));
		

	//EXEMPLE IN FORMAT FOLDER
		//$assetCollection -> add(new Asset('obj2', 'common/assets/'.$format.'/obj2.png', AssetType::IMAGE, false));
		

	//EXEMPLE IN LANGUAGE AND FORMAT FOLDER
		//$assetCollection -> add(new Asset('obj3', 'common/assets/'.strtolower($language).'/'.$format.'/obj3.jpg', AssetType::IMAGE, false));
		

	//ASSET TYPE
		//AssetType::JS
		//AssetType::IMAGE
		//AssetType::SVG
		//AssetType::VIDEO
	[[!exemple]]

?>
