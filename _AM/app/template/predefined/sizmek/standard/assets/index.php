<!doctype html>
<html lang="<!-- ReplaceValueProcess:lang -->">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="generator" content="Powered by Big Smile Agency">
    <meta http-equiv="X-UA-Compatible" content="IE=edge<?php /*,chrome=1*/ ?>">
	<?php if($meta) { ?>
	<meta name="author" content="<!-- ReplaceValueProcess:author -->">
	<meta name="description" content="<!-- ReplaceValueProcess:description -->">
	<meta name="keywords" content="<!-- ReplaceValueProcess:keywords -->">
	<?php } ?>
	<title><!-- ReplaceValueProcess:title --></title>
    <script src="https://secure-ds.serving-sys.com/BurstingScript/EBLoader.js"></script>
  	<!-- ReplaceValueProcess:import -->
  	<style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>
		var adDiv;
      <!-- ReplaceValueProcess:gsapinstance_null -->
		<!-- ReplaceValueProcess:custom-vars -->

		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>

		function initEB() {
    		<?php if($devMode) { ?>
				startAd();
			<?php } else { ?>
				if (!EB.isInitialized()){
					EB.addEventListener(EBG.EventName.EB_INITIALIZED, startAd);
				}else{
					startAd();
				}
			<?php } ?>
		}

		function startAd() {
			<?php if($testComputedStyleForFirefox) { ?>
			_interval = setInterval(function(){
			    if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
			       clearInterval(_interval);
			<?php } ?>
			       <!-- ReplaceValueProcess:loaded-script -->
			<?php if($testComputedStyleForFirefox) { ?>

			    }
			}, 20);
			<?php } ?>
		}

      function init() {
        adDiv = document.getElementById("ad");
	    addEventListeners();
		reset();
		initObjects();
		<!-- ReplaceValueProcess:custom-script -->
		<!-- ReplaceValueProcess:custom-init -->
		      }

		function reset(){
			<!-- ReplaceValueProcess:gsapinit -->
		}

			  function initObjects(){
			<!-- ReplaceValueProcess:gsapinstance -->
			<!-- ReplaceValueProcess:gsapanimation -->
		}

		function launch(){
			<!-- ReplaceValueProcess:gsapplay -->
		}





		function addEventListeners() {
    		<?php if(!$devMode) { ?>
    			document.getElementById("clickThroughBtn").addEventListener("click", clickthrough);
			<?php } ?>
    		<!-- ReplaceValueProcess:custom-events -->
		}

		function clickthrough() {
    		EB.clickthrough();
		}

		<!-- ReplaceValueProcess:custom-function -->


		window.addEventListener("load", initEB);



  	</script>
</head>
<body>
	<div id="ad">
		<div id="container">
				<!-- ReplaceValueProcess:content -->
				<button id="clickThroughBtn" class="button clickthrough"></button>
		</div>
	</div>
</body>
</html>
