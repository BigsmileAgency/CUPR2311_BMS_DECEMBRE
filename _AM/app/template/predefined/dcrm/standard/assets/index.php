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
	<script src="https://s0.2mdn.net/ads/studio/Enabler.js"></script>
  	<!-- ReplaceValueProcess:import -->
    <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>
    <!-- ReplaceValueProcess:gsapinstance_null -->
    <!-- ReplaceValueProcess:custom-vars -->

    <?php if($testComputedStyleForFirefox) { ?>
    var _interval;
    <?php }  ?>

		window.onload = function(){
  			if (Enabler.isInitialized()) {
    			enablerInitHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.INIT, enablerInitHandler);
 			}
  		};

  		function enablerInitHandler(){

  			if (Enabler.isPageLoaded()) {
   		 		pageLoadedHandler();
  			} else {
   				Enabler.addEventListener(studio.events.StudioEvent.PAGE_LOADED, pageLoadedHandler);
  			}
  		}

  		function addListeners(){
  			document.getElementById('clickThroughBtn').addEventListener('click', bgExitHandler, false);
        <!-- ReplaceValueProcess:custom-events -->
  		}


  		function pageLoadedHandler() {

 			if (Enabler.isVisible()) {
    			adVisibilityHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.VISIBLE, adVisibilityHandler);
  			}
		}

		function adVisibilityHandler() {
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
      addListeners();

		}

		function init() {
			reset();
			initObjects();
			<!-- ReplaceValueProcess:custom-script -->
      <!-- ReplaceValueProcess:custom-init -->
		}


		function bgExitHandler(e) {
    		Enabler.exit('Background Exit');
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


		<!-- ReplaceValueProcess:custom-function -->


  	</script>
</head>
<body>
	<div id="container">
		<!-- ReplaceValueProcess:content -->
	</div>
  <div id="clickThroughBtn"></div>
</body>
</html>
